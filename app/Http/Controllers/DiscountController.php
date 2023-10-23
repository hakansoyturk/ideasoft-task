<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $discount = Discount::where("fk_order_id", $id)->get();

        if ($discount->isEmpty()) {
            return response()->json(
                [
                    "message" => "No discount found for orderId = $id"
                ],
                404
            );
        }

        $discounts = Discount::with([
            'discountLines' => function ($query) {
                $query->select("id", "fk_discount_id", "fk_order_id", "discount_reason", "discount_amount", "subtotal");
            }
        ])->select("id", "fk_order_id", "total_discount", "discounted_total")->get();

        return response()->json($discounts);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
