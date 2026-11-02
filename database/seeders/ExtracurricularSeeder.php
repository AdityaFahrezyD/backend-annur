<?php

namespace Database\Seeders;

use App\Models\Extracurricular;
use App\Models\ExtracurricularImage;
use Illuminate\Database\Seeder;

class ExtracurricularSeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    public function run(): void
    {
        $this->ensureSafeDemoDatabase();
        ExtracurricularImage::query()->delete();
        Extracurricular::query()->delete();

        Extracurricular::factory()->create([
            'title' => 'Pramuka',
            'description' => 'Kegiatan kepanduan untuk melatih kemandirian, kedisiplinan, dan kerja sama.',
            'order' => 1,
        ]);

        Extracurricular::factory()->create([
            'title' => 'Klub Robotik',
            'description' => 'Kegiatan pengenalan robotika dan pemecahan masalah secara kreatif.',
            'order' => 2,
        ]);
    }
}
