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
            $product->tags = $this->stringToJson($request->tags);
            

         if ($product->save()) {
             return response()->json(['status' => 'success', 'message' => 'Product created successfully']);
         }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }    
    }

    public function getName($productName) {
        try{
            $products = \App\Models\Product::all()->where('name','=',$productName);
        
            return $products;
         } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $product = \App\Models\Product::findOrFail($id);
            $product->name = $request->title;
            $product->description = $request->body;
            $product->tags = self::stringToJson($request->tags);

            if ($product->save()) {
                return response()->json(['status' => 'success', 'message' => 'Product updated successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function destroy($id) {
        try {
            $product = \App\Models\Product::findOrFail($id);

            if ($product->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Product deleted successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    private function stringToJson($string) {
        $string = explode(',',$string);

        return json_encode($string,true);
    }

    
}
