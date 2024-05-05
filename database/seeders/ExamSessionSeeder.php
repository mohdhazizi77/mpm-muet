<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ExamSession;

class ExamSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //template
        // ExamSession::create([
        //     'name' => '',
        //     'year' => '',
        //     'exam_type' => '',
        // ]);

        ExamSession::create([
            'name' => 'SESSION 1',
            'year' => '2023',
            'exam_type' => 'MUET',
        ]);

        ExamSession::create([
            'name' => 'SESSION 2',
            'year' => '2023',
            'exam_type' => 'MUET',
        ]);

        ExamSession::create([
            'name' => 'SESSION 1',
            'year' => '2017',
            'exam_type' => 'MUET',
        ]);
        ExamSession::create([
            'name' => 'SESSION 2',
            'year' => '2021',
            'exam_type' => 'MUET',
        ]);
    }
}
