<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OrdersHandler;
use App\Http\Controllers\OrdersController;
class FetchOrdersFromGoogleSheets extends Command
{
    protected $signature = 'fetch:orders';
    protected $description = 'Fetch orders from Google Sheets and store them in the database';

    protected $ordersController;

    public function __construct(OrdersController $ordersController)
    {
        parent::__construct();
        $this->ordersController = $ordersController;
    }

    public function handle()
    {
       $result= $this->ordersController->fetchAndStoreOrders();
    if (empty($result)) {
        $this->info('Orders fetched and stored successfully.');
        } else {
            $this->info('Some errors occurred.');
            foreach ($result as $error) {
                $this->error($error);
            }
        }
    }
}
