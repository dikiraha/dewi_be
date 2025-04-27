<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PurchaseRequisition;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        return view('website.pages.home');
    }

    public function home_ajax(Request $request)
    {
        $data = PurchaseRequisition::query()
            ->select([
                'purchase_requisitions.*', 'users.name as user_name', 'departments.name as department_name'
            ])
            ->join('users', 'purchase_requisitions.user_id', '=', 'users.id')
            ->join('departments', 'purchase_requisitions.department_id', '=', 'departments.id')
            ->orderBy('purchase_requisitions.created_at', 'DESC');

        return DataTables::eloquent($data)->make(true);
    }
}
