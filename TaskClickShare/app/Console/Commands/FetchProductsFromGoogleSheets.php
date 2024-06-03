<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductsHandler;
use App\Http\Controllers\ProductsController;
class FetchProductsFromGoogleSheets extends Command
{
    protected $signature = 'fetch:products';
    protected $description = 'Fetch products from Google Sheets and store them in the database';

    protected $prodcutsController;

    public function __construct(ProductsController $prodcutsController)
    {
        parent::__construct();
        $this->prodcutsController = $prodcutsController;
    }

    public function handle()
    {
        $results = $this->prodcutsController->fetchAndStoreProducts();
        if (empty($results)) {
            $this->info('No actions were performed or no errors reported.');
        } else {
            foreach ($results as $error) {
                $this->error($error);
            }
        }
    }
}
