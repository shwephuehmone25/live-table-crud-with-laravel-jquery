<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
   public function index()
   {

    return view('product.index');
   }

  public function getAllProducts(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::table('products')->orderBy('id','desc')->get();
            echo json_encode($data);
        }
    }

    public function create(Request $request)
    {
        if($request->ajax())
        {
            $data = array(
                'name'    =>  $request->name,
                'description'     =>  $request->description,
                'price'     =>  $request->price,
            );
            $id = DB::table('products')->insert($data);
            if($id > 0)
            {
                echo '<div class="alert alert-success">Data Inserted</div>';
            }
        } 
    }

    public function update(Request $request)
    {
        if($request->ajax())
        {
            $data = array(
                $request->column_name =>  $request->column_value
            );
            DB::table('products')
                ->where('id', $request->id)
                ->update($data);
            echo '<div class="alert alert-success">Data Updated</div>';
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax())
        {
            DB::table('products')
                ->where('id', $request->id)
                ->delete();
            echo '<div class="alert alert-success">Data Deleted</div>';
        }
    }
}
