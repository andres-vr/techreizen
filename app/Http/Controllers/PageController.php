<?php

namespace App\Http\Controllers;

use App\Models\PageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     
    }

    /**
     * Display the specified resource.
     */
    public function show(PageModel $page)
    {
        $routeName = Route::currentRouteName();
        if ($routeName == "home") {
            $pageData = $page->find(1); // Fetch the entire page data
            return view('content.show', ['page' => $pageData]);
        }
        if ($routeName == "voorbeeldreizen") {
            $pageData = $page->find(2); // Fetch the entire page data
            return view('content.show', ['page' => $pageData]);
        }
        if ($routeName == "editor") {
            $pageData = $page->find(2); // Fetch the entire page data
            return view('content.editor', compact('page'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PageModel $pageModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PageModel $pageModel)
    {
        $validated = $request->validate([
            'type' => 'required|in:html,pdf',
            'content' => 'required_if:type,html',
            'pdf_file' => 'required_if:type,pdf|file|mimes:pdf|max:2048'
        ]);
        
        if ($request->type == 'pdf') {
            // Handle PDF upload
            $filename = $request->file('pdf_file')->store('public/pdfs');
            $pageModel->update([
                'type' => 'pdf',
                'content' => basename($filename)
            ]);
        } else {
            // Handle HTML content
            $pageModel->update([
                'type' => 'html',
                'content' => $request->content
            ]);
        }
        
        return redirect()->route('page.show', $pageModel)->with('success', 'Page updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PageModel $pageModel)
    {
        //
    }
}
