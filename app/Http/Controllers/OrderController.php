<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // User: View own orders
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                    ->with('product')
                    ->latest()
                    ->paginate(10);

        return view('Order.index', compact('orders'));
    }

    public function cancel($id)
{
    $order = Order::where('id', $id)
                  ->where('user_id', Auth::id())
                  ->firstOrFail();

    if ($order->status !== 'pending') {
        return back()->with('error', 'Only pending orders can be cancelled.');
    }

    $order->update(['status' => 'cancelled']);

    return back()->with('success', 'Order cancelled successfully!');
}

public function destroy($id)
{
    $order = Order::where('user_id', Auth::id())->findOrFail($id);
    $order->delete();

    return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
}

    public function create(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('Order.order-confirm', compact('product'));
    }

public function updateAddress(Request $request, $id)
{
    $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

    if ($order->status !== 'pending') {
        return redirect()->back()->with('error', 'You cannot update this order anymore.');
    }

    $validated = $request->validate([
        'contact_name'  => 'required|string|max:255',
        'contact_phone' => 'required|string|max:20',
        'address'       => 'required|string|max:255',
    ]);

    $order->update($validated);

    return redirect()->route('orders.index')->with('success', 'Order Contact information updated successfully!');
}



    public function store(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'quantity'      => 'required|integer|min:1',
            'contact_name'  => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'address'       => 'required|string|max:255',
        ]);

        $order = Order::create([
            'user_id'       => Auth::id(),
            'product_id'    => $product->id,
            'quantity'      => $validated['quantity'],
            'total_price'   => $product->price * $validated['quantity'],
            'contact_name'  => $validated['contact_name'],
            'contact_phone' => $validated['contact_phone'],
            'address'       => $validated['address'],
            'status'        => 'pending',
        ]);

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }




    // Admin: View all orders
    public function adminIndex(Request $request)
{
    $query = $request->input('search');

    $orders = Order::with(['user', 'product'])
        ->when($query, function($q) use ($query) {
            $q->where('id', $query) // search by Order ID exactly
              ->orWhereHas('user', function($q2) use ($query) {
                  $q2->where('first_name', 'like', "%{$query}%")
                     ->orWhere('last_name', 'like', "%{$query}%");
              })
              ->orWhereHas('product', function($q3) use ($query) {
                  $q3->where('name', 'like', "%{$query}%");
              });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('Admin.Order.index', compact('orders'));
}

    // Admin: Update status
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated!');
    }
}
