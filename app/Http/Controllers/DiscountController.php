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

        
        if ($discount->isEmpty()){
            return response()->json(
                [
                    "message" => "No discount found for orderId = $id"
                ],
                404
            );
        }
        

        $discounts = Discount::with([
            'discountLines' => function ($query) {
                $query->select();
            }
        ])->get();

        return $discounts;
        
        $discountLines = $discount[0]->discountLines()
            ->select("discount_reason as discountReason", "discount_amount as discountAmount", "subtotal")->get();

        $discounts = [];
        /*  for($i = 0; $i < count($discountLines); $i++){
              $discounts[]
          } */

        $response = [
            "orderId" => $discount[0]->fk_order_id,
            "discounts" => $discountLines,
            "totalDiscount" => $discount[0]->total_discount,
            "discountedTotal" => $discount[0]->discounted_total

        ];

        return response()->json(
            $response
        );
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
