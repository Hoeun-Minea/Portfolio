<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds for ICT categories.
     * មិនបញ្ចូលទិន្នន័យនិម្មិតទេ ទុកប្រព័ន្ធឱ្យនៅស្អាតសម្រាប់លោកគ្រូ ហឿន មិនា ប្រើប្រាស់ផ្ទាល់។
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'កិច្ចតែងការបង្រៀន ICT (Lesson Plans)', 'desc' => 'កិច្ចតែងការបង្រៀនមុខវិជ្ជាព័ត៌មានវិទ្យា និងបច្ចេកវិទ្យា'],
            ['name' => 'ស្លាយបង្រៀន និងមេឌៀ (Slide Presentations)', 'desc' => 'ស្លាយបង្រៀន PowerPoint, មេរៀនឌីជីថល និង Video សិក្សា'],
            ['name' => 'កម្មវិធីសិក្សា និងផែនការ (Curriculum)', 'desc' => 'ផែនការបង្រៀនប្រចាំឆ្នាំ កម្មវិធីសិក្សាលម្អិត និងកាលវិភាគ'],
            ['name' => 'លិខិតរដ្ឋបាល និងបទបញ្ជា (Administration)', 'desc' => 'លិខិតបង្គាប់ការ លិខិតសរសើរ និងឯកសាររដ្ឋបាលសាលា'],
            ['name' => 'ស្នាដៃ វិញ្ញាបនបត្រ និង CPD (Certificates & Awards)', 'desc' => 'វិញ្ញាបនបត្របណ្តុះបណ្តាល ស្នាដៃស្រាវជ្រាវ និងការអភិវឌ្ឍវិជ្ជាជីវៈ'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat['name']],
                ['slug' => Str::slug($cat['name']) ?: Str::random(8), 'description' => $cat['desc']]
            );
        }
    }
}
