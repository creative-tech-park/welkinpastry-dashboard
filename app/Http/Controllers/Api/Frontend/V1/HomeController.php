<?php

namespace App\Http\Controllers\Api\Frontend\V1;

use App\Models\CompanyService;
use App\Models\CustomCake;
use App\Models\CustomCakeFlavor;
use App\Models\Page;
use App\Models\Footer;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Location;
use App\Models\HomeSection;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PageRequest;
use App\Http\Resources\V1\PageResource;
use App\Http\Resources\V1\FooterResource;
use App\Http\Resources\V1\SliderResource;
use function App\Http\Helpers\getSetting;
use App\Http\Resources\V1\HomeSectionResource;

use App\Http\Resources\V1\Category\CategoryListResource;
use App\Http\Controllers\Api\V1\BusinessSettingController;

class HomeController extends Controller
{
    public function getHomeData()
    {
        $testimonials = Testimonial::take(10)->get();
        $services = CompanyService::get();
        $sliders = Slider::query()->select('image')->latest('order_number')->get();

        $featuredCategoryProducts = Category::query()
            ->where('status', 1)
            ->with([
                'products' => function ($query) {
                    $query->select('id', 'title', 'cover_image', 'price', 'category_id', 'variant');
                }
            ])
            ->select(['id', 'name'])
            ->take(10)->get();

        $data = [
            'testimonials' => $testimonials,
            'services' => $services,
            'sliders' => $sliders,
            'featuredCategoryProducts' => $featuredCategoryProducts
        ];
        return response()->json($data);
    }



    public function getSelectedCategoryProducts()
    {
        $data = Category::query()
            ->where('status', 1)
            ->with([
                'products' => function ($query) {
                    $query->select('id', 'title', 'cover_image', 'price', 'category_id', 'variant'); // Don't forget to include the foreign key (e.g., 'category_id')
                }
            ])
            ->select(['id', 'name'])
            ->take(10)->get();

        return response()->json($data);
    }

    public function getHeaderSetting()
    {
        $categoryIds = json_decode(getSetting('header_categories'));
        $categories = [];
        if ($categoryIds !== null && count($categoryIds) > 0) {
            $categories = Category::whereIn('id', $categoryIds ?? [])->with('children', 'products')->where('parent_id', 0)->get();
        }

        $pageIds = json_decode(getSetting('header_pages'));
        $pages = [];
        if ($pageIds !== null && count($pageIds) > 0) {
            $pages = Page::whereIn('id', $pageIds ?? [])->get();
        }

        $setting = [
            'header_categories' => $categories,
            'header_pages' => $pages,
        ];

        return response()->json($setting);
    }


    public function getHeroSlider()
    {
        $sliders = Slider::query()
            ->where('status', 1)
            ->orderBy('order_number')
            ->get();

        return SliderResource::collection($sliders);
    }

    public function getHomeSection()
    {
        $homeSection = HomeSection::query()->get();

        foreach ($homeSection as $section) {

            if ($section->categories) {
                $categoryIds = json_decode($section->categories);
                $section['categories'] = Category::query()->whereIn('id', $categoryIds)->select('slug', 'name', 'icon')->get();
            }

            if ($section->products) {
                $productIds = json_decode($section->products);
                $products = Product::query()->whereIn('id', $productIds)->select('slug', 'title', 'cover_image', 'key_features', 'price', 'discount_price')->get();
                foreach ($products as $product) {
                    $product->key_features = json_decode($product->key_features);
                }
                $section['products'] = $products;
            }
        }

        return HomeSectionResource::collection($homeSection);
    }

    public function getHomeContent()
    {
        $categoryIds = json_decode(getSetting('discover_categories'));
        $categories = [];
        if ($categoryIds !== null && count($categoryIds) > 0) {
            $categories = Category::whereIn('id', $categoryIds ?? [])->get();
        }
        $settings = [
            'discover_categories' => $categories,
            'home_content' => getSetting('home_content')
        ];

        return response()->json($settings);

    }

    public function getCustomPage($slug)
    {
        $page = Page::where('slug', $slug)->first();

        return PageResource::make($page);
    }

    public function getFooter()
    {
        $columns = Footer::query()->orderBy('order_number')->get();

        foreach ($columns as $column) {
            $pageIds = json_decode($column->pages);
            $pages = Page::query()->whereIn('id', $pageIds)->get();

            $column['pages'] = $pages;
        }

        return FooterResource::make($columns);
    }


    public function getAllSettings(): \Illuminate\Http\JsonResponse
    {
        $data = request()->all();
        $response = [];
        foreach (explode(',', $data['name']) as $item) {
            $response[$item] = json_decode(getSetting($item));
        }
        return response()->json($response);
    }

    public function getBusinessLocations()
    {
        $locations = Location::all();
        return response()->json($locations);
    }

    public function categories()
    {
        $cats = Category::query()->whereHas('products')->select(['id', 'name'])->get();
        $mainCats = Category::query()
            ->with(['childrenRecursive'])
            ->whereNull('parent_id')
            ->select(['id', 'name'])
            ->get();

        return response()->json([
            'cats' => $cats,
            'pCats' => $mainCats
        ]);
    }
    public function getParentCategories()
    {
        $cats = Category::query()->whereNull('parent_id')->select(['id', 'name'])->get();
        return response($cats);
    }
    public function allCategories()
    {
        $cats = Category::query()->select(['id', 'name'])->get();
        return response($cats);
    }
    public function filterProducts(Request $request)
    {
        $products = Product::query()
            ->with(['category'])
            ->when($request->input('category'), function ($query, $search) {
                $query->where('category_id', $search);
            })
            ->when($request->input('location'), function ($query, $search) {
                $query->where('location_id', $search);
            })
            ->when(\Illuminate\Support\Facades\Request::input('priceRange'), function ($query, $search) {
                $query->whereBetween('price', [$search['min'], $search['max']]);
            })
            ->when(\Illuminate\Support\Facades\Request::input('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->select(['id', 'title', 'cover_image', 'price', 'variant'])->latest();


        if ($request->has('onlyData')) {
            $products = $products->latest()->get();
        } else {
            $products = $products->simplePaginate($request->input('perPage') ?? 30)
                ->withQueryString();
        }

        return response()->json($products, 200);
    }

    public function getAllpages()
    {
        $pages = Page::query()->get();
        return response()->json([
            'page' => $pages
        ]);
    }
    public function getSinglePage($id)
    {
        $page = Page::query()->findOrFail($id);

        return response()->json($page);
    }

    public function getTestimonials()
    {
        $testimonials = Testimonial::take(10)->get();
        return response()->json($testimonials);
    }
    public function getServices()
    {
        $data = CompanyService::get();
        return response()->json($data);
    }
    public function getCustomCakes()
    {
        $data = CustomCake::get();
        return response()->json($data);
    }

    public function showCustomCake($id)
    {
        $cakes = CustomCake::find($id);
        $flavors = CustomCakeFlavor::get();

        $data = [
            'data' => $cakes,
            'flavors' => $flavors
        ];
        return response()->json($data);
    }

}