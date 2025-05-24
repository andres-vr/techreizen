<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\PageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function __construct()
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(PageModel $page)
    {
        $routeName = Route::currentRouteName();
        $previousUrl = url()->previous();
        $previousRouteName = substr($previousUrl, 17);


        if ($routeName == "home") {
            $pageData = $page->find(1); // Fetch the entire page data
            session(['previous_route' => 'home']);
            return view('content.show', ['page' => $pageData]);
        } elseif ($routeName == "voorbeeldreizen") {
            $pageData = $page->find(2); // Fetch the entire page data
            session(['previous_route' => 'voorbeeldreizen']);
            return view('content.show', ['page' => $pageData]);
        } elseif ($routeName == "editor") {
            if ($previousRouteName == "editor") {
                $previousId = 1; // de id van de aangepaste pagina
            } elseif ($previousRouteName == null) {
                $previousId = 1;
            } else {
                $previousId = DB::table('pages')->where('routename', $previousRouteName)->first()->id;

            }
            $pageData = DB::table('pages')->where('routename', $previousRouteName)->first();
            $pageData = $page->find($previousId); // Fetch the entire page data
            return view('content.editor', ['page' => $pageData, 'previousRoute' => $previousRouteName, 'previousId' => $previousId]);
        }
    }

    public function createNewPage(Request $request)
    {
        $name = $request->input('name');

        $page = new PageModel();
        $page->name = $name;
        $page->routename = $name;
        $page->content = '';
        $page->type = 'HTML';
        $page->access_level = 'admin,guide,traveller,guest';
        $page->created_at = now();
        $page->updated_at = now();
        $page->save();

        $pageData = $page->find($page->id);

        return view('content.editor', ['page' => $pageData, 'previousRoute' => $name]);
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
            'pdf_file' => 'required_if:type,pdf|file|mimes:pdf|max:2048',
            'access_level' => 'required|array',
            'access_level.*' => 'in:admin,guide,traveller,guest'
        ]);

        $updateData = [
            'type' => $request->type,
            'access_level' => implode(',', $request->access_level)
        ];

        if ($request->type == 'PDF') {
            // Handle PDF upload
            $filename = $request->file('pdf_file')->store('public/pdfs');
            $updateData['content'] = basename($filename);
        } else {

            $updateData['content'] = $request->content;
        }
        $pageModel->update($updateData);

        return redirect()->route('page.show', $pageModel)->with('success', 'Page updated!');
    }
    public function saveEditorContent(Request $request)
    {
        try {
            //dd($request->all());
            $page = PageModel::find($request->page_id);

            if ($request->content_type == 'HTML') {
                $page->content = $request->input('content');
                $page->type = 'HTML';
            } elseif ($request->content_type == 'PDF') {
                $page->content = $request->input('pdf_path');
                $page->type = 'PDF';
            }
            $page->access_level = implode(',', $request->input('access_level'));

            $page->save();

            $pageData = $page->find($request->page_id);
            return view('content.show', ['page' => $pageData]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showEditorContent($pageId = null)
    {
        // Default to homepage if no page ID provided
        $pageId = $pageId ?? 1;

        $page = PageModel::find($pageId);

        $previousUrl = url()->previous();
        $previousRoute = substr($previousUrl, 17);

        return view('content.editor', ['page' => $page, 'previousRoute' => $previousRoute]);
    }
    public function showByName($name)
    {
        $page = \DB::table('pages')->where('routename', $name)->first();

        if (!$page) {
            abort(404); // Page not found
        }

        return view('content.show', ['page' => $page]);
    }

    public function getPage($id)
    {
        $page = PageModel::findOrFail($id);
        return response()->json([
            'id' => $page->id,
            'content' => $page->content
        ]);
    }
}

