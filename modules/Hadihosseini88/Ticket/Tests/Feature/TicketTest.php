<?php

namespace Hadihosseini88\Ticket\Tests\Feature;

use Hadihosseini88\RolePermissions\Database\Seeds\RolePermissionTableSeeder;
use Hadihosseini88\RolePermissions\Models\Permission;
use Hadihosseini88\Ticket\Models\Ticket;
use Hadihosseini88\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_user_can_see_tickets()
    {
        $this->actionAsUser();
        $this->get(route('tickets.index'))->assertOk();
    }

    public function test_user_can_see_create_tickets()
    {
        $this->actionAsUser();
        $this->get(route('tickets.create'))->assertOk();
    }

    public function test_user_can_store_ticket()
    {
        $this->actionAsUser();
        $this->createTicket();
        $this->assertEquals(1,Ticket::all()->count());
    }

    public function test_permitted_user_can_delete_ticket()
    {
        $this->actionAsAdmin();
        $this->createTicket();
        $this->assertEquals(1,Ticket::all()->count());

        $this->delete(route('tickets.destroy',1))->assertOk();
        $this->assertEquals(0,Ticket::all()->count());
    }

    public function test_normal_user_can_not_delete_ticket()
    {
        $this->actionAsUser();
        $this->createTicket();
        $this->assertEquals(1,Ticket::all()->count());

        $this->delete(route('tickets.destroy',1))->assertStatus(403);
        $this->assertEquals(1,Ticket::all()->count());
    }




    private function actionAsAdmin()
    {
        $this->seed(RolePermissionTableSeeder::class);
        $this->actingAs(User::factory()->create());
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_TICKETS);
    }

    private function actionAsUser()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function createTicket(){
        return $this->post(route('tickets.store'),['title'=>$this->faker->word,'body'=>$this->faker->word]);
    }


}
