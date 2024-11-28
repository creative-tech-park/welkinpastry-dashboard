<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $resCats = [];
        if(request()->has('recursive')){
            $resCats = Category::query()
                ->with(['childrenRecursive'])
                ->whereNull('parent_id')
                ->select('id', 'name', 'banner', 'icon', 'status', 'order_number')
                ->orderBy('order_number');
            $resCats = $this->makeRecursive($resCats->get());
        }else{
            $resCats = Category::query()
                ->with(['parent'])
                ->select('id', 'name', 'banner','icon', 'status', 'order_number')
                ->orderBy('order_number')
                ->paginate(50)
                ->withQueryString();
        }

        return response()->json($resCats);
    }


    protected function makeRecursive($categories, $label = 0): array
    {
        $result = [];
        foreach ($categories as $category) {
            $name = str_repeat('-', $label) .''. $category['name'];
            $result[] = ['id' => $category['id'], 'name' => $name];
            if (!empty($category->childrenRecursive)) {
                $result = array_merge($result, $this->makeRecursive($category->childrenRecursive, $label + 1));
            }
        }
        return $result;

    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:30|min:1|unique:categories',
            'parent_id' => 'nullable|exists:categories,id',
            'order_number' => 'required|integer'
        ]);


        if (\Illuminate\Support\Facades\Request::hasFile('banner')){
            $file =  \Illuminate\Support\Facades\Request::file('banner');
            $banner = $file->store('/uploads');
        }

        if (\Illuminate\Support\Facades\Request::hasFile('icon')){
            $file =  \Illuminate\Support\Facades\Request::file('icon');
            $icon = $file->store('/uploads');
        }

        $parentId = $request->input('parent_id') != 'null' ? $request->input('parent_id') : NULL;


        $data['parent_id'] =  $parentId;
        $data['slug'] = Str::slug($request->input('name'));
        $data['banner'] = $banner ??  NULL;
        $data['details'] = $request->short_description ??  NULL;
        $data['icon'] = $icon ?? null;
        $data['status']  = 0;
        $data['order_number']  = $request->input('order');
        Category::create($data);
        return response()->json(['message' => 'Category save successfully done.'], 200);
    }

    public function show(Category $category)
    {
        if (\request()->has('updateStatus')) {
            $category->status = !$category->status;
            $category->save();
            return response()->json(['message' => 'Category Status Update Done...'], 200);
        }
        return response()->json($category);
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category Delete successfully done.'], 200);
    }


    public function update(Request $request, $id){

        $data = $request->validate([
            'name' => 'required|max:30|min:1|unique:categories,id,'.$id,
            'parent_id' => 'nullable|exists:categories,id',
            'order_number' => 'required|integer'
        ]);

        $category = Category::findOrFail($id);

        if (\Illuminate\Support\Facades\Request::hasFile('banner')){
            $file =  \Illuminate\Support\Facades\Request::file('banner');
            $banner = $file->store('/uploads');
        }

        if (\Illuminate\Support\Facades\Request::hasFile('icon')){
            $file =  \Illuminate\Support\Facades\Request::file('icon');
            $icon = $file->store('/uploads');
        }

        $parentId = $request->input('parent_id') != 'null' ? $request->input('parent_id') : NULL;


        $data['parent_id'] =  $parentId;
        $data['slug'] = Str::slug($request->input('name'));
        $data['banner'] = $banner ??  NULL;
        $data['details'] = $request->short_description ??  NULL;
        $data['icon'] = $icon ?? null;
        $data['status']  = 0;
        $category->update($data);
        return response()->json(['message' => 'Category save successfully done.'], 200);

    }



    public function navCategories(){

        $ids = collect(json_decode(get_setting('navCats')));

        $categories = Category::query()->with(['childrenRecursive'])->whereIn('id', $ids)->get();


        return response()->json($categories);
    }




    public function homeCategories()
    {
        $categories = collect(json_decode(get_setting('homeCats')));
        $products = Category::query()->with(['products', 'childrenRecursive', 'products.images', 'products.stocks'])->whereIn('id', $categories)->get();

        $products->each(function ($product){
            $product->products->each(function($product) {
                $product->images->map(function($image) {
                    $image->url = Storage::url("uploads/$image->image");
                    return $image;
                });
            });
        });

        return response()->json($products);
    }



}

