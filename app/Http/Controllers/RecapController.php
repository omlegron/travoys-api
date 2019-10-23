<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Exports\RestAreasExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class RecapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function export()
    {
        return Excel::download(new RestAreasExport, 'Rekap-rest-area_' . Carbon::now()->format('d-m-Y') . '.xlsx');
    }
}
