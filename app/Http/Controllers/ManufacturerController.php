<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ManufacturerController extends Controller
{
    public function index()
    {
        $manufacturers = Manufacturer::all();
        return view('manufacturers.index', compact('manufacturers'));
    }

    public function show($id)
    {
        $manufacturer = Manufacturer::with('products.supplier')->findOrFail($id);
        $qrcode = QrCode::size(200)->generate(route('manufacturers.show', $manufacturer->id));
        return view('manufacturers.show', compact('manufacturer', 'qrcode'));
    }

    public function create()
    {
        return view('manufacturers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:manufacturers,name',
            'contact_email' => 'nullable|email',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
        ]);
        $manufacturer = Manufacturer::create($request->all());
        return redirect()->route('manufacturers.show', $manufacturer->id)->with('success', 'Manufacturer created!');
    }

    public function edit($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        return view('manufacturers.edit', compact('manufacturer'));
    }

    public function update(Request $request, $id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:manufacturers,name,' . $manufacturer->id,
            'contact_email' => 'nullable|email',
            'website' => 'nullable|url',
            'address' => 'nullable|string',
        ]);
        $manufacturer->update($request->all());
        return redirect()->route('manufacturers.show', $manufacturer->id)->with('success', 'Manufacturer updated!');
    }

    public function destroy($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->delete();
        return redirect()->route('manufacturers.index')->with('success', 'Manufacturer deleted!');
    }
}