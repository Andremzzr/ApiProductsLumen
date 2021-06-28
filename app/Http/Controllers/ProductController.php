<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return response()->json(\App\Models\Product::all()) ;
    }

    /**
     * Get a single Product with the informed id
     * @param string $id
     * @return json message
     */
    public function getSingle(string $id) {
        try{
            return response()->json(\App\Models\Product::findOrFail($id));
        }catch(\Exception $e) {
            return reposne()->json(['status' => "error", "message" => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $product = \App\Models\Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->tags = self::stringToJson($request->tags);

            var_dump($request);
            
            if ($product->save()) {
                return response()->json(['status' => 'success', 'message' => 'Product updated successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
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

    /**
     * Search in the database for a Product with the respective name
     * @param string $productName
     * @return json 
     */
    public function getName(string $productName) {
        try{
            $products = \App\Models\Product::where('name', '=', $productName)->get();
            
            if (count($products) == 0) {
                return response()->json(['status' => 'error', 'message' => "There's no Product with this Name"]);
            }
            
            return $products;
         } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
   
    }
    
    /**
     * Search in the database for products with the respective tag
     * @param string $tag
     * @return json
     */
    public function getByTag(string $tag) {
        try{
            $products = \App\Models\Product::where('tags', '=', $tag)->get();
            
            if (count($products) == 0) {
                return response()->json(['status' => 'error', 'message' => "There's no Product with this tag"]);
            }
            
            return $products;
         } catch (Exception $e) {
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
