<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    public function index(): JsonResponse
    {
        //Check that status is valid
        //This is important for security and to ensure that the filter data is sanitized.
        if (request()->has('status') && !$this->isStatusValid(request('status'))) {
            return response()->json([
                'items' => ItemResource::collection(Item::oldest()->get())
            ]);
        }

        return response()->json([
            'items' => ItemResource::collection(Item::oldest()->filter(request(['status']))->get())
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
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            /* You can change default storage disk to public (in config/filesystems.php)
            if you don't want to pass the public option in the store function */
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
     * @param UpdateItemRequest $request
     * @param Item $item
     * @return JsonResponse
     */
    public function update(UpdateItemRequest $request, Item $item): JsonResponse
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            //Remove current item picture from storage if present
            if ($item->photo && Storage::disk('public')->exists($item->photo)) Storage::disk('public')->delete($item->photo);

            //Store new picture
            $data['photo'] = $request->file('photo')->store('items', 'public');
        }
        $item->update($data);
        return response()->json([
            'item' => new ItemResource($item),
            'message' => 'Item updated successfully',
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

    /**
     * Change the status of the item to completed
     * allow update of item's status to completed irrespective of current status
     *
     * @param Item $item
     * @return JsonResponse
     */
    public function completeItem(Item $item): JsonResponse
    {
        $item->update(['status' => 'completed']);
        return response()->json([
            'item' => new ItemResource($item),
            'message' => 'Item completed',
        ]);
    }

    /**
     * Change the status of the item to active
     *
     * @param Item $item
     * @return JsonResponse
     */
    public function activateItem(Item $item): JsonResponse
    {
//        Status of a completed items can not be changed
        if ($item->status == 'completed') {
            return response()->json([
                'item' => new ItemResource($item),
                'message' => 'You can not change the status of a completed item',
            ]);
        }
        //update state to active
        $item->update(['status' => 'active']);
        return response()->json([
            'item' => new ItemResource($item),
            'message' => 'Item is now active',
        ]);
    }

    /**
     * Check if the status is found in the global constants.status array to confirm its validity
     *
     * @param string $status
     * @return bool
     */
    protected function isStatusValid(string $status): bool
    {
        return in_array($status, config('constants.status'));
    }


}
