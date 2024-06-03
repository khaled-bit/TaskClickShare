<?php
namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\Product;
use App\Services\OrdersHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    protected $ordersHandler;

    public function __construct(OrdersHandler $ordersHandler)
    {
        $this->ordersHandler = $ordersHandler;
    }

    public function fetchAndStoreOrders()
    {
        $result = $this->ordersHandler->handle();
         return $result;

    }


}
