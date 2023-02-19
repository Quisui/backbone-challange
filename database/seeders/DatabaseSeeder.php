<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ZipCode;
use App\Services\Api\V1\DocumentReader\ReadDocument;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        if (!app()->environment('testing')) {
            $filePath = public_path('app') . '/CPdescarga.xls';
            $columnValues = (new ReadDocument)->readDocument('readFile', ['facadeName' => 'excel', 'filePath' => $filePath]);
            $zipCodeData = $columnValues['data_re_arranged'];
            foreach ($zipCodeData as $key => $zipCodeValues) {
                for ($i = 2; $i < count($zipCodeData); $i++) {
                    $zipCodeValues[$i]['created_at'] = Carbon::now();
                    $zipCodeValues[$i]['updated_at'] = Carbon::now();
                    DB::table('zip_codes')->insert($zipCodeValues[$i]);
                }
            }
        }
    }
}
