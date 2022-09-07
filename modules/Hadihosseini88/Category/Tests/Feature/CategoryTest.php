<?php

namespace Hadihosseini88\Category\Tests\Feature;

use Hadihosseini88\Category\Models\Category;
use Hadihosseini88\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_authenticated_user_can_see_categories_panel()
    {
        $this->actionAsAdmin();

//        $this->assertAuthenticated();
        $this->get(route('categories.index'))->assertOk();
    }

    public function test_can_create_category()
    {
        $this->actionAsAdmin();
        $this->createCategory();
        $this->assertEquals(1,Category::all()->count());
    }

    public function test_can_update_category()
    {
        $newTitle ='hadi';
        $this->actionAsAdmin();
        $this->createCategory();
        $this->assertEquals(1,Category::all()->count());
        $this->patch(route('categories.update',1),['title'=>$newTitle,'slug'=>$this->faker->word]);
        $this->assertEquals(1,Category::whereTitle($newTitle)->count());
    }

    public function test_can_delete_category()
    {
        $this->actionAsAdmin();
        $this->createCategory();
        $this->assertEquals(1,Category::all()->count());

        $this->delete(route('categories.destroy',1))->assertOk();
    }

    private function actionAsAdmin()
    {
        $this->actingAs(factory(User::class)->create());
    }

    private function createCategory(){
        $this->post(route('categories.store'),['title'=>$this->faker->word,'slug'=>$this->faker->word]);
    }

}
