<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CustomCakeFlavor;
use Illuminate\Http\Request;

class CustomCakeFlavorController extends Controller
{
    public function index()
    {
        $data = CustomCakeFlavor::get();
        return response()->json($data);
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',

        ]);

        // Create a new testimonial record
        $data = CustomCakeFlavor::create([
            'name' => $request->name,
        ]);

        // Return a success response
        return response()->json([
            'message' => 'Custom Cake Flavor added successfully!',
            'data' => $data,
        ], 201);
    }
    public function destroy($id)
    {
        // Find the testimonial by its ID
        $data = CustomCakeFlavor::find($id);

        // Check if the testimonial exists
        if (!$data) {
            return response()->json(['message' => 'Custom Cake Flavor not found.'], 404);
        }

        // Delete the testimonial
        $data->delete();

        // Return a success response
        return response()->json(['message' => 'Custom Cake Flavor deleted successfully.']);
    }
}
