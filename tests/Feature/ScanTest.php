<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserScan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class ScanTest extends TestCase
{
    use RefreshDatabase;
 
    //util non connect ne peut pas scanner
    public function test_guest_can_start_a_scan(): void
    {
        Http::fake([
            'https://example.com/*' => Http::response(
                '<html><body><a href="/test">Test</a></body></html>',
                200
            ),
        ]);

        $response = $this->post('/start-scan', [
            'url' => 'https://example.com',
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
            'existing' => false,
        ]);
    }

    //teste la validation de l URL
    public function test_invalid_url_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/start-scan', [
            'url' => 'not-a-valid-url',
        ]);

        $response->assertSessionHasErrors('url');
    }


    //teste util peut acceder a son propre résultat
    public function test_user_can_access_his_own_scan_result(): void
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

        $this->actingAs($user)->withSession([
            'user_scan_id' => $scan->id,
        ]);

        $response = $this->get('/result');

        $response->assertStatus(200);
        $response->assertViewIs('result');
    }

    //util ne peut pas acceder au résult d un autre utilis
    public function test_user_cannot_access_another_users_scan_result(): void
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
            ->withSession([
                'user_scan_id' => $scan->id,
            ])
            ->get('/result');

        $response->assertStatus(403);
    }
 

    //verifie erreur 404 est renvoyé lrsq un scan n est présent en session
    public function test_scan_step_returns_404_without_scan_in_session(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->postJson('/scan-step');

        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'Scan utilisateur introuvable.',
        ]);
    }

    //teste scan est marqué comme terminé si y a plus de liens a visiter
    public function test_scan_step_finishes_scan_when_no_links_remain(): void
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
            'finished' => false,
        ]);

        $response = $this->actingAs($user)
            ->withSession([
                'user_scan_id' => $scan->id,
            ])
            ->postJson('/scan-step');

        $response->assertStatus(200);

        $response->assertJson([
            'finished' => true,
            'progress' => 100,
            'indexed' => 5,
            'broken' => 1,
            'skipped' => 2,
        ]);

        $this->assertDatabaseHas('user_scans', [
            'id' => $scan->id,
            'finished' => true,
        ]);
    }


    //vérifie qun scan<24h est reutilise au lieu de rescanner
    public function test_recent_scan_is_reused_instead_of_starting_a_new_scan(): void
    {
        $user = User::factory()->create();

        UserScan::create([
            'user_id' => $user->id,
            'website' => 'https://example.com',
            'base_url' => 'https://example.com',
            'host' => 'example.com',
            'to_visit' => [],
            'visited' => [
                'https://example.com',
            ],
            'broken_links' => [
                [
                    'url' => 'https://example.com/broken',
                    'status' => 404,
                ],
            ],
            'indexed' => 10,
            'broken' => 1,
            'skipped' => 2,
            'finished' => true,
            'updated_at' => now()->subHours(2),
        ]);

        $response = $this->actingAs($user)
            ->postJson('/start-scan', [
                'url' => 'https://example.com',
            ]);

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
            'existing' => true,
            'indexed' => 10,
            'broken' => 1,
            'skipped' => 2,
        ]);
    }
}