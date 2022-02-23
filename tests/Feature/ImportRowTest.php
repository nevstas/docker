<?php

namespace Tests\Feature;

use App\Exports\RowsExport;
use App\Jobs\ImportRowJob;
use App\Models\Row;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class ImportRowTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testCanImportUsers()
    {

        $import_arr = [
            ['id', 'name', 'date']
        ];
        for ($i = 1; $i <= 100; $i++) {
            $import_arr[] = [
                'id' => $i,
                'name' => $this->faker->name,
                'date' => $this->faker->dateTimeBetween($startDate = '-365 days', $endDate = 'now')->format("d.m.Y"),
            ];
        }

        Excel::store(new RowsExport($import_arr), 'users/test.xlsx', 'local');

        $import = [
            'import_file' => new UploadedFile(
                storage_path('app/users/test.xlsx'),
                'test.xlsx',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                null,
                true
            ),
        ];

        $this->post(route('rows.store'), $import)
            ->assertRedirect(route('rows.index'));

        $this->assertDatabaseCount('rows', 100);

        $this->assertDatabaseHas('rows', [
            'id' => $import_arr[1]['id'],
            'name' => $import_arr[1]['name'],
        ]);
    }




}
