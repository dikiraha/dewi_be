<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Department;
use Spatie\Permission\Models\Role;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function list(Request $request)
    {
        return view('website.pages.user.list');
    }

    public function list_ajax(Request $request)
    {
        $data = User::query()
            ->select([
                'users.*',
                DB::raw('GROUP_CONCAT(DISTINCT departments.code ORDER BY departments.code ASC SEPARATOR \', \') as department'),
                'roles.name as role'
            ])
            ->join('model_has_departments', 'users.id', '=', 'model_has_departments.model_id')
            ->join('departments', 'model_has_departments.department_id', '=', 'departments.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->groupBy('users.id', 'roles.name')
            ->orderBy('users.name', 'ASC');
    
        return DataTables::eloquent($data)->make(true);
    }

    public function create(Request $request)
    {
        $departments = Department::orderBy('name', 'ASC')->get();
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('website.pages.user.create', compact('departments', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|min:6|max:6|unique:users,nik',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'department' => 'required|array',
            'role' => 'required',
        ]);
    
        try {
            // User::create($request->only(['name', 'code']));
            $user = User::create([
                'nik' => $request->nik,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
            ]);

            $user->departments()->sync($request->department);
            $user->roles()->sync($request->role);
    
            return redirect()->route('website.user.list')
                                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed : ' . $e->getMessage());
    
            return redirect()->back()
                                ->withInput()
                                ->with('error', 'Failed. Please try again.');
        }
    }

    public function edit(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        $departments = Department::orderBy('name', 'ASC')->get();
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('website.pages.user.edit', compact('user', 'departments', 'roles'));
    }

    public function update(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
    
        $request->validate([
            'nik' => [
                'required', 
                'string', 
                'size:6', 
                Rule::unique('users', 'nik')->ignore($user->id),
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:6',
            'department' => 'required|array',
            'role' => 'required',
        ]);
    
        try {
            $updateData = [
                'nik' => $request->nik,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];
    
            if ($request->filled('password')) {
                $updateData['password'] = bcrypt($request->password);
            }
    
            $user->update($updateData);
    
            $user->departments()->sync($request->department);
            $user->roles()->sync($request->role);
    
            return redirect()->route('website.user.list')
                                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update user: ' . $e->getMessage());
    
            return redirect()->back()
                                ->withInput()
                                ->with('error', 'Failed to update user. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = User::where('uuid', $request->uuid)->firstOrFail();
            $user->delete();
    
            return response()->json(['success' => 'User deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed : ' . $e->getMessage());
    
            return response()->json(['error' => 'Failed.'], 500);
        }
    }
}
