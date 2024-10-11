<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $productTypes = ProductType::all();

        $hotels = Hotel::all();

        return view('admin.products.index', compact('products', 'productTypes', 'hotels'));
    }

    public function create()
    {
        // Tampilkan halaman form untuk menambahkan produk baru
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'product_type_id' => 'required',
            'hotel_id' => 'required',
            'price' => 'required',
        ]);

        $product = new Product();

        $product->name = $request->name;
        $product->product_type_id = $request->product_type_id;
        $product->hotel_id = $request->hotel_id;
        $product->price = $request->price;

        $product->save();

        return redirect()->back()->with('success', 'Data produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        // Tampilkan halaman edit untuk produk yang dipilih
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        // Update data produk yang dipilih
        $product->update($request->all());

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Hapus produk yang dipilih
        $product->delete();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
