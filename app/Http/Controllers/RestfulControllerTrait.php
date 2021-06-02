<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait RestfulControllerTrait
{
    /*
     * Saves restful api index method paginate default page size.
     */
    private $perPage = 10;

    /**
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        if (!isset($this->model)) {
            throw new \Error("ModelNotSet");
        }

        if (!isset($this->rules)) {
            throw new \Exception("RulesNotSet");
        }
    }

    /**
     * Get resource list (paginate)
     *
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request['per_page'] ?: $this->perPage;

        $result = $this->model::paginate($perPage); //all if without pagination
        return response()->json($result, 200);
    }

    /*
     * Get resource item with id.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $item = $this->model::findOrFail($id);
        return response()->json(['data' => $item], 200);
    }

    /**
     * For validate request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function validateRequest(Request $request)
    {
        $this->validate($request, $this->rules);
    }

    /*
     * Create new resource item.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);

        $item = $this->model;
        $this->setItem($request, $item);
        $item->save();

        return response()->json([], 200);
    }

    /*
     * Update item that belongs to passed id.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);

        $item = $this->model::findOrFail($id);
        $this->setItem($request, $item);
        $item->save();

        return response()->json([], 200);
    }

    /*
     * Delete item that belongs to passed id.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $item = $this->model::findOrFail($id);
        $item->delete();
        return response()->json([], 200);
    }
}
