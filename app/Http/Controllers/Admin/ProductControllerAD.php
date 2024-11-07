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
                ->select('p.*', 'cat.cat_name', 'b.brand_name', 's.size_name', 'col.col_name')
                ->leftJoin('categories as cat', 'cat.cat_id', '=', 'p.cat_id')
                ->leftJoin('brands as b', 'b.brand_id', '=', 'p.brand_id')
                ->leftJoin('sizes as s', 's.size_id', '=', 'p.size_id')
                ->leftJoin('colors as col', 'col.col_id', '=', 'p.col_id')
                ->where('p.status', '!=', 0);
        
            if ($search) {
                $data->when($search, function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('cat.cat_name', 'like', '%'.$search.'%')
                            ->orWhere('b.brand_name', 'like', '%'.$search.'%')
                            ->orWhere('s.size_name', 'like', '%'.$search.'%')
                            ->orWhere('col.col_name', 'like', '%'.$search.'%')
                            ->orWhere('p.pro_name', 'like', '%'.$search.'%');
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
        
            $data = $data->orderBy('p.pro_id', 'DESC')->paginate(20);

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
