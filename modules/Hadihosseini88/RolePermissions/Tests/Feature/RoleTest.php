<?php

namespace Hadihosseini88\RolePermissions\Tests\Feature;

use Hadihosseini88\Course\Database\Seeds\RolePermissionTableSeeder;
use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\RolePermissions\Models\Role;
use Hadihosseini88\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_permitted_user_can_see_index()
    {
        $this->actionAsAdmin();
        $this->get(route('role-permissions.index'))->assertOk();
    }

    public function test_normal_user_can_not_see_index()
    {
        $this->actionAsUser();
        $this->get(route('role-permissions.index'))->assertStatus(403);
    }

    public function test_permitted_user_can_store_roles()
    {
        $this->actionAsAdmin();
        $this->post(route('role-permissions.store'), [
            'name' => 'test role',
            'permissions' => [
                Permission::PERMISSION_TEACH,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertRedirect(route('role-permissions.index'));

        $this->assertEquals(count(Role::$roles) + 1, Role::count());
    }

    public function test_normal_user_can_not_store_roles()
    {
        $this->actionAsUser();
        $this->post(route('role-permissions.store'), [
            'name' => 'test role',
            'permissions' => [
                Permission::PERMISSION_TEACH,
                Permission::PERMISSION_MANAGE_COURSES
            ]
        ])->assertStatus(403);

        $this->assertEquals(count(Role::$roles) + 0, Role::count());
    }

    public function test_permitted_user_can_see_edit()
    {
        $this->actionAsAdmin();
        $role = $this->createRole();
        $this->get(route('role-permissions.edit', $role->id))->assertOk();
    }

    public function test_normal_user_can_not_see_edit()
    {
        $this->actionAsUser();
        $role = $this->createRole();
        $this->get(route('role-permissions.edit', $role->id))->assertStatus(403);
    }

    public function test_permitted_user_can_update_roles()
    {
        $this->withoutExceptionHandling();
        $this->actionAsAdmin();
        $role = $this->createRole();
        $this->patch(route('role-permissions.update', $role->id), [
            'id' => $role->id,
            'name' => 'test role23',
            'permissions' => [
                Permission::PERMISSION_TEACH,
            ]
        ])->assertRedirect(route('role-permissions.index'));
        $this->assertEquals('test role23', $role->fresh()->name);
    }

    public function test_normal_user_can_not_update_roles()
    {
        $this->actionAsUser();
        $role = $this->createRole();
        $this->patch(route('role-permissions.update', $role->id), [
            'name' => 'test role',
            'permissions' => [
                Permission::PERMISSION_TEACH,
            ]
        ])->assertStatus(403);

        $this->assertEquals($role->name, $role->fresh()->name);
    }

    public function test_permitted_user_can_delete_role()
    {
        $this->actionAsAdmin();
        $role = $this->createRole();
        $this->delete(route('role-permissions.destroy', $role->id))->assertOk();
        $this->assertEquals(count(Role::$roles), Role::count());
    }

    public function test_normal_user_can_not_delete_role()
    {
        $this->actionAsAdmin();
        $role = $this->createRole();
        $this->actionAsUser();
        $this->delete(route('role-permissions.destroy', $role->id))->assertStatus(403);
        $this->assertEquals(count(Role::$roles) +1 , Role::count());
    }


    private function createUser()
    {
        $this->actingAs(factory(User::class)->create());
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
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS);
    }

    private function actionAsUser()
    {
        $this->createUser();
    }

    public function createRole()
    {
        return Role::create(['name' => 'test role'])->syncPermissions([Permission::PERMISSION_TEACH, Permission::PERMISSION_MANAGE_CATEGORIES]);
    }

}
