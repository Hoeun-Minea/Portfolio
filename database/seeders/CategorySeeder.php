<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Document;
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

        // Add sample demo documents if empty
        if (Document::count() === 0) {
            $catPlan = Category::where('name', 'like', '%កិច្ចតែងការ%')->first();
            $catSlide = Category::where('name', 'like', '%ស្លាយ%')->first();
            $catCert = Category::where('name', 'like', '%ស្នាដៃ%')->first();
            $catAdmin = Category::where('name', 'like', '%លិខិតរដ្ឋបាល%')->first();

            Document::create([
                'category_id' => $catPlan?->id ?? 1,
                'title' => 'កិច្ចតែងការបង្រៀន៖ មូលដ្ឋានគ្រឹះនៃបណ្ដាញកុំព្យូទ័រ និងអ៊ីនធឺណិត (Computer Networks)',
                'file_path' => 'documents/sample_networking.pdf',
                'file_type' => 'pdf',
                'file_size' => '2.4 MB',
                'academic_year' => '2024-2025',
                'description' => 'កិច្ចតែងការគំរូបង្រៀនសិស្សថ្នាក់ទី១០ អំពីបណ្តាញ LAN, WAN, IP Address និងការការពារសុវត្ថិភាពលើអ៊ីនធឺណិត។',
                'is_portfolio' => true,
            ]);

            Document::create([
                'category_id' => $catSlide?->id ?? 2,
                'title' => 'ស្លាយបង្រៀន៖ ការសរសេរកូដគេហទំព័រ HTML5 & CSS3 កម្រិតដំបូង',
                'file_path' => 'documents/sample_web_intro.pptx',
                'file_type' => 'pptx',
                'file_size' => '5.8 MB',
                'academic_year' => '2024-2025',
                'description' => 'Slide បទបង្ហាញសម្រាប់បង្រៀនសិស្សអនុវត្តសរសេរកូដបង្កើតគេហទំព័រផ្ទាល់ខ្លួនក្នុងបន្ទប់កុំព្យូទ័រ។',
                'is_portfolio' => true,
            ]);

            Document::create([
                'category_id' => $catCert?->id ?? 5,
                'title' => 'វិញ្ញាបនបត្របណ្តុះបណ្តាល៖ គរុកោសល្យបច្ចេកវិទ្យាអប់រំ និងការបង្រៀនឌីជីថល (ICT in Education)',
                'file_path' => 'documents/sample_certificate.pdf',
                'file_type' => 'pdf',
                'file_size' => '1.2 MB',
                'academic_year' => '2023-2024',
                'description' => 'វិញ្ញាបនបត្រទទួលស្គាល់ការបញ្ចប់វគ្គបណ្តុះបណ្តាលស្តីពីការបញ្ចូលបច្ចេកវិទ្យាទៅក្នុងការអប់រំទំនើប។',
                'is_portfolio' => true,
            ]);

            Document::create([
                'category_id' => $catAdmin?->id ?? 4,
                'title' => 'លិខិតបង្គាប់ការទទួលបន្ទុកបន្ទប់កុំព្យូទ័រ និងប្រព័ន្ធព័ត៌មានវិទ្យាសាលា',
                'file_path' => 'documents/sample_admin_letter.docx',
                'file_type' => 'docx',
                'file_size' => '450 KB',
                'academic_year' => '2024-2025',
                'description' => 'លិខិតចាត់តាំងគ្រប់គ្រងបន្ទប់ Lab កុំព្យូទ័រ និងបណ្តាញ Network សាលារៀន។',
                'is_portfolio' => false,
            ]);
        }
    }
}
