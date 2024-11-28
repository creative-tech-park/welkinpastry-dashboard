<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::query()->get();

        return response()->json([
            'data' => $reviews
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $data = $request->validate([
            'name' => 'required',
            'image' => 'required',
            'message' => 'required',
        ]);

        if ($request->hasFile('image')){
            $file = $request->file('image');
            $image = $file->store('/uploads');
        }

        $data['image'] = $image;
        $data['position'] = 'Customer';

        $review = Review::create($data);


        return response()->json(['review' => $review], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($productId)
    {
        $totalRating  = Review::query()->where('product_id', $productId)->sum('rating');
        $reviews = Review::query()->where('product_id', $productId)->get();

        return response()->json([
            'reviews' => $reviews,
            'totalRating' => $totalRating,
            'average' => $reviews?->count() || $totalRating > 0 ? $totalRating / $reviews?->count() : 0,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $review = Review::query()->findOrFail($id);
        $review->delete();
        return response('Review Delete Successfully Done...');
    }
}
