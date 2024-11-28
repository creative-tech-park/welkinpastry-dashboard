<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CustomCake;
use Illuminate\Http\Request;

class CustomCakeController extends Controller
{
    public function index()
    {
        $data = CustomCake::get();
        return response()->json($data);
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validate image
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/custom_cakes', 'public'); // Store image in 'testimonials' directory
        }

        // Create a new testimonial record
        $data = CustomCake::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath ?? null, // Save the image path
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Custom Cake added successfully!',
            'data' => $data,
        ], 201);
    }
    public function destroy($id)
    {
        // Find the testimonial by its ID
        $data = CustomCake::find($id);

        // Check if the testimonial exists
        if (!$data) {
            return response()->json(['message' => 'Custom Cake not found.'], 404);
        }

        // Delete the stored image if it exists
        if ($data->image) {
            $imagePath = public_path('storage/' . $data->image); // Get the full path of the image
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
        }

        // Delete the testimonial
        $data->delete();

        // Return a success response
        return response()->json(['message' => 'CustomCake deleted successfully.']);
    }
}
