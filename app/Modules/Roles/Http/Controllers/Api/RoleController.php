<?php

namespace App\Modules\Roles\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $roles = Role::query();

            if ($request->has('search') && !empty($request->search)) {
                $roles = $roles->where('name', 'like', '%' . $request->search . '%');
            }

            $roles = $roles->paginate($request->get('per_page', 10));

            return response()->json([
                "status"  => true,
                "data"    => [
                    'roles' => $roles,
                ],
                "message" => "Lists of Roles",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error fetching roles: " . $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        try {
            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => "api",
            ]);

            return response()->json([
                "status"  => true,
                "data"    => [
                    'role' => $role,
                ],
                "message" => "Role created successfully",
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error creating role: " . $e->getMessage(),
            ], 500);
        }
    }

    public function show(Role $role)
    {
        try {
            return response()->json([
                "status"  => true,
                "data"    => [
                    'role' => $role,
                ],
                "message" => "Role fetched successfully",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error fetching role: " . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:roles,name,' . $role->id,
            ]);
    
            $role->update([
                'name'       => $request->name,
                'guard_name' => "api",
            ]);
    
            return response()->json([
                "status"  => true,
                "data"    => [
                    'role' => $role,
                ],
                "message" => "Role updated successfully",
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error updating role: " . $e->getMessage(),
            ], 500);
        }

        
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();

            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error deleting role: " . $e->getMessage(),
            ], 500);
        }
    }

}
