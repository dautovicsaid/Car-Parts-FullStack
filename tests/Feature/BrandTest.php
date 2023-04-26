<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;
    private User $superAdmin;
    private array $brandData;
    private Brand $brand;

    public function setUp(): void
    {
        parent::setUp();
        Role::factory()->create(['id' => 1, 'name' => 'Super Admin']);
        Role::factory()->create( ['id' => 2, 'name' => 'Admin']);
        Role::factory()->create( ['id' => 3, 'name' => 'User']);
        $this->user = $this->createUsers(Role::USER_ID);
        $this->admin = $this->createUsers(Role::ADMIN_ID);
        $this->superAdmin = $this->createUsers(Role::SUPER_ADMIN_ID);
        $this->brand = Brand::factory()->create();
        $this->brandData = [
            'name' => 'Test Brand',
            'description' => 'Test Description',
        ];
    }

    /**
     * A basic feature test example.
     */
    public function test_brand_is_displayed_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('brands.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_brand_is_displayed_for_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('brands.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_brand_is_not_displayed_for_user(): void
    {
        $response = $this->actingAs($this->user)->get(route('brands.index'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_brand_create_is_not_displayed_for_admin(): void
    {
        $response = $this->actingAs($this->admin)->get(route('brands.create'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_brand_create_is_displayed_for_super_admin(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('brands.create'));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_brand_create_is_not_displayed_for_user(): void
    {
        $response = $this->actingAs($this->user)->get(route('brands.create'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_brand_store_for_admin_unsuccessful(): void
    {
        $response = $this->actingAs($this->admin)->post(route('brands.store'), $this->brandData);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_brand_store_for_super_admin_successful(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(route('brands.store'), $this->brandData);
        $lastBrand = Brand::query()->orderBy('id', 'desc')->first();

        $response->assertRedirect(route('brands.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('brands', $this->brandData);
        $this->assertEquals($this->brandData['name'], $lastBrand->name);
        $this->assertEquals($this->brandData['description'], $lastBrand->description);
    }

    public function test_brand_store_for_super_admin_unsuccessful(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(route('brands.store'), [
            'name' => '',
            'description' => '',
        ]);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_brand_store_for_user_unsuccessful(): void
    {
        $response = $this->actingAs($this->user)->post(route('brands.store'), $this->brandData);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_brand_edit_for_admin_unsuccessful(): void
    {
        $response = $this->actingAs($this->admin)->get(route('brands.edit', $this->brand->id));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_brand_edit_for_super_admin_successful(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('brands.edit', $this->brand->id));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_brand_edit_for_user_unsuccessful(): void
    {
        $response = $this->actingAs($this->user)->get(route('brands.edit', $this->brand->id));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_brand_update_for_admin_unsuccessful(): void
    {
        $response = $this->actingAs($this->admin)->post(route('brands.update', $this->brand->id), $this->brandData);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_brand_update_for_super_admin_successful(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(route('brands.update', $this->brand->id), $this->brandData);

        $response->assertRedirect(route('brands.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('brands', $this->brandData);
        $this->assertDatabaseMissing('brands', $this->brand->toArray());
    }

    public function test_brand_update_for_super_admin_unsuccessful(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(route('brands.update', $this->brand->id), [
            'name' => '',
            'description' => '',
        ]);

        $response->assertRedirect(url()->previous());
        $response->assertSessionHasErrors(['name']);
    }

    public function test_brand_update_for_user_unsuccessful(): void
    {
        $response = $this->actingAs($this->user)->post(route('brands.update', $this->brand->id), $this->brandData);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_brand_destroy_for_admin_unsuccessful(): void
    {
        $response = $this->actingAs($this->admin)->delete(route('brands.destroy', $this->brand->id));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_brand_destroy_for_super_admin_successful(): void
    {
        $response = $this->actingAs($this->superAdmin)->delete(route('brands.destroy', $this->brand->id));

        $response->assertRedirect(url()->previous());
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('brands', $this->brand->toArray());
    }

    public function test_brand_destroy_for_user_unsuccessful(): void
    {
        $response = $this->actingAs($this->user)->delete(route('brands.destroy', $this->brand->id));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_export_for_admin_successful(): void
    {
        $response = $this->actingAs($this->admin)->get(route('export.brands'));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_export_for_super_admin_successful(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('export.brands'));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_export_for_user_unsuccessful(): void
    {
        $response = $this->actingAs($this->user)->get(route('export.brands'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    private function createUsers(int $role_id): User
    {
        return User::factory()->create(['role_id' => $role_id]);
    }
}
