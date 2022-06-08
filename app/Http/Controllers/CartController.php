<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Requests\AttachPurchaseRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cart::with('user','purchases')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartRequest $request, Cart $cart)
    {
        $cart = Cart::create($request->validated());

        return $cart;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        return $cart->load('user','purchases');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCartRequest  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $response = $cart->update($request->validated());

        return $cart;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();
    }

    public function attachPurchase(Cart $cart, AttachPurchaseRequest $request)
    {
        $item = $cart->purchases->find($request->purchase_id);

        if($item)
            {
                $qty = $item->pivot->qty;
                $item->pivot->update([
                    'qty' => $qty+$request->qty
                ]);
            }
        else
            {
                $cart->purchases()->attach(
                    $request->purchase_id, [
                        'qty' => $request->qty
                    ]);
            }

        return $cart->load('purchases');

    }
}
