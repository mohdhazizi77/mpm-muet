<?php

namespace App\Http\Controllers;

use App\Exports\PosNewExport;
use App\Exports\PosProcessingPosXlsxExport;
use App\Exports\PosProcessingXlsxExport;
use Illuminate\Support\Facades\Config;
use App\Models\Pos;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\DataTables;

class PosProcessingController extends Controller
{
    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('modules.admin.pos.processing.index',
            compact([
                'user',
            ]));

    }

    public function getAjax(Request $request)
    {
        if ($request->ajax()) {

            $query = Pos::query()->where('id', '<>', '0')
                ->where('status', 'PROCESSING')
                ->orderBy('date', 'asc');

            $data = !empty($query) ? $query->get() : [];

            return DataTables::of($data)->addIndexColumn()->toJson();
        }
    }

    public function exportXlsx()
    {
        return Excel::download(new PosProcessingXlsxExport, 'processing.xlsx');
    }

    public function exportPosXlsx()
    {
        return Excel::download(new PosProcessingPosXlsxExport, 'pos.xlsx');
    }

    public function printPdf()
    {
        try {

            $url = 'http://localhost:8000/qrscan'; // Replace with your URL or data

            $qr = QrCode::size(50)->style('round')->generate(config('app.url'));

            $pdf = PDF::loadView('candidates.download-pdf', ['qr' => $qr])->setPaper('a4', 'portrait');

            return $pdf->download('MUET RESULT.pdf');

        } catch
        (Exception $e) {
            return back()->withError($e->getMessage());
        }
    }
}
