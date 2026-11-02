<?php

namespace Database\Seeders;

use App\Models\OrganizationStructure;
use Illuminate\Database\Seeder;

class OrganizationStructureSeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    public function run(): void
    {
        $this->ensureSafeDemoDatabase();
        OrganizationStructure::query()->delete();

        $chair = OrganizationStructure::factory()->create([
            'name' => 'Ketua Yayasan',
            'position' => 'Ketua',
            'order' => 1,
        ]);

        OrganizationStructure::factory()->create([
            'name' => 'Sekretaris Yayasan',
            'position' => 'Sekretaris',
            'parent_id' => $chair->id,
            'order' => 1,
        ]);

        OrganizationStructure::factory()->create([
            'name' => 'Bendahara Yayasan',
            'position' => 'Bendahara',
            'parent_id' => $chair->id,
            'order' => 2,
        ]);
    }
}
