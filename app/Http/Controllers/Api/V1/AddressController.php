<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\OrderArea;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws AuthenticationException
     */
    public function index()
    {
        if (Auth::check()) {
//            return Address::query()->with('orderArea')->where('user_id', Auth::id())->get();
            $user = Auth::user();
            return $user->load(['addresses', 'addresses.orderArea']);

        }
        throw new AuthenticationException();
    }


    public function getOrderAreas()
    {
        return response()->json(OrderArea::query()->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'nullable|exists:customer_addresses,id',
            'shipping_area_id' => 'required|exists:shipping_areas,id',
            'address' => 'required',
            'phone' => 'required'
        ]);

        $data['user_id'] = Auth::id();
//        Address::query()->create($data);
        Address::query()->updateOrCreate(['id' => $request->input('id')], $data);

        return response()->json([
            'message' => "Address Created Done..."
        ]);
    }

    /**
     * Display the specified resource.
     * @throws AuthenticationException
     */
    public function show($id)
    {
        if (Auth::check()) return Address::query()->with('orderArea')->findOrFail($id);
        throw new AuthenticationException();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $address = Address::query()->findOrFail($id);
        $address->delete();
        return response()->json([
            'message' => "Address Delete Done..."
        ]);
    }
}
