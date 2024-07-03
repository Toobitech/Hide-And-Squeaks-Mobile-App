<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage; // Add this line

use Illuminate\Http\Request;
use App\Models\Product;

class ProductManagementController extends Controller
{
    public function index()
    {
        $product = Product::all();
        return view('pages.apps.products.index', compact('product'));
    }

    public function create()
    {
        return view('pages.apps.products.index');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:1048', // Add more allowed audio file types if needed
            'price' => 'required',
        ]);

        $imageFile = $request->file('image');
        $file_path = $imageFile->store('image_files', 'public');

        Product::create([
            'name' => $request->input('name'),
            'image' => $file_path,
            'price' => $request->input('price'),
        ]);

        return redirect()->route('products.index')->with('success', 'product uploaded successfully');
    }
    public function destroy($id)
{
    $product = Product::findOrFail($id);

    // Delete the audio file from storage
    Storage::disk('public')->delete($product->image);

    // Delete the audio record from the database
    $product->delete();

    return redirect()->route('products.index')->with('success', 'product deleted successfully');
}
public function edit($id)
{
    $product = Product::findOrFail($id);
    return view('pages.apps.products.edit', compact('product'));
}
public function update(Request $request, $id)
{
  //  return $request->all();
    // $request->validate([
    //     'name' => 'required',
    //     'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:1048',
    //     'price' => 'required',
    // ]);

    $product = Product::findOrFail($id);

    $product->name = $request->input('name');
    $product->price = $request->input('price');

    if ($request->hasFile('image')) {
        // Delete the existing audio file from storage
        Storage::disk('public')->delete($product->image);

        // Upload the new audio file
        $productFile = $request->file('image');
        $product->image = $productFile->store('image_files', 'public');
    }

    $product->save();

    return redirect()->route('products.index')->with('success', 'product updated successfully');
}
}
