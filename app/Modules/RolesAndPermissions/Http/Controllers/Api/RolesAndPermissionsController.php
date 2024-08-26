<?php

namespace App\Modules\RolesAndPermissions\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;use Illuminate\Support\Facades\Auth;

class RolesAndPermissionsController extends Controller
{
    public function index(Request $request)
    {
        try{
            $query = Role::query();

            if ($request->has('search') && !empty($request->search)){
                $q = $query->where('name', 'like', '%' . $request->search . '%')->get();

                return response()->json([
                    "status"  => true,
                    "data"    => [
                        'roles'  => $q,
                    ],
                    "message" => "Lists of Roles",
                ], 200);
            }

            else {
                $roles = $query->paginate($request->get('per_page', 10)); 
            
                return response()->json([
                    "status"  => true,
                    "data"    => [
                        'roles'  => $roles,
                    ],
                    "message" => "Lists of Roles",
                ], 200);
            }
            
        }
        catch (\Exception $e) {
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
            'name' => 'required|string|unique:roles',
            'guard_name' => 'required|string',
        ]);

        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            return response()->json([
                "status"  => true,
                "data"    => $role,
                "message" => "Role created successfully",
            ], 200);
        } 
        catch (ValidationException $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Validation error: Name should be string only." . $e->getMessage(),
            ], 422); 
        }
        catch (\Exception $e) {
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
                "data"    => $role,
                "message" => "Role fetched successfully",
            ], 200);
        } 
        catch (\Exception $e) {
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
                'name' => 'string',
                'guard_name' => 'string'
            ]);

            $role->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            return response()->json([
                "status"  => true,
                "data"    => $role,
                "message" => "Role updated successfully",
            ], 200);
        } 
        catch (ValidationException $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Validation error: Name should be string only." . $e->getMessage(),
            ], 422); 
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

            return response()->json([
                "status"  => true,
                "data"    => null,
                "message" => "Role deleted successfully",
            ], 200); 
        } 
        catch (\Exception $e) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Error deleting role: " . $e->getMessage(),
            ], 500);
        }
    }

}
