<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Exception;

class ProductControllerAD extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $time_start = $request->input('time_start');
            $time_end = $request->input('time_end');
            
            $data = Product::from('products as p')
                ->select('p.*', 'cat.name as category_name', 'b.name as brand_name')
                ->leftJoin('categories as cat', 'cat.id', '=', 'p.category_id')
                ->leftJoin('brands as b', 'b.id', '=', 'p.brand_id')
                ->where('p.status', '!=', 0);
    
            if ($search) {
                $data->when($search, function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('cat.name', 'like', '%'.$search.'%')
                            ->orWhere('b.name', 'like', '%'.$search.'%')
                            ->orWhere('p.name', 'like', '%'.$search.'%');
                    });
                });
            }
    
            if (isset($time_start) && isset($time_end)) {
                $data = $data->whereBetween('p.created_at', [$time_start, $time_end]);
            } elseif (isset($time_start)) {
                $data = $data->where('p.created_at', '>=', $time_start);
            } elseif (isset($time_end)) {
                $data = $data->where('p.created_at', '<=', $time_end);
            }
            
            $data = $data->with('productItems')->orderBy('p.id', 'DESC')->paginate(20);
    
            return response()->json([
                'message' => 'Data index product',
                'data' => $data
            ], 201);
    
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching products',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}