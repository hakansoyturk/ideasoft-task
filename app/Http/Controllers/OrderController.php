<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Discount;
use App\Models\DiscountCategory;
use App\Models\DiscountLine;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Order::all()->isEmpty()) {
            return response()->json(
                ["message" => "No order found!"]
            );

        }

        $orders = Order::with([
            'items' => function ($query) {
                $query->select('fk_order_id', "fk_product_id", "quantity", "unit_price", "total");
            }
        ])->select("id", "fk_customer_id", "total")->get();

        return response()->json(
            $orders
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customerId' => 'required',
            'productId' => 'required',
            'quantity' => 'required'
        ]);

        $customerId = $request["customerId"];
        $productId = $request["productId"];
        $quantity = $request["quantity"];

        $product = Product::where('id', $productId)->first();
        $customer = Customer::where('id', $customerId)->first();

        if (is_null($customer)) {
            return response()->json(
                [
                    "message" => "This customer number was not found!"
                ],
                404
            );
        }

        if (is_null($product)) {
            return response()->json(
                [
                    "message" => "This product number was not found!"
                ],
                404
            );
        }

        if ($quantity > $product->stock) {
            return response()->json(
                [
                    "message" => "The requested order quantity is not in stock. Quantity in stock = " . $product->stock
                ],
                404
            );
        }

        $total = $quantity * $product->price;

        if (empty(Order::where('fk_customer_id', $customerId)->first())) {
            $order = Order::create([
                'fk_customer_id' => $customerId,
                'total' => $total
            ]);
            $orderId = $order->getKey(); // for getting pk value
        } else {
            $oldTotal = Order::where('fk_customer_id', $customerId)->first()->total;
            $order = Order::where('fk_customer_id', $customerId)->update([
                'total' => $oldTotal + $total
            ]);
            $orderId = Order::where('fk_customer_id', $customerId)->first()->id;
        }

        if (!empty(Discount::where('fk_order_id', $orderId)->get())) {
            $discountLines = DiscountLine::where('fk_order_id', $orderId)->get();
            for ($i = 0; $i < count($discountLines); $i++) {
                DiscountLine::where('id', $discountLines[$i]->id)->update([
                    'subtotal' => Order::where('id', $orderId)->first()->total - $discountLines[$i]->discount_amount
                ]);
            }
        }

        Item::create([
            'fk_order_id' => $orderId,
            'fk_product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $product->price,
            'total' => $total
        ]);

        $newStock = $product->stock - $quantity;

        // Stock quantity updated after order is placed
        Product::where('id', $productId)->update([
            'stock' => $newStock
        ]);


        // Discount Calculation
        $case1 = false;
        $case2 = false;
        $case3 = false;

        $subTotal = Order::where('id', $orderId)->first()->total;
        $discountAmount = 0;
        $discountReason = "";

        if ($quantity >= 6 && $product->category == 2) {

            // $orderTotal = Order::where('id', $orderId)->first()->total;
            $discountReason .= DiscountCategory::where('id', 1)->first()->name . " ";
            $discountAmount += $product->price;
            $subTotal -= $discountAmount;

            $case1 = true;
        }

        if ($total >= 1000) {

            // $orderTotal = Order::where('id', $orderId)->first()->total;
            $discountReason .= DiscountCategory::where('id', 2)->first()->name . " ";
            $discountAmount += $subTotal * (1 / 10);
            $subTotal -= $discountAmount;

            $case2 = true;
        }

        if ($quantity >= 2 && $product->category == 1) {

            $minOrderPrice = Item::where("fk_order_id", $orderId)->min("unit_price");

            // $orderTotal = Order::where('id', $orderId)->first()->total;
            $discountReason .= DiscountCategory::where('id', 1)->first()->name . " ";
            $discountAmount += $minOrderPrice * (2 / 10);
            $subTotal -= $discountAmount;

            $case3 = true;
        }


        if ($case1 == true || $case2 == true || $case3 == true) {
            if (empty(Discount::where('fk_order_id', $orderId)->first())) {
                $discount = Discount::create([
                    'fk_order_id' => $orderId,
                    'total_discount' => $discountAmount,
                    'discounted_total' => $subTotal
                ]);
                $discountedTotal = $subTotal;
                $discountId = $discount->getKey();

            } else {
                $oldDiscountAmount = Discount::where('fk_order_id', $orderId)->first()->total_discount;
                $oldDicountedTotal = Discount::where('fk_order_id', $orderId)->first()->discounted_total;

                $discountedTotal = $subTotal - $oldDiscountAmount;
                $discountId = Discount::where('fk_order_id', $orderId)->first()->id;
                $discount = Discount::where('fk_order_id', $orderId)->update([
                    'total_discount' => $oldDiscountAmount + $discountAmount,
                    'discounted_total' => $discountedTotal
                ]);
            }

            DiscountLine::create([
                'fk_discount_id' => $discountId,
                'fk_order_id' => $orderId,
                'fk_discount_category_id' => $product->category,
                'discount_reason' => $discountReason,
                'discount_amount' => $discountAmount,
                'subtotal' => $discountedTotal
            ]);
        }


        return response()->json([
            "message" => "Order added. Order id => $orderId"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        try {
            Order::where('id', $id)->delete();
            Item::where('fk_order_id', $id)->delete();
            Discount::where('fk_order_id', $id)->delete();
            DiscountLine::where('fk_order_id', $id)->delete();
        } catch (Exception $e) {
            return response()->json(
                ["message" => "An error occurred while deleting the order!"],
                400
            );
        }

    }
}
