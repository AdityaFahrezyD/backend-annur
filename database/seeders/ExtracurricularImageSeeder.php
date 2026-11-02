<?php

namespace Database\Seeders;

use App\Models\Extracurricular;
use App\Models\ExtracurricularImage;
use Illuminate\Database\Seeder;

class ExtracurricularImageSeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    public function run(): void
    {
        $this->ensureSafeDemoDatabase();
        $roboticsClub = Extracurricular::query()->where('title', 'Klub Robotik')->first();

        if ($roboticsClub === null) {
            return;
        }

        $roboticsClub->images()->delete();
        $roboticsClub->images()->saveMany(ExtracurricularImage::factory()->count(2)->make());
    }
}
