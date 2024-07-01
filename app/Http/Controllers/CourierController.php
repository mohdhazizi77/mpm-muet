<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Services\AuditLogService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CourierController extends Controller
{
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
            $html = '<button type="button" class="btn btn-soft-warning waves-effect waves-light btn-icon" style="margin-right: 10px;" id="show_edit_modal" value="' . $courier->id . '">
                   <i class="ri-edit-line"></i>
                </button>';
            $html = $html . '<button type="button" class="btn btn-soft-danger waves-effect waves-light btn-icon" id="delete" value="' . $courier->id . '">
                   <i class="ri-delete-bin-line"></i>
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
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required',
            'currency' => 'required|string|size:3',
            'duration' => 'required',
        ]);
    
        $courier = new Courier();
        $courier->name = $validatedData['name'];
        $courier->disp_name = $validatedData['name'];
        $courier->rate = $validatedData['rate'];
        $courier->currency = $validatedData['currency'];
        $courier->duration = $validatedData['duration'];
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required',
            'currency' => 'required|string|size:3',
            'duration' => 'required',
        ]);

        $courier = Courier::findOrFail($id);
        $old = [
            "name" => $courier->name,
            "disp_name" => $courier->disp_name,
            "rate" => $courier->rate,
            "currency" => $courier->currency,
            "duration" => $courier->duration,
        ];

        $courier->name = $validatedData['name'];
        $courier->disp_name = $validatedData['name'];
        $courier->rate = $validatedData['rate'];
        $courier->currency = $validatedData['currency'];
        $courier->duration = $validatedData['duration'];
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
