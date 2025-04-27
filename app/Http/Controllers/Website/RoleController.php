<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function list(Request $request)
    {
        return view('website.pages.role.list');
    }

    public function list_ajax(Request $request)
    {
        $data = Role::query()
            ->select('roles.*')
            ->orderBy('roles.name', 'ASC');

        return DataTables::eloquent($data)->make(true);
    }

    public function create(Request $request)
    {
        return view('website.pages.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()->route('website.role.list')->with('success', 'Role created successfully.');
    }

    public function edit(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        return view('website.pages.role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('website.role.list')->with('success', 'Role updated successfully.');
    }

    public function destroy(Request $request)
    {
        $role = Role::where('id', $request->id)->firstOrFail();
        $role->delete();

        return response()->json(['success' => 'Role deleted successfully.']);
    }
}
