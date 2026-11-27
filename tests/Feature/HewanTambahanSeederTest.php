<?php

namespace Tests\Feature;

use App\Models\Hewan;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HewanTambahanSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_adds_thirty_varied_animals_with_photos(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(50, Hewan::count());
        $this->assertSame(0, Hewan::whereNull('foto_url')->count());
        $this->assertDatabaseHas('hewans', ['nama' => 'Suki', 'ras' => 'Siamese']);
        $this->assertDatabaseHas('hewans', ['nama' => 'Biru', 'ras' => 'Cupang Halfmoon']);
    }
}
