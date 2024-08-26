<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BookTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    #[Test]
    public function it_can_create_a_book(): void
    {
        // Simulace autentizovaného uživatele
        $user = User::factory()->create();

        // Data k odeslání
        $data = [
            'title' => $this->faker->sentence,
            'author_id' => 1,
        ];

        // Odeslání POST requestu s autentizací
        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/new-book', $data);

        // Ověření, že request byl úspěšný
        $response->assertStatus(201);

        // Ověření, že data byla zapsána do databáze
        $this->assertDatabaseHas('books', $data);
    }
}
