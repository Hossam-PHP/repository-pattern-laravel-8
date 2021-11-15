<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\OrderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller 
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository) 
    {
        $this->orderRepository = $orderRepository;
    }

    public function indexBlade() 
    {
        $orders = $this->orderRepository->getUserOrders(auth()->user()->id);

        //show data
        return view('order.list', ['orders' => $orders]);
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'status' => true,
            'data' => $this->orderRepository->getAllOrders()
        ]);
    }

    public function store(Request $request): JsonResponse 
    {
        $orderDetails = $request->only([
            'client',
            'details'
        ]);

        $validator = Validator::make($orderDetails, [
            'client' => 'required|string',
            'details' => 'required|string',
            // 'user_id' => 'required|integer|exists:users,id',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $orderDetails['user_id'] = isset(auth('api')->user()->id) ? auth('api')->user()->id : auth()->user()->id;

        //based on BaseRepository method
        return response()->json([
            'status' => true,
            'data' => $this->orderRepository->create($orderDetails)
        ], Response::HTTP_CREATED);
    }

    public function show(Request $request, $id): JsonResponse 
    {
        //based on BaseRepository method
        return response()->json([
            'status' => true,
            'data' => $this->orderRepository->find($id)
        ]);
    }

    public function update(Request $request, $id): JsonResponse 
    {
        $orderDetails = $request->only([
            'client',
            'details'
        ]);
        
        $validator = Validator::make($orderDetails, [
            'client' => 'required|string',
            'details' => 'required|string',
            // 'user_id' => 'required|integer|exists:users,id',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $orderDetails['user_id'] = isset(auth('api')->user()->id) ? auth('api')->user()->id : auth()->user()->id;

        $user = (auth('api')->user() !== NULL) ? auth('api')->user() : auth()->user();
        
        //policy task
        if ($user->can('update', $this->orderRepository->find($id))) {
            //user is authorized now
            $this->orderRepository->updateOrder($id, $orderDetails);
            return response()->json([
                'status' => true,
                'data' => $this->orderRepository->find($id)
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'User is not to update order now.'
            ]);
        }
    }

    public function destroy(Request $request, $id): JsonResponse 
    {
        $this->orderRepository->deleteOrder($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
