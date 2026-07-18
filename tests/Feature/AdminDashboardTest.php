<?php

namespace Tests\Feature;

use App\Models\FoodSpot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_shows_compact_pending_approval_cards(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $seller = User::factory()->create(['role' => 'seller']);

        FoodSpot::create([
            'user_id' => $seller->id,
            'name' => 'Hot Bites Corner',
            'description' => 'A sample spot',
            'area' => 'Dhanmondi',
            'address' => 'House 10',
            'price_range' => 'budget',
            'is_approved' => false,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200)
            ->assertSee('Pending Approval Queue')
            ->assertSee('Hot Bites Corner')
            ->assertSee('Approve Request')
            ->assertSee('Remove Request');
    }
}
