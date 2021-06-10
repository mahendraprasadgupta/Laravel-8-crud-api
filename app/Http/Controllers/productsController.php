<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\product;


class productsController extends Controller
{
    function productList($id = null)
    {

        return $id ? product::find($id) : product::all();
    }


    function addProduct(Request $req)
    {
        $rules = array(
            'name' => 'required|min:6|max:50',
            'category' => 'required|min:6|max:12',
            'description' => 'required|min:24|max:255',
            'mrp' => 'required|numeric'
        );

        $validator = validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        } else {

            $product = new product();
            $product->category = $req->category;
            $product->name = $req->name;
            $product->description = $req->description;
            $product->mrp = $req->mrp;
            $result = $product->save();
            
            if ($result) {
                return response()->json(['result' => 'Product has been added.'], 200);
            } else {
                return response()->json(['error' => 'Operation Fail..'], 404);
            }
        }
    }


    function updateProduct(Request $req)
    {
        $rules = array(
            'name' => 'required|min:6|max:50',
            'category' => 'required|min:6|max:12',
            'description' => 'required|min:24|max:255',
            'mrp' => 'required|numeric'
        );

        $validator = validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        } else {


            $product = new product();
            $product = product::find($req->id);
            $product->category = $req->category;
            $product->name = $req->name;
            $product->description = $req->description;
            $product->mrp = $req->mrp;
            $result = $product->save();
            if ($result) {
                return response()->json(['result' => 'Product has been updated.'], 200);
            } else {
                return response()->json(['error' => 'Operation Fail..'], 404);
            }
        }
    }


    function searchProductByName($key)
    {

        $result = product::where("name", "like", "%" . $key . "%")->get();
        if ($result->isEmpty()) {
            return response()->json(['error' => 'No product found.!'], 404);
        } else {
            return $result;
        }
    }


    function searchProduct($key)
    {

        $result = product::where("name", "like", "%" . $key . "%")
            ->orWhere("category", "like", "%" . $key . "%")
            ->orWhere("description", "like", "%" . $key . "%")
            ->orWhere("mrp", "like", "%" . $key . "%")
            ->get();
        if ($result->isEmpty()) {
            return response()->json(['error' => 'No product found.!'], 404);
        } else {
            return $result;
        }
    }



    function removeProduct($id)
    {

        $product = product::find($id);
        if(empty($product)){
            return response()->json(['error' => 'The product you want to delete is not present'], 404);
        }else{
            $result = $product->delete();
        if ($result) {
            return response()->json(['result' => 'Product has been Removed.'], 200);
        } else {
            return response()->json(['error' => 'Operation Fail..'], 404);
        }
        }
        
    }
}
