<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return response()->json(\App\Models\Product::all()) ;
    }

    public function create(Request $request) {
       

        try {

            $product = new \App\Models\Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->tags = self::stringToJson($request->tags);

        
            

         if ($product->save()) {
             return response()->json(['status' => 'success', 'message' => 'Product created successfully']);
         }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }    
    }

    public function getName($name) {
        $products = \App\Models\Product::where('name', $name);

        return $products;
    }

    private function stringToJson($string) {
        $string = explode(',',$string);

        return json_encode($string,true);
    }
}
