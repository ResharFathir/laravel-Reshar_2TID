<?php

namespace Tests\Feature;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_renders_the_user_navigation_link(): void
    {
        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee(route('admin.user.index'), false);
    }

    public function test_user_management_pages_render_with_their_route_names_and_data(): void
    {
        $user = User::factory()->create();

        $this->get(route('admin.user.index'))
            ->assertOk()
            ->assertSee($user->email)
            ->assertSee(route('admin.user.create'), false)
            ->assertSee(route('admin.user.edit', $user), false);

        $this->get(route('admin.user.create'))
            ->assertOk()
            ->assertSee(route('admin.user.store'), false);

        $this->get(route('admin.user.edit', $user))
            ->assertOk()
            ->assertSee($user->email)
            ->assertSee(route('admin.user.update', $user), false);
    }

    public function test_customer_edit_page_uses_customer_data_and_routes(): void
    {
        $customer = Pelanggan::create([
            'first_name' => 'Ayu',
            'last_name' => 'Sari',
            'email' => 'ayu@example.com',
        ]);

        $this->get(route('pelanggan.edit', $customer->pelanggan_id))
            ->assertOk()
            ->assertSee('Edit Pelanggan')
            ->assertSee('Ayu')
            ->assertSee(route('pelanggan.update', $customer->pelanggan_id), false);
    }
}
