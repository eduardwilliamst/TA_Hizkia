<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        $producttypes = ProductType::all();
        return view('admin.producttypes.index', compact('producttypes'));
    }

    public function create()
    {
        return view('admin.producttypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        ProductType::create($request->all());

        return redirect()->route('producttypes.index')->with('success', 'Product type created successfully.');
    }

    public function edit(ProductType $producttype)
    {
        return view('admin.producttypes.edit', compact('producttype'));
    }

    public function update(Request $request, ProductType $producttype)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $producttype->update($request->all());

        return redirect()->route('producttypes.index')->with('success', 'Product type updated successfully.');
    }

    public function destroy(ProductType $producttype)
    {
        $producttype->delete();

        return redirect()->route('producttypes.index')->with('success', 'Product type deleted successfully.');
    }
}
