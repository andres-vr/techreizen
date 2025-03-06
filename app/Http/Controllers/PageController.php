<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function show($id)
    {
        $page = Page::findOrFail($id);
        return view('pages.show', compact('page'));
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:25',
            'content' => 'required',
            'accessibility_level' => 'required|integer|min:0|max:2'
        ]);

        Page::create($request->all());

        return redirect()->route('pages.show', ['id' => Page::latest()->first()->id]);
    }
}
