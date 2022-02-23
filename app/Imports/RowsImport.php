<?php

namespace App\Imports;

use App\Models\Row;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RowsImport implements ToModel, WithStartRow, WithLimit, WithCalculatedFormulas
{
    use Importable;

    private $rows = 0;
    private $file = '';

    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row[0])) {
            return null;
        }

        ++$this->rows;

        if (is_string($row[2])) {
            $date = Carbon::parse($row[2])->format('Y-m-d');
        } else {
            $date = Date::excelToDateTimeObject($row[2])->format('Y-m-d');
        }

        return new Row([
            'id'     => (int)$row[0],
            'name'    => $row[1],
            'date' => $date,
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        $redis_key = 'row:import:' . $this->file;

        $start = Redis::get($redis_key);
        if (!$start) {
            $start = 2;
            Redis::set($redis_key, 2);
        }
        return $start;
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        return config('app.row_import_limit');
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
