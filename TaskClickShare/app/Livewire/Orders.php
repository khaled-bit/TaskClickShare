<?php

namespace  App\Livewire;

use Livewire\Component;
use App\Models\Order;

class Orders extends Component
{
    public $searchTerm = '';

    public function render()
    {

        $searchTerm = '%' . $this->searchTerm . '%';
       //$searchTerm = "khalid";
       $orders = Order::where('client_name', 'like', $searchTerm)
                       ->orWhere('phone_number', 'like', $searchTerm)
                       ->get();


        return view('livewire.orders', [
            'orders' => $orders
        ])->layout('layouts.app');
    }
}
