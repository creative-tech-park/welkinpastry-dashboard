<?php

namespace App\Http\Controllers\Api\Frontend\V1;

use App\Http\Controllers\Controller;
use App\Models\GetInTouch;
use Illuminate\Http\Request;

class GetInTouchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GetInTouch::query()->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|min:11|max:15',
            'message' => 'required'
        ]);
        GetInTouch::create($data);
        return response()->json('Your Queries Submitted...');
    }

    /**
     * Display the specified resource.
     */
    public function show(GetInTouch $getInTouch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GetInTouch $getInTouch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GetInTouch $getInTouch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $getInTouch = GetInTouch::query()->findOrFail($id);
        $getInTouch->delete();
        return response()->json('Your message is deleted...');
    }
}
