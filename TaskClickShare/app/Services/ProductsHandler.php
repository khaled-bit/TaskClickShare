<?php

namespace App\Services;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Country;
use App\Models\Attribute;
use App\Models\ProductValue;

class ProductsHandler
{
    protected $sheetsService;

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
        $values = $this->sheetsService->fetchSheetData('Sheet2!A1:Z');
        if (empty($values)) {
            return ["No data found."];
        }

        $header = $values[0];
        array_shift($values);
        $errors = [];
        foreach ($values as $row) {
            $data = [
                'product_name' => $row[0],
                'description' => $row[1],
                'country' => $row[2],
                'product_code' => $row[3],
            ];
            $validatedData = $this->validateProductData($data);
            if ($validatedData) {
                $country = Country::where('country_name', $row[2])->first();
                // $errors[] =$country;
                if ($country) {
                    $product = Product::firstOrCreate($validatedData);
                    // $errors[] =$product;
                    foreach ($header as $index => $attributeName) {

                        if ( $index>3 && isset($row[$index]) && $row[$index] !== '') {

                            $type = $this->determineAttributeType($row[$index]);
                                 $attribute = Attribute::firstOrCreate(
                                   ['name' => $attributeName],
                                   ['type' => $type]
                                );
                            $proval=ProductValue::updateOrCreate([
                                'product_id' => $product->id,
                                'attribute_id' => $attribute->id,
                                'country_id' => $country->id,
                                'value' => $row[$index]
                            ]);
                            // $errors[] =$proval;
                            // $errors[]=  $attribute;
                            // $errors[] = "ProductValue updated or created successfully.";
                        }
                    }
                } else {
                    $errors[] = "Country with name {$validatedData['country']} does not exist.";
                }
            } else {
                $errors[] = "Validation failed for product.";
            }
        }
        return $errors;
    }

    protected function validateProductData($data)
{
    $validator = Validator::make($data, [
        'product_name' => 'required',
        'description' => 'nullable',
        'country' => 'required',
        'product_code' => 'required|string',
    ]);

    if ($validator->fails()) {

        return null;
    }

    return $validator->validated();
}



}
