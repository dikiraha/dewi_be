<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    public function list(Request $request)
    {
        return view('website.pages.department.list');
    }

    public function list_ajax(Request $request)
    {
        $data = Department::query()
            ->select('departments.*')
            ->orderBy('departments.name', 'ASC');

        return DataTables::eloquent($data)->make(true);
    }

    public function create(Request $request)
    {
        return view('website.pages.department.create');
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code',
        ]);
    
        try {
            $department = Department::create($request->only(['name', 'code']));
    
            return response()->json([
                'message' => 'Department created successfully.',
                'data' => $department,
            ], 201); // 201 Created
        } catch (\Exception $e) {
            Log::error('Department creation failed: ' . $e->getMessage());
    
            return response()->json([
                'message' => 'Failed to create department.',
                'error' => $e->getMessage(), // optional: remove in production
            ], 500);
        }
    }

    public function edit(Request $request, $uuid)
    {
        $department = Department::where('uuid', $uuid)->firstOrFail();
        return view('website.pages.department.edit', compact('department'));
    }

    public function update(Request $request, $uuid)
    {
        $department = Department::where('uuid', $uuid)->firstOrFail();
    
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code,' . $department->id,
        ]);
    
        try {
            $department->update($request->only(['name', 'code']));
    
            return redirect()->route('website.department.list')
                                ->with('success', 'Department updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed : ' . $e->getMessage());
    
            return redirect()->back()
                                ->withInput()
                                ->with('error', 'Failed. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $department = Department::where('uuid', $request->uuid)->firstOrFail();
            $department->delete();
    
            return response()->json(['success' => 'Department deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed : ' . $e->getMessage());
    
            return response()->json(['error' => 'Failed.'], 500);
        }
    }
}
