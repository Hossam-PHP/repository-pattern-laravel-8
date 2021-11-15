<?php

namespace App\Repository\Eloquent;

use App\Repository\OrderRepositoryInterface;
use App\Models\Order;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface 
{

    /**
    * OrderRepository constructor.
    *
    * @param Order $model
    */
   public function __construct(Order $model)
   {
       parent::__construct($model);
   }
   
    public function getAllOrders() 
    {
        return $this->model->all();
    }

    public function getUserOrders($userId) 
    {
        return $this->model->where('user_id', $userId)->latest()->paginate(6);
    }

    // public function getOrderById($orderId) 
    // {
    //     return $this->model->findOrFail($orderId);
    // }

    public function deleteOrder($orderId) 
    {
        $this->model->destroy($orderId);
    }

    // public function createOrder(array $orderDetails) 
    // {
    //     return $this->model->create($orderDetails);
    // }

    public function updateOrder($orderId, array $newDetails) 
    {
        return $this->model->whereId($orderId)->update($newDetails);
    }

    public function getFulfilledOrders() 
    {
        return $this->model->where('is_fulfilled', true);
    }
}
