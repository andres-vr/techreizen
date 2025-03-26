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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PageModel $pageModel)
    {
        //
    }
}
