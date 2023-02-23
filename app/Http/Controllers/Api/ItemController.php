<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $items = ItemResource::collection(Item::oldest()->filter(request(['status']))->get());
        return response()->json([
            'items' => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreItemRequest $request
     * @return JsonResponse
     */
    public function store(StoreItemRequest $request): JsonResponse
    {
//        $data['user_id'] = auth()->id();
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }
        $item = Item::create($data);
        return response()->json([
            'item' => new ItemResource($item),
            'message' => 'Item created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Item $item
     * @return JsonResponse
     */
    public function show(Item $item)
    {

        return response()->json([
            'items' => new ItemResource($item)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Item $item
     * @return JsonResponse
     */
    public function update(StoreItemRequest $request, Item $item): JsonResponse
    {
        $item->update($request->validated());
        return response()->json([
            'item' => new ItemResource($item),
            'message' => 'Item created successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Item $item
     * @return JsonResponse
     */
    public function destroy(Item $item): JsonResponse
    {
        $item->delete();
        return response()->json([
            'message' => 'Item deleted successfully',
        ]);
    }


}
