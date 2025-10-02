<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductFeature;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search_query');

        $products = Product::with('features')
            ->when($search, function ($query, $search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('slug', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('Product.index', compact('products'));
    }

    public function store()
    {
        $user = Auth::user();
        return view('Product.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function StoreRequest(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:products,slug',
            'description' => 'required|string|max:200',
            'features'    => 'required|array|min:1',
            'features.*'  => 'nullable|string|max:255',
            'price'       => 'required|numeric|min:0',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // <-- Required image
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug);
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = $imagePath;
        $product->save();

        foreach ($request->features as $feature) {
            if (!empty($feature)) {
                ProductFeature::create([
                    'product_id' => $product->id,
                    'feature'    => $feature,
                ]);
            }
        }

        return redirect()->route('product-index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
        public function edit(string $slug)
        {
            $product = Product::with('features')->where('slug', $slug)->firstOrFail();
            return view('Product.edit', compact('product'));
        }
    
public function update(Request $request, string $slug)
{
    // Find product by slug instead of ID
    $product = Product::where('slug', $slug)->with('features')->firstOrFail();

    $request->validate([
        'name'        => 'required|string|max:255',
        // 🔹 unique but ignore the current product's slug
        'slug'        => 'required|string|max:255|unique:products,slug,' . $product->id,
        'description' => 'required|string|max:200',
        'features'    => 'required|array|min:1',
        'features.*'  => 'nullable|string|max:255',
        'price'       => 'required|numeric|min:0',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle optional image update
    if ($request->hasFile('image')) {
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }

    // Update product details
    $product->name        = $request->name;
    $product->slug        = Str::slug($request->slug); // keep slug consistent
    $product->description = $request->description;
    $product->price       = $request->price;
    $product->save();

    // 🔹 Reset and insert features again
    $product->features()->delete();

    foreach ($request->features as $feature) {
        if (!empty($feature)) {
            $product->features()->create([
                'feature' => $feature,
            ]);
        }
    }

    return redirect()->route('product-index')
        ->with('success', 'Product updated successfully!');
}





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
    $product = Product::where('slug', $slug)->with('features')->firstOrFail();

        if ($product->features()->exists()) {
            $product->features()->delete();
        }

        $product->delete();

        return redirect()->route('product-index')->with('success', 'Product deleted successfully!');
    }
}
