<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\penjualanModel;
use Illuminate\Support\Facades\Validator;

class penjualanController extends Controller
{
    public function index()
    {
        $penjualan = penjualanModel::all();

        return response()->json(['data' => $penjualan], 200);
    }
    public function create(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'qty' => ['required', 'integer', 'min:0'],
            'cost' => 'required|numeric',
            'price' => 'required',
        ]);
    

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $lastQtyBalance = PenjualanModel::latest('date')->value('qty_balance');
        $lastValueBalance = PenjualanModel::latest('date')->value('value_balance');
    
     
        $totalCost = $request->input('qty') * $request->input('cost');
        $qtyBalance = $lastQtyBalance + $request->input('qty');
        $valueBalance = $lastValueBalance + ($request->input('qty') * $request->input('cost'));
        $hpp = $lastValueBalance / $lastQtyBalance;
    

        $penjualan = PenjualanModel::create([
            'description' => $request->input('description'),
            'date' => today()->format('Y-m-d'),
            'qty' => $request->input('qty'),
            'cost' => $request->input('cost'),
            'price' => $request->input('price'),
            'total_cost' => $totalCost,
            'qty_balance' => $qtyBalance,
            'value_balance' => $valueBalance,
            'hpp' => $hpp,
        ]);
    
        return response()->json(['data' => $penjualan], 201);
    }
    public function update(Request $request, $id)
    {
         $validator = Validator::make($request->all(), [
            'description' => 'required',
            'qty' => 'required',
            'cost' => 'required|numeric',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $penjualan = PenjualanModel::find($id);

        if (!$penjualan) {
            return response()->json(['error' => 'Data tidak di temukan'], 404);
        }
        var_dump($request->input('qty') * $request->input('cost'));
        $penjualan->update([
            'description' => $request->input('description'),
            'qty' => $request->input('qty'),
            'cost' => $request->input('cost'),
            'price' => $request->input('price'),
            'total_cost' =>  $request->input('qty') * $request->input('cost'),
            'qty_balance' => $penjualan->qty_balance + $request->input('qty'),
            'value_balance' => $penjualan->value_balance + ($request->input('qty') * $request->input('cost')),
            'hpp' => ($penjualan->qty_balance != 0) ? $penjualan->value_balance / $penjualan->qty_balance : 0,
        ]);

        return response()->json(['data' => $penjualan], 200);
    }

    public function deleteItem(Request $request, $id)
    {
        

        $data = penjualanModel::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        }
        if ($data->qty >= 0) {
            $data->delete();
            return response()->json(['message' => 'Data berhasil di hapus']);
        } else {
            return response()->json(['message' => 'Qty Minus tidak bisa hapus'], 422);
        }
    }

    
}
