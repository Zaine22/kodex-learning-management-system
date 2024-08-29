<?php

namespace App\Modules\Categories\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Categories\Http\Requests\CategoryRequest;
use App\Modules\Categories\Models\Category;
use App\Modules\Categories\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response()->json([
            'statu'   => true,
            'data'    => [
                'categories' => $this->service->all($request),
            ],
            'message' => 'Success',
        ], 200);
    }

    public function show(Category $category)
    {
        return response()->json([
            'statu'   => true,
            'data'    => [
                'category' => $category,
            ],
            'message' => 'Success',
        ], 201);
    }

    public function store(CategoryRequest $request)
    {
        $user = auth()->user();

        $category = $this->service->store($request, $user);

        return response()->json([
            'statu'   => true,
            'data'    => [
                'category' => $category,
            ],
            'message' => 'Successfully saved',
        ], 201);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $user = auth()->user();

        $category = $this->service->update($category, $request, $user);

        return response()->json([
            'statu'   => true,
            'data'    => [
                'category' => $category,
            ],
            'message' => 'Successfully updated',
        ], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([], 204);
    }

}
