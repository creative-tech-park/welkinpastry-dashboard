<?php
namespace App\Http\Helpers;
use App\Models\BusinessSetting;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Laravel\Facades\Image;
// use Intervention\Image\ImageManager;



if (!function_exists('getSetting')) {
    function getSetting($key, $default = null)
    {
        $setting = BusinessSetting::where('key', $key)->first();
        return $setting == null ? $default : $setting->value;
    }
}

if(!function_exists('uploadFile')) {
    function uploadFile($image, $path, $productSlug, $width = null, $height = null) {
        try{
            if(!Storage::exists($path)) {
                Storage::makeDirectory($path);
            }

            $imageName = $productSlug . "_" . uniqid() . '.webp';
            $img = Image::make($image->getRealPath());

            if($width && $height) {
                $img->resize($width, $height, function($constraint) {
                    $constraint->aspectRation();
                });
            }
            $img->save(storage_path('storage/' . $path . '/' . $imageName), 90, 'webp');

            return $path . '/' . $imageName;
            
        }catch (\Exception $e) {
            return false;
        }
    }
}


if (! function_exists('showPrices')) {
    function showPrices($product)
    {
        $lowest_price = $product->buying_price;
        $highest_price = $product->buying_price;

        if (true) {
            foreach ($product->stocks as $key => $stock) {
                if($lowest_price > $stock->price){
                    $lowest_price = $stock->price;
                }
                if($highest_price < $stock->price){
                    $highest_price = $stock->price;
                }
            }
        }
        $lowest_price = floatval($lowest_price);
        $highest_price = floatval($highest_price);

        if($lowest_price == $highest_price){
            return formatPrice($lowest_price);
        }
        else{
            return formatPrice($lowest_price).' - '.formatPrice($highest_price);
        }
    }
}


if(! function_exists('formatPrice')){
    function formatPrice($price): string
    {
        return getSetting('pre', false) ? getSetting('currency_symbol').$price : $price.getSetting('currency_symbol');
    }
}