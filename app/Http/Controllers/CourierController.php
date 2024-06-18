<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CourierController extends Controller
{
    public function index(){
        return view('modules.admin.administration.courier.index');
    }

    public function getAjax(DataTables $dataTables,Request $request)
    {
        $data = $dataTables->eloquent(
            Courier::query()
        )
        ->setRowAttr(['align' => 'center'])
        ->addColumn('name', function ($courier) {
            return $courier->name;
        })
        ->addColumn('rate', function ($courier) {
            return $courier->rate;
        })
        ->addColumn('currency', function ($courier) {
            return $courier->currency;
        })
        ->addColumn('duration', function ($courier) {
            return $courier->duration;
        })
        ->addColumn('action', function ($courier) {
            $html = '<button type="button" class="btn btn-soft-warning waves-effect waves-light btn-icon" id="show_edit_modal" value="' . $courier->id . '">
                   <i class="ri-edit-line mr-2"></i>
                </button>';

            return $html;
        })
        ->order(function ($query) {
            $query->orderBy('updated_at', 'desc');
        })
        ->escapeColumns([])
        ->toJson();

        return $data;
    }

    public function store(Request $request)
    {
        $courier = new Courier();
        $courier->name = $request->name;
        $courier->disp_name = $request->name;
        $courier->rate = $request->rate;
        $courier->currency = $request->currency;
        $courier->duration = $request->duration;
        $courier->save();

        $old = [
            "name" => '',
            "disp_name" => '',
            "rate" => '',
            "currency" => '',
            "duration" => '',
        ];

        $new = [
            "name" => $courier->name,
            "disp_name" => $courier->disp_name,
            "rate" => $courier->rate,
            "currency" => $courier->currency,
            "duration" => $courier->duration,
        ];

        // Log the activity
        AuditLogService::log($courier, 'Create', $old, $new);

        return response()->json(['success' => true]);
    }
    
    public function update(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);
        $old = [
            "name" => $courier->name,
            "disp_name" => $courier->disp_name,
            "rate" => $courier->rate,
            "currency" => $courier->currency,
            "duration" => $courier->duration,
        ];

        $courier->name = $request->name;
        $courier->disp_name = $request->name;
        $courier->rate = $request->rate;
        $courier->currency = $request->currency;
        $courier->duration = $request->duration;
        $courier->save();

        $new = [
            "name" => $courier->name,
            "disp_name" => $courier->disp_name,
            "rate" => $courier->rate,
            "currency" => $courier->currency,
            "duration" => $courier->duration,
        ];

        foreach ($old as $key => $value) {
            if ($old[$key] === $new[$key]) {
                unset($old[$key]);
                unset($new[$key]);
            }
        }

        // Log the activity
        AuditLogService::log($courier, 'Update', $old, $new);

        return response()->json(['success' => true]);
    }
    
    public function destroy(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);
        $courier->delete();

        return response()->json(['success' => true]);
    }
}
