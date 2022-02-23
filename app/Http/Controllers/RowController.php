<?php

namespace App\Http\Controllers;

use App\Http\Requests\RowRequest;
use App\Imports\RowsImport;
use App\Jobs\ImportRowJob;
use App\Models\Row;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $rows = DB::table('rows')
            ->select('date')
            ->orderBy('date')
            ->groupBy('date')
            ->paginate(10);

        foreach ($rows as $key => $row) {
            $users = DB::table('rows')
                ->select(['id', 'name'])
                ->where('date', $row->date)
                ->get();
            $rows[$key]->users = $users;
        }

        return view('rows.index', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rows.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RowRequest $request)
    {
        if ($request->file('import_file')) {
            $filename = $request->file('import_file')->store('users');
            ImportRowJob::dispatch($filename);
        }
        $request->session()->flash('alert_message', 'File uploaded');
        $request->session()->flash('alert_type', 'success');
        return redirect()->route('rows.index');
    }

}
