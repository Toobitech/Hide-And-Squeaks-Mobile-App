<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Treat;

class TreatsDealController extends Controller
{
    public function index()
    {
        try {
            # code...
            $treats = Treat::all();
            return view('pages.apps.treats.index', compact('treats'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function create()
    {
        return view('pages.apps.treats.index');
    }

    public function store(Request $request)
    {

        try {
            # code...
            $request->validate([
                'treats' => 'required',
                'price' => 'required',
            ]);



            Treat::create([
                'treats' => $request->input('treats'),
                'price' => $request->input('price'),
                'status'=>$request->input('status'),
            ]);

            return redirect()->route('treats.index')->with('success', 'Treat Deal uploaded successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function destroy($id)
    {
        $treats = Treat::findOrFail($id);

        // Delete the audio file from storage

        // Delete the audio record from the database
        $treats->delete();

        return redirect()->route('treats-deal.index')->with('success', 'Treat Deal deleted successfully');
    }
    public function edit($id)
    {
        try {
            # code...
            $treats = Treat::findOrFail($id);
            return view('pages.apps.treats.edit', compact('treats'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function update(Request $request, $id)
    {
        try {
            # code...
            $treats = Treat::findOrFail($id);

            $treats->treats = $request->input('treats');
            $treats->price = $request->input('price');
            $treats->status = $request->input('status');


            $treats->save();

            return redirect()->route('treats-deal.index')->with('success', 'Treat Deal updated successfully');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }
}
