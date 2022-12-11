<?php

namespace Hadihosseini88\Course\Tests\Feature;

use Hadihosseini88\Category\Models\Category;
use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\Course\Models\Lesson;
use Hadihosseini88\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
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

    public function test_permitted_user_can_update_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);
        $this->patch(route('lessons.update', [$course->id, $lesson->id]), [
            'title' => 'update title',
            'time' => 21,
            'is_free' => 0
        ]);
        $this->assertEquals('update title', Lesson::find(1)->title);

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.update', [$course->id, $lesson->id]), [
            'title' => 'update title 2',
            'time' => 25,
            'is_free' => 1
        ])->assertStatus(403);
        $this->assertEquals('update title', Lesson::find(1)->title);
    }

    public function test_permitted_user_can_accept_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->patch(route('lessons.accept', $lesson->id));
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(1)->confirmation_status);

        $this->actAsUser();
        $this->patch(route('lessons.accept', $lesson->id))->assertStatus(403);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.accept', $lesson->id))->assertStatus(403);
    }

    public function test_permitted_user_can_accept_all_lessons()
    {
        $this->actAsAdmin();

        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);

        $course2 = $this->createCourse();
        $this->createLesson($course2);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        $this->patch((route('lessons.acceptAll', $course->id)));

        $this->assertEquals($course->lessons()->count(), $course->lessons()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_ACCEPTED)->count());
        $this->assertEquals($course2->lessons()->count(), $course2->lessons()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_PENDING)->count());

        $this->actAsUser();
        $this->patch((route('lessons.acceptAll', $course2->id)))->assertStatus(403);
        $this->assertEquals($course2->lessons()->count(), $course2->lessons()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_PENDING)->count());

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch((route('lessons.acceptAll', $course2->id)))->assertStatus(403);
        $this->assertEquals($course2->lessons()->count(), $course2->lessons()->where('confirmation_status', Lesson::CONFIRMATION_STATUS_PENDING)->count());
    }

    public function test_permitted_user_can_accept_multiple_lessons()
    {
        $this->actAsAdmin();

        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);
        $this->createLesson($course);


        $this->patch(route('lessons.acceptMultiple', $course->id), ['ids' => '1,2']);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_ACCEPTED, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        $this->actAsUser();
        $this->patch(route('lessons.acceptMultiple', $course->id), ['ids' => '3'])->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);
    }


    public function test_permitted_user_can_reject_lesson()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $lesson = $this->createLesson($course);

        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(1)->confirmation_status);
        $this->patch(route('lessons.reject', $lesson->id));
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::find(1)->confirmation_status);

        $this->actAsUser();
        $this->patch(route('lessons.reject', $lesson->id))->assertStatus(403);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('lessons.reject', $lesson->id))->assertStatus(403);
    }

    public function test_permitted_user_can_reject_multiple_lessons()
    {
        $this->actAsAdmin();

        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);
        $this->createLesson($course);


        $this->patch(route('lessons.rejectMultiple', $course->id), ['ids' => '1,2']);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::find(1)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_REJECTED, Lesson::find(2)->confirmation_status);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);

        $this->actAsUser();
        $this->patch(route('lessons.rejectMultiple', $course->id), ['ids' => '3'])->assertStatus(403);
        $this->assertEquals(Lesson::CONFIRMATION_STATUS_PENDING, Lesson::find(3)->confirmation_status);
    }

    public function test_permitted_user_can_lock_lesson()
    {
        $this->actAsAdmin();

        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);

        $this->patch(route('lessons.lock', 1));
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(1)->status);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(2)->status);

        $this->actAsUser();
        $this->patch(route('lessons.lock', 2))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(2)->status);

    }

    public function test_permitted_user_can_unlock_lesson()
    {
        $this->actAsAdmin();

        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);

        $this->patch(route('lessons.lock', 1));
        $this->patch(route('lessons.lock', 2));
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(1)->status);


        $this->patch(route('lessons.unlock', 1));
        $this->assertEquals(Lesson::STATUS_OPENED, Lesson::find(1)->status);
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(2)->status);

        $this->actAsUser();
        $this->patch(route('lessons.unlock', 2))->assertStatus(403);
        $this->assertEquals(Lesson::STATUS_LOCKED, Lesson::find(2)->status);

    }

    public function test_permitted_user_can_destroy_lesson()
    {
        $this->actAsAdmin();

        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);

        $this->delete(route('lessons.destroy', [1, 1]))->assertStatus(200);
        $this->assertEquals(0, Lesson::find(1));
        $this->assertEquals(null, Lesson::find(1));

        $this->actAsUser();
        $this->delete(route('lessons.destroy', [1, 2]))->assertStatus(403);
        $this->assertEquals(1, Lesson::where('id',2)->count());


    }

    public function test_permitted_user_can_destroy_multiple_lessons()
    {
        $this->actAsAdmin();

        $course = $this->createCourse();
        $this->createLesson($course);
        $this->createLesson($course);
        $this->createLesson($course);


        $this->delete(route('lessons.destroyMultiple', $course->id), ['ids' => '1,2']);
        $this->assertEquals(null, Lesson::find(1));
        $this->assertEquals(null, Lesson::find(2));
        $this->assertEquals(3, Lesson::find(3)->id);


        $this->actAsUser();
        $this->delete(route('lessons.destroyMultiple', $course->id), ['ids' => '3'])->assertStatus(403);
        $this->assertEquals(1, Lesson::where('id',3)->count());

    }


    // ---------------------- private fuction for testing ---------------------- //

    private function createUser()
    {
        $this->actingAs(User::factory()->create());
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
