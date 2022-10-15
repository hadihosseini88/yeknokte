<?php

namespace Hadihosseini88\Course\Tests\Feature;

use Hadihosseini88\Category\Models\Category;
use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Models\Lesson;
use Hadihosseini88\Course\Models\Season;
use Hadihosseini88\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_permitted_user_can_see_create_lesson_form()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->get(route('lessons.create', $course->id))->assertOk();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course = $this->createCourse();
        $this->get(route('lessons.create', $course->id))->assertOk();
    }

    public function test_normal_user_can_not_see_create_lesson_form()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->actAsUser();
        $this->get(route('lessons.create', $course->id))->assertStatus(403);

    }

    public function test_permitted_user_can_store_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('lessons.store', $course->id), [
            "title" => "lesson one",
            'time' => 5,
            'is_free' => 1,
            'lesson_file' => UploadedFile::fake()->create('aaa.mp4', 200),
        ]);
        $this->assertEquals(1, Lesson::query()->count());
    }

    public function test_only_allowed_extensions_can_be_uploaded()
    {
        $notAllowedExtensions = ['jpg', 'png', 'mp3'];
        $this->actAsAdmin();
        $course = $this->createCourse();

        foreach ($notAllowedExtensions as $extension) {
            $this->post(route('lessons.store', $course->id), [
                "title" => "lesson one",
                'time' => 5,
                'is_free' => 1,
                'lesson_file' => UploadedFile::fake()->create('aaa.' . $extension, 200),
            ]);
        }
        $this->assertEquals(0, Lesson::query()->count());
    }

    public function test_permitted_user_can_edit_lesson()
    {
//        $this->withoutExceptionHandling();
        $this->actAsAdmin();
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);
        $this->get(route('lessons.edit', [$course->id, $lesson->id]))->assertOk();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);
        $this->get(route('lessons.edit', [$course->id, $lesson->id]))->assertOk();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('lessons.edit', [$course->id, $lesson->id]))->assertStatus(403);


    }


    // ---------------------- private fuction for testing ---------------------- //

    private function createUser()
    {
        $this->actingAs(factory(User::class)->create());
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function actAsSuperAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
    }

    private function actAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    private function actAsUser()
    {
        $this->createUser();
    }

    private function createLesson($course)
    {
        return Lesson::create([
            'title' => 'lesson one',
            'slug' => 'lesson one',
            'course_id' => $course->id,
            'user_id' => auth()->id(),
        ]);
    }

    private function createCourse()
    {
        $data = $this->courseData() + ['confirmation_status' => Course::CONFIRMATION_STATUS_PENDING];
        unset($data['image']);
        return Course::create($data);
    }

    private function createCategory()
    {
        return Category::create(['title' => $this->faker->word, 'slug' => $this->faker->word]);
    }

    private function courseData()
    {
        $category = $this->createCategory();
        return [
            'teacher_id' => auth()->id(),
            'category_id' => $category->id,
            'title' => $this->faker->sentence(2),
            'slug' => $this->faker->sentence(2),
            'priority' => 12,
            'price' => 2000,
            'percent' => 60,
            'type' => Course::TYPE_CASH,
            'status' => Course::STATUS_NOT_COMPLETED,
            'image' => UploadedFile::fake()->image('banner.jpg'),

        ];
    }

}
