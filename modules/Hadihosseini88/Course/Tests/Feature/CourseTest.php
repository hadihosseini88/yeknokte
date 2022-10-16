<?php

namespace Hadihosseini88\Course\Tests\Feature;

use Hadihosseini88\Category\Models\Category;
use Hadihosseini88\Course\Models\Course;
use Hadihosseini88\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_permitted_user_can_see_courses_index()
    {
        $this->actionAsAdmin();
        $this->get(route('courses.index'))->assertOk();

        $this->actionAsSuperAdmin();
        $this->get(route('courses.index'))->assertOk();
    }

    public function test_normal_user_can_not_see_courses_index()
    {
        $this->actionAsUser();
        $this->get(route('courses.index'))->assertStatus(403);
    }

    public function test_permitted_user_can_create_course()
    {
        $this->actionAsAdmin();
        $this->get(route('courses.create'))->assertOk();

        $this->actionAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.create'))->assertOk();
    }

    public function test_normal_user_can_not_create_course()
    {
        $this->actionAsUser();
        $this->get(route('courses.create'))->assertStatus(403);
    }

    public function test_permitted_user_can_store_course()
    {
        $this->actionAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES, Permission::PERMISSION_TEACH);
        Storage::fake('local');
        $response = $this->post(route('courses.store'), $this->courseData());

        $response->assertRedirect(route('courses.index'));
        $this->assertEquals(Course::count(),1);
    }

    public function test_permitted_user_can_edit_course()
    {
        $this->actionAsAdmin();
        $course = $this->createCourse();
        $this->get(route('courses.edit', $course->id))->assertOk();

        $this->actionAsUser();
        $course = $this->createCourse();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.edit', $course->id))->assertOk();
    }

    public function test_permitted_user_can_not_edit_other_users_courses()
    {
        $this->actionAsUser();
        $course = $this->createCourse();
        $this->actionAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.edit', $course->id))->assertStatus(403);
    }

    public function test_normal_user_can_not_edit_course()
    {
        $this->actionAsUser();
        $course = $this->createCourse();
        $this->get(route('courses.edit', $course->id))->assertStatus(403);
    }

    public function test_permitted_user_can_update_course()
    {
        $this->actionAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES, Permission::PERMISSION_TEACH);
        $course  = $this->createCourse();
        $this->patch(route('courses.update',$course->id),[
            'teacher_id' => auth()->id(),
            'category_id' => $course->category->id,
            'title' => 'updated title',
            'slug' => 'updated slug',
            'priority' => 2,
            'price' => 5000,
            'percent' => 30,
            'type' => Course::TYPE_CASH,
            'status' => Course::STATUS_COMPLETED,
            'image' => UploadedFile::fake()->image('banner1.jpg'),

        ])->assertRedirect(route('courses.index'));

        $course = $course->fresh();
        $this->assertEquals('updated title',$course->title);
    }

    public function test_normal_user_can_not_update_course()
    {
        $this->actionAsAdmin();
        $course  = $this->createCourse();
        $this->actionAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_TEACH);

        $this->patch(route('courses.update',$course->id),[
            'teacher_id' => auth()->id(),
            'category_id' => $course->category->id,
            'title' => 'updated title',
            'slug' => 'updated slug',
            'priority' => 2,
            'price' => 5000,
            'percent' => 30,
            'type' => Course::TYPE_CASH,
            'status' => Course::STATUS_COMPLETED,
            'image' => UploadedFile::fake()->image('banner1.jpg'),

        ])->assertStatus(403);
    }

    public function test_permitted_user_can_delete_course()
    {
        $this->actionAsAdmin();
        $course  = $this->createCourse();
        $this->delete(route('courses.destroy',$course->id))->assertOk();
        $this->assertEquals(0,Course::count());
    }
    public function test_normal_user_can_not_delete_course()
    {
        $this->actionAsAdmin();
        $course  = $this->createCourse();
        $this->actionAsUser();
        $this->delete(route('courses.destroy',$course->id))->assertStatus(403);
        $this->assertEquals(1,Course::count());
    }

    public function test_permitted_user_can_change_confirmation_status_course()
    {
        $this->actionAsAdmin();
        $course  = $this->createCourse();
        $this->patch(route('courses.accept',$course->id))->assertOk();
        $this->patch(route('courses.reject',$course->id))->assertOk();
        $this->patch(route('courses.lock',$course->id))->assertOk();
    }

    public function test_normal_user_can_not_change_confirmation_status_course()
    {
        $this->actionAsAdmin();
        $course  = $this->createCourse();
        $this->actionAsUser();
        $this->patch(route('courses.accept',$course->id))->assertStatus(403);
        $this->patch(route('courses.reject',$course->id))->assertStatus(403);
        $this->patch(route('courses.lock',$course->id))->assertStatus(403);
    }


    private function createUser()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function actionAsSuperAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_SUPER_ADMIN);
    }

    private function actionAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    private function actionAsUser()
    {
        $this->createUser();
    }

    private function createCourse()
    {
        $data  = $this->courseData() + ['confirmation_status'=> Course::CONFIRMATION_STATUS_PENDING];
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
