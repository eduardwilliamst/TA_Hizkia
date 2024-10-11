<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelType;
use Illuminate\Http\Request;

class HotelTypeController extends Controller
{
    public function index()
    {
        $hotelTypes = HotelType::all();
        return view('admin.hoteltypes.index', compact('hotelTypes'));
    }

    public function create()
    {
        return view('admin.hoteltypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:hotel_types',
        ]);

        $hoteltype = new HotelType();
        $hoteltype->name = $request->name;
        $hoteltype->save();

        return redirect()->back()->with('success', 'Hotel type added successfully!');
    }

    public function edit($id)
    {
        $hotelType = HotelType::findOrFail($id);
        return view('admin.hoteltypes.edit', compact('hotelType'));
    }

    public function update(Request $request, $id)
    {
        $hotelType = HotelType::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:hotel_types,name,' . $hotelType->id,
        ]);

        $hotelType->update($validatedData);

        return redirect()->route('admin.hoteltypes.index')->with('success', 'Hotel type updated successfully!');
    }

    public function destroy($id)
    {
        $hotelType = HotelType::findOrFail($id);
        $hotelType->delete();

        return redirect()->back()->with('success', 'Hotel type deleted successfully!');
    }
}
