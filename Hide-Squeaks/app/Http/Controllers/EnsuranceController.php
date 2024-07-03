<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ensurance;

class EnsuranceController extends Controller
{  public function index()
    {
        $ensurance = Ensurance::all();
        return view('ensurance.index', compact('ensurance'));
    }

    public function create()
    {
        return view('ensurance.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'paragraph' => 'required',

        ]);


        Ensurance::create([
            'paragraph' => $request->input('paragraph'),

        ]);

        return redirect()->route('ensurance.index')->with('success', 'Paragraph uploaded successfully');
    }
    public function destroy($id)
{
    $ensurance = Ensurance::findOrFail($id);


    // Delete the audio record from the database
    $ensurance->delete();

    return redirect()->route('ensurance.index')->with('success', 'Paragraph deleted successfully');
}
public function edit($id)
{
    $ensurance = Ensurance::find($id);
    return view('ensurance.edit', compact('ensurance'));
}
public function update(Request $request, $id)
{
    // $request->validate([
    //     'title' => 'required',
    //     'audio_file' => 'nullable|mimes:mp3,wav', // Allow audio file to be optional during update
    // ]);

    $ensurance = Ensurance::find($id);

    $ensurance->paragraph = $request->input('paragraph');



    $ensurance->save();

    return redirect()->route('ensurance.index')->with('success', 'Paragraph updated successfully');
}
}
