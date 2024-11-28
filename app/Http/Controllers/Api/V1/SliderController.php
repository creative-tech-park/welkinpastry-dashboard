<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response() ->json(Slider::query()->latest('order_number')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'nullable|exists:sliders,id',
        ]);
        if(empty($request->input('id')) || $request->hasFile('image')){
            $request->validate([
                'image' => 'required|image|mimes:png,jpg,jpeg,webp,avif,svg,gif'
            ]);
        }

        $path = null;
        if ($request->hasFile('image')){
            $file =  $request->file('image');
            $path = $file->store('/uploads');
        }
        $data = [
            'title' => $request->input('title'),
            'slogan' => $request->input('slogan'),
            'url' => $request->input('url'),
            'btn1_name' => $request->input('btn1_name'),
            'order_number' => $request->input('order_number') ?? 0,
        ];
        if(empty($request->input('id')) || $path){
            $data['image'] = $path;
        }

        Slider::query()->updateOrCreate(['id' => $request->input('id')], $data);

        return response()->json('Slider Created...');
    }

    public function show($id)
    {
        return response()->json(Slider::query()->findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Slider::findOrFail($id)->delete();
        return response()->json('Slider Deleted...');
    }
}
