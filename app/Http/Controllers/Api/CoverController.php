<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoverRequest;
use App\Models\MongoDB\Cover;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CoverController extends BaseController
{
    public function list(): JsonResponse
    {
        $user = Auth::user();
        if ($user->hasPermissionTo('manage_cover')) {
            $covers = Cover::all();
        } else {
            $covers = Cover::select('id')->where('user_id', $user->id)->get();
        }
        return $this->successResponse($covers);
    }

    public function store(CoverRequest $request): JsonResponse
    {
        $user = Auth::user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $cover = new Cover($validatedData);
        $cover->save();

        return response()->json(['message' => 'Cover created successfully.'], 201);
    }

    public function show($id): JsonResponse
    {
        $user = Auth::user();
        $cover = Cover::findOrFail($id);

        if ($user->hasPermissionTo('manage_cover') || $cover->user_id == $user->id) {
            return response()->json($cover);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }

    public function update(CoverRequest $request, $id): JsonResponse
    {
        $user = Auth::user();
        $cover = Cover::findOrFail($id);

        if ($user->hasPermissionTo('manage_cover') || $cover->user_id == $user->id) {
            $validatedData = $request->validated();
            $cover->fill($validatedData);
            $cover->user_id = $user->id;
            $cover->save();

            return response()->json(['message' => 'cover updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }

    public function destroy($id): JsonResponse
    {
        $user = Auth::user();
        $cover = Cover::findOrFail($id);

        if ($user->hasPermissionTo('manage_cover') || $cover->user_id == $user->id) {
            $cover->delete();

            return response()->json(['message' => 'Cover deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }
}
