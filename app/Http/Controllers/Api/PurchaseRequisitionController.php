<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PurchaseRequisition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseRequisitionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string',
            'items.*.specification' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit' => 'required|string',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $now = Carbon::now();
        $month = $now->format('m');
        $year = $now->format('y');

        $user = auth('api')->user();
        $department = $user->departments->first();

        $latestCount = PurchaseRequisition::where('department_id', $department->id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $now->year)
            ->count();

        $nextNumber = str_pad($latestCount + 1, 3, '0', STR_PAD_LEFT);
        $noReg = "PR-{$department->code}-{$month}-{$year}-{$nextNumber}";
        
        $purchase_requisition = PurchaseRequisition::create([
            'no_reg' => $noReg,
            'title' => $request->title,
            'user_id' => $user->id,
            'department_id' => $department->id,
            'description' => $request->description,
            'status' => 'Created',
            'total_amount' => 0,
        ]);

        $totalAmount = 0;

        foreach ($request->items as $item) {
            $subtotal = $item['unit_price'] * $item['quantity'];
            $totalAmount += $subtotal;

            $purchase_requisition->items()->create([
                'purchase_requisition_id' => $purchase_requisition->id,
                'item_name' => $item['item_name'],
                'specification' => $item['specification'] ?? null,
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $subtotal,
            ]);
        }

        $purchase_requisition->update([
            'total_amount' => $totalAmount,
        ]);

        return response()->json([
            'message' => 'Purchase Requisition created successfully',
            'data' => $purchase_requisition->load('items'),
        ], 201);
    }

    public function list_ajax(Request $request)
    {
        $user = auth('api')->user();
        
        $departmentIds = $user->departments->pluck('id');

        $data = PurchaseRequisition::with(['user', 'items'])
            ->whereIn('department_id', $departmentIds)
            ->where('user_id', $user->id)
            ->where('status', 'created')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'message' => 'Data loaded successfully',
            'data' => $data,
        ]);
    }

    public function approval_ajax(Request $request)
    {
        $user = auth('api')->user();

        if ($user && $user->hasRole('approver')) {
            $departmentIds = $user->departments->pluck('id');
    
            $data = PurchaseRequisition::with(['user', 'items'])
                ->whereIn('department_id', $departmentIds)
                ->where('status', 'created')
                ->orderByDesc('created_at')
                ->get();
    
            return response()->json([
                'message' => 'Data loaded successfully',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }
    }

    public function approval(Request $request)
    {
        $request->validate([
            'uuid' => 'required|exists:purchase_requisitions,uuid',
            'status' => 'required',
        ]);

        $purchaseRequisition = PurchaseRequisition::where('uuid', $request->uuid)->firstOrFail();

        $user = auth('api')->user();

        if ($user->hasRole('user')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$user->departments->pluck('id')->contains($purchaseRequisition->department_id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $purchaseRequisition->update([
            'purchase_requisition_id' => $purchaseRequisition->id,
            'approver_id' => $user->id,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return response()->json([
            'message' => 'Status updated successfully',
            'data' => $purchaseRequisition,
        ]);
    }
}
