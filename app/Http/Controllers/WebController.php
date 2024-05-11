<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MajorCategory;
use App\Models\Product;

class WebController extends Controller
{
    public function index()
    {
        // カテゴリーの中の情報を全部ゲット、ソートでmajor_...の順に並べ替えている
        // $categories = Category::all()->sortBy('major_category_name');
           
        $categories = Category::all();

        // カテゴリーの中のmajor_...だけゲットしている。uniqueで重複を消してる
        // $major_category_names = Category::pluck('major_category_name')->unique();
           
        $major_categories = MajorCategory::all();

        $recently_products = Product::orderBy('created_at','desc')->take(4)->get();

        $recommend_products = Product::where('recommend_flag',true)->take(3)->get();

        $featured_products = Product::withAvg('reviews','score')->orderBy('reviews_avg_score','desc')->take(4)->get();


        return view('web.index',compact('major_categories','categories','recently_products','recommend_products','featured_products'));
    }
}
