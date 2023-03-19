<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends BaseController
{
    /**
     * Show Customers List
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $customers = User::getUsersWithRolePaginate(5, $perPage);

        return response()->json($customers);
    }

    /**
     * Store Customer Information
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class); // verify that the user is authorized to create a new customer

        // store customer information
        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($customer) {
            $customer->assignRole(5); // assign the role of customer to the new user

            return $this->successResponse([
                'message' => 'Customer created successfully!',
            ]);
        }

        return $this->failedResponse();
    }

    /**
     * Show Customer Profile
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function profile($id, Request $request): JsonResponse
    {
        $customer = User::find($id);

        if (!$customer) {
            return $this->failedResponse('Not found!');
        }

        $this->authorize('view', $customer); // verify that the user is authorized to view the profile of this customer

        return $this->successResponse($customer);
    }

    /**
     * Delete Customer
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function delete($id, Request $request): JsonResponse
    {
        $customer = User::find($id);

        if (!$customer) {
            return $this->failedResponse('Not found!');
        }

        $this->authorize('delete', $customer); // verify that the user is authorized to delete this customer

        $customer->delete();

        return $this->successResponse([
            'message' => 'Customer has been deleted',
        ]);
    }
}
