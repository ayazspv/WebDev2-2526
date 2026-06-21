<?php

namespace App\Controllers;

use App\Framework\Controller;
use App\Services\OrderItemService;

class OrderItemController extends Controller {
    private $orderItemService;

    public function __construct() {
        parent::__construct();
        $this->orderItemService = new OrderItemService();
    }

    public function getAllOrderItems() {
        $user = $this->getUserFromJwt();
        $orderItems = $this->orderItemService->getAllOrderItems();
        $this->respond($orderItems);
    }

    public function addOrderItem() {
        $user = $this->getUserFromJwt();
        $data = $this->getRequestData();
        $result = $this->orderItemService->addOrderItem((object)$data);
        if ($result) {
            $this->respond(['success' => true, 'orderItem' => $result]);
        } else {
            $this->respondWithError(500, "Failed to add order item");
        }
    }

    public function getOrderItemsByOrderId($orderId) {
        $user = $this->getUserFromJwt();
        $items = $this->orderItemService->getOrderItemsByOrderId($orderId);
        $this->respond($items);
    }
}