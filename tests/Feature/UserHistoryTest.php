<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserScan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserHistoryTest extends TestCase
{
    use RefreshDatabase;

    //verif si util pas connect peut acceder a historique
    public function test_guest_cannot_access_history(): void
    {
        $response = $this->get('/history');

        $response->assertRedirect('/login');
    }

    //verif un util connect peut consult son historique
    public function test_authenticated_user_can_access_history(): void
    {
        $user = User::factory()->create();

        UserScan::create([
            'user_id' => $user->id,
            'website' => 'https://example.com',
            'base_url' => 'https://example.com',
            'host' => 'example.com',
            'to_visit' => [],
            'visited' => [],
            'broken_links' => [],
            'indexed' => 5,
            'broken' => 1,
            'skipped' => 2,
            'finished' => true,
        ]);

        $response = $this->actingAs($user)->get('/history');

        $response->assertStatus(200);
        $response->assertViewIs('user.history');
    }


    //verifie util peut consult le détail de son scan
    public function test_user_can_view_his_own_scan_history_details(): void
    {
        $user = User::factory()->create();

        $scan = UserScan::create([
            'user_id' => $user->id,
            'website' => 'https://example.com',
            'base_url' => 'https://example.com',
            'host' => 'example.com',
            'to_visit' => [],
            'visited' => [],
            'broken_links' => [],
            'indexed' => 5,
            'broken' => 1,
            'skipped' => 2,
            'finished' => true,
        ]);

        $response = $this->actingAs($user)
            ->get("/history/{$scan->id}");

        $response->assertStatus(200);
        $response->assertViewIs('user.history-show');
    }

    //verif un util ne peut pas consult detail du scan d un autre utilisat
    public function test_user_cannot_view_another_users_scan_history_details(): void
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $scan = UserScan::create([
            'user_id' => $owner->id,
            'website' => 'https://example.com',
            'base_url' => 'https://example.com',
            'host' => 'example.com',
            'to_visit' => [],
            'visited' => [],
            'broken_links' => [],
            'indexed' => 5,
            'broken' => 1,
            'skipped' => 2,
            'finished' => true,
        ]);

        $response = $this->actingAs($otherUser)
            ->get("/history/{$scan->id}");

        $response->assertStatus(403);
    }
}
