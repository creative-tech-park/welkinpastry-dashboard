<?php

namespace App\Http\Controllers\Api\Frontend\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Category\CategoryShowResource;
use App\Http\Resources\V1\Product\ProductListResource;
use App\Http\Resources\V1\Product\ProductShowResource;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Variation;


use function App\Http\Helpers\showPrices;
use function App\Http\Helpers\getSetting;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        $products = Product::query()
            ->with(relations: ['category', 'brand'])
            ->where('title', 'like', '%' . $request->input('search') . '%')
            ->select(['id', 'title', 'price', 'cover_image'])
            ->latest()
            ->take(12)
            ->get();

        foreach ($products as $product) {
            $product->key_features = json_decode($product->key_features);
        }
        return ProductListResource::collection($products);
    }

    public function bestSelling(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        $productIds = OrderDetails::query()->distinct()->pluck('product_id');



        $products = Product::query()
            ->with(relations: ['category', 'brand'])
            ->whereIn('id', $productIds)
            // ->select(['id', 'title', 'price', 'cover_image'])
            ->latest()
            ->take(12)
            ->get();

        foreach ($products as $product) {
            $product->key_features = json_decode($product->key_features);
        }
        return ProductListResource::collection($products);
    }


    public function getSearchProduct(Request $request)
    {
        $products = Product::query()
            ->with('category')
            ->where('title', 'like', '%' . $request->input('search') . '%')
            ->take(20)
            ->get();

        foreach ($products as $product) {
            $product->key_features = json_decode($product->key_features);
        }
        return ProductListResource::collection($products);
    }
    public function getCategoryProduct($slug)
    {
        $category = Category::query()->where('slug', $slug)->with('products', 'children')->first();

        foreach ($category->products as $product) {
            $product->key_features = json_decode($product->key_features);
        }

        return CategoryShowResource::make($category);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::query()->with(['category', 'images'])->findOrFail($id);
        $products = Product::query()
            ->whereNot('id', $product->id)
            ->where('category_id', $product->category_id)
            ->take(5)
            ->get();

        return response()->json([
            'product' => $product,
            'products' => $products
        ]);
    }

    public function filterProduct(Request $request)
    {
        $products = Product::query()
            ->where($request->input('category'), function ($q, $search) {
                $q->where('category_id', $search);
            })
            ->take(5)
            ->get();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
