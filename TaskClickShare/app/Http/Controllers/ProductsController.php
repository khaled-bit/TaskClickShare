<?php
namespace App\Http\Controllers;



use App\Models\Product;
use App\Services\ProductsHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    protected $ProductsHandler;

    public function __construct(ProductsHandler $productsHandler)
    {
        $this->productsHandler = $productsHandler;
    }

    public function fetchAndStoreProducts()
    {
        $result = $this->productsHandler->handle();
         return $result;

    }


}
