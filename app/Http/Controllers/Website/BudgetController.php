<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Budget;
use App\Models\Department;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function list()
    {
        return view('website.budget.list');
    }

    public function list_ajax(Request $request)
    {
        // Handle AJAX request for budget list
        // Implement your logic here
    }

    public function create()
    {
        return view('website.budget.create');
    }

    public function store(Request $request)
    {
        // Handle budget creation
        // Implement your logic here
    }

    public function edit($uuid)
    {
        return view('website.budget.edit', compact('uuid'));
    }

    public function update(Request $request, $uuid)
    {
        // Handle budget update
        // Implement your logic here
    }

    public function destroy(Request $request)
    {
        // Handle budget deletion
        // Implement your logic here
    }
}
