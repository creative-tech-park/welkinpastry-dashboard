<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::get();
        return response()->json($testimonials);
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/testimonials', 'public'); // Store image in 'testimonials' directory
        }

        // Create a new testimonial record
        $testimonial = Testimonial::create([
            'name' => $request->name,
            'message' => $request->message,
            'image' => $imagePath ?? null, // Save the image path
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Testimonial added successfully!',
            'data' => $testimonial,
        ], 201);
    }
    public function destroy($id)
    {
        // Find the testimonial by its ID
        $testimonial = Testimonial::find($id);
    
        // Check if the testimonial exists
        if (!$testimonial) {
            return response()->json(['message' => 'Testimonial not found.'], 404);
        }
    
        // Delete the stored image if it exists
        if ($testimonial->image) {
            $imagePath = public_path('storage/' . $testimonial->image); // Get the full path of the image
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
        }
    
        // Delete the testimonial
        $testimonial->delete();
    
        // Return a success response
        return response()->json(['message' => 'Testimonial deleted successfully.']);
    }
    
}
