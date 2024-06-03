<?php

namespace App\Services;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderValue;
use App\Models\Attribute;
use Illuminate\Support\Facades\Validator;

class OrdersHandler
{
    protected $sheetsService;
    protected $ordersController;
     public function __construct(GoogleSheetsService $sheetsService)
    {
        $this->sheetsService = $sheetsService;


    }

    protected function determineAttributeType($value)
{
    if (is_numeric($value)) {
        return (strpos($value, '.') !== false) ? 'float' : 'integer';
    } elseif (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null) {
        return 'boolean';
    } else {
        return 'string';
    }
}
    public function handle()
    {
        $values = $this->sheetsService->fetchSheetData('Sheet1!A1:Z');
        if (empty($values)) {
            print "No data found.\n";
            return;
        }

        $header = $values[0];
        array_shift($values);
        $errors = [];
        foreach ($values as $row) {


            $data = [
                'order_id' => $row[0],
                'client_name' => $row[1],
                'phone_number' => $row[2],
                'product_code' => $row[3],
                'final_price' => $row[4],
                'quantity' => $row[5],
            ];


            $validatedData = $this->validateOrderData($data);
            if ($validatedData) {

                $product = Product::where('product_code', $validatedData['product_code'])->first();
                $errors[] =$product;
                if ($product) {

                    $order = Order::firstOrCreate($validatedData);
                    $errors[] =$order;
                    //$this->handleAttributes($order, $header, $row, 'order_id');

                    foreach ($header as $index => $attributeName) {

                        if ( $index>5 && isset($row[$index]) && $row[$index] !== '') {

                            $type = $this->determineAttributeType($row[$index]);
                                 $attribute = Attribute::firstOrCreate(
                                   ['name' => $attributeName],
                                   ['type' => $type]
                                );
                            $ordval=OrderValue::updateOrCreate([
                                'order_id' => $order->id,
                                'attribute_id' => $attribute->id,
                                'value' => $row[$index]
                            ]);
                            $errors[] =$attribute;
                            $errors[] =$ordval;

                            // $errors[] =$proval;
                            // $errors[]=  $attribute;
                            // $errors[] = "ProductValue updated or created successfully.";
                        }
                    }

                }
                else{
                    $errors[] = "Product with code {$validatedData['product_code']} does not exist.";
                }
            }
            else {
            $errors[] = "Validation failed for order with ID {$data['order_id']}.";
             }
        }
        return $errors;
    }

    protected function validateOrderData($data)
    {
        $validator = Validator::make($data, [
            'order_id' => 'required|unique:orders',
            'client_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'product_code' => 'required|String',
            'final_price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {

            return null;
        }

        return $validator->validated();
    }

    // protected function handleAttributes($entity, $header, $row, $foreignKey)
    // {
    //     foreach ($header as $index => $attributeName) {
    //         if ($index > 5 && isset($row[$index])) {
    //             $attribute = Attribute::firstOrCreate(['name' => $attributeName]);
    //             OrderValue::updateOrCreate([
    //                 $foreignKey => $entity->id,
    //                 'attribute_id' => $attribute->id,
    //             ], [
    //                 'value' => $row[$index]
    //             ]);
    //         }
    //     }
    // }
}
