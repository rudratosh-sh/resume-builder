<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeRequest;
use App\Models\MongoDB\Resume;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ResumeController extends BaseController
{
    public function list(): JsonResponse
    {
        $user = Auth::user();
        if ($user->hasPermissionTo('manage_resume')) {
            $resumes = Resume::all();
        } else {
            $resumes = Resume::select('id')->where('user_id', $user->id)->get();
        }
        return $this->successResponse($resumes);
    }

    public function store(ResumeRequest $request): JsonResponse
    {
        $user = Auth::user();
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user->id;
        $resume = new Resume($validatedData);
        $resume->save();

        return response()->json(['message' => 'Resume created successfully.'], 201);
    }

    public function show($id): JsonResponse
    {
        $user = Auth::user();
        $resume = Resume::findOrFail($id);

        if ($user->hasPermissionTo('manage_resume') || $resume->user_id == $user->id) {
            return response()->json($resume);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }

    public function update(ResumeRequest $request, $id): JsonResponse
    {
        $user = Auth::user();
        $resume = Resume::findOrFail($id);

        if ($user->hasPermissionTo('manage_resume') || $resume->user_id == $user->id) {
            $validatedData = $request->validated();
            $resume->fill($validatedData);
            $resume->user_id = $user->id;
            $resume->save();

            return response()->json(['message' => 'Resume updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }

    public function destroy($id): JsonResponse
    {
        $user = Auth::user();
        $resume = Resume::findOrFail($id);

        if ($user->hasPermissionTo('manage_resume') || $resume->user_id == $user->id) {
            $resume->delete();

            return response()->json(['message' => 'Resume deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }
}
