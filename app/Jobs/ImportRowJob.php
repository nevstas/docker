<?php

namespace App\Jobs;

use App\Imports\RowsImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportRowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $redis_key = 'row:import:' . $this->file;
        $import = new RowsImport($this->file);
        Excel::import($import, $this->file);
        $count_rows_imported = $import->getRowCount();
        Redis::set($redis_key, Redis::get($redis_key) + $count_rows_imported);
        if ($count_rows_imported == config('app.row_import_limit')) {
            //файл импортировали не до конца, запускаем задачу снова
            ImportRowJob::dispatch($this->file);
        } else {
            //файл импортировали до конца
            //удаляем не нужный key из redis
            Redis::del($redis_key);
            //удаляем не нужный файл из storage
            Storage::delete($this->file);
        }

    }
}
