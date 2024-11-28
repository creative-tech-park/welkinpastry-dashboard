<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CompanyService;
use Illuminate\Http\Request;

class CompanyServiceController extends Controller
{
    public function index()
    {
        $data = CompanyService::get();
        return response()->json($data);
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/services', 'public'); // Store image in 'testimonials' directory
        }

        // Create a new testimonial record
        $data = CompanyService::create([
            'name' => $request->name,
            'details' => $request->details,
            'image' => $imagePath ?? null, // Save the image path
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Service added successfully!',
            'data' => $data,
        ], 201);
    }
    public function destroy($id)
    {
        // Find the testimonial by its ID
        $data = CompanyService::find($id);

        // Check if the testimonial exists
        if (!$data) {
            return response()->json(['message' => 'Service not found.'], 404);
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
        return response()->json(['message' => 'Service deleted successfully.']);
    }
}
