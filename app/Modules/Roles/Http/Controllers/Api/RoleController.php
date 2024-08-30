<?php

namespace App\Modules\Roles\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Models\Role;
use Illuminate\Http\Request;
use App\Modules\Roles\Http\Requests\RolePostRequest;
use App\Modules\Roles\Services\RoleService;

class RoleController extends Controller
{
    private $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->all($request);
    }

    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    public function show(Role $role)
    {
        return $this->service->show($role);

    }

    public function update(Request $request, Role $role)
    {
        return $this->service->update($request, $role);
    }

    public function destroy(Role $role)
    {
        return $this->service->destroy($role);
    }

}
