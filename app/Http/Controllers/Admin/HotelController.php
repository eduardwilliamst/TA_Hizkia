<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\HotelType;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();

        $hotelTypes = HotelType::all();

        return view('admin.hotels.index', compact('hotels', 'hotelTypes'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'deskripsi' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'rating' => 'required',
            'hotel_type_id' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotels', 'public');
            $validatedData['image'] = $imagePath;
        }

        Hotel::create($validatedData);

        return redirect()->back()->with('success', 'Hotel added successfully.');
    }
}
