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
        $previousRouteName = session('previous_route', null);

        if ($routeName == "home") {
            $pageData = $page->find(1); // Fetch the entire page data
            session(['previous_route' => 'home']);
            return view('content.show', ['page' => $pageData]);
        } elseif ($routeName == "voorbeeldreizen") {
            $pageData = $page->find(2); // Fetch the entire page data
            session(['previous_route' => 'voorbeeldreizen']);
            return view('content.show', ['page' => $pageData]);
        } elseif ($routeName == "editor") {
            $pageData = $page->find(1); // Fetch the entire page data
            $test = "test";
            return view('content.editor', ['page' => $pageData, 'previousRoute' => $previousRouteName]);
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
        return view('editor', [
            'page' => $pageModel,
            'content' => $pageModel->content
        ]);
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

            $validated = $request->validate([
                'content' => 'required'
            ]);

            //toegevoegd Inas

            $pageModel->update(['content' => $validated['content']]);

            return redirect()->route('pages.show', $pageModel)
                ->with('success', 'Pagina succesvol bijgewerkt');
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

    public function saveEditorContent(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'page_id' => 'required|exists:pages,id'
        ]);

        $page = PageModel::find($request->page_id);
        $page->update([
            'type' => 'html',
            'content' => $request->input('content')
        ]);

        return response()->json(['message' => 'Content saved successfully!']);
    }

}
