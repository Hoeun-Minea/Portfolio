<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'លិខិតរដ្ឋបាល និងបទបញ្ជា', 'desc' => 'លិខិតបង្គាប់ការ លិខិតសរសើរ និងឯកសាររដ្ឋបាល'],
            ['name' => 'កម្មវិធីសិក្សា និងផែនការ', 'desc' => 'ផែនការបង្រៀនប្រចាំឆ្នាំ កម្មវិធីសិក្សាលម្អិត'],
            ['name' => 'កិច្ចតែងការបង្រៀន (Lesson Plans)', 'desc' => 'កិច្ចតែងការបង្រៀនតាមមុខវិជ្ជា និងថ្នាក់'],
            ['name' => 'ស្លាយបង្រៀន និងមេរៀន (Presentations)', 'desc' => 'Slide PowerPoint, Keynote និង Media សិក្សា'],
            ['name' => 'ស្នាដៃ និងការអភិវឌ្ឍវិជ្ជាជីវៈ (CPD)', 'desc' => 'វិញ្ញាបនបត្របណ្តុះបណ្តាល និងស្នាដៃស្រាវជ្រាវ'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name']) ?: Str::random(8)],
                ['name' => $cat['name'], 'description' => $cat['desc']]
            );
        }
    }
}
