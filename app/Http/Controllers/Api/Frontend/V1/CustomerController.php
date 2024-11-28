<?php

namespace App\Http\Controllers\Api\Frontend\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Customer\CustomerShowResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class CustomerController extends Controller
{
    public function show(string $id)
    {
        $customer = User::where('id', $id)->with('addresses', 'orders', 'orders.orderDetails', 'orders.orderDetails.product')->first();

        return CustomerShowResource::make($customer);
    }

    public function update(Request $request, string $id)
    {
        $user = User::fiind($id);
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'image' => 'nullable',
        ]);

        if($request->hasFile('image')){
            if($user->image)
            {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->image));

                $path = '/storage/'.$request->file('image')->store('uploads', 'public');
                $data['image'] = $path;
            }
        }

        $user->update($data);

        return CustomerShowResource::make($user);
    }

    public function passwordReset($id)
    {

    }
    public function destroy(string $id)
    {
        //
    }
}
