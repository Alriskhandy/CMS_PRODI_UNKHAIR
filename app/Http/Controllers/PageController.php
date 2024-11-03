<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Theme;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function create()
    {
        return view('backend.pages.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|unique:pages,slug|max:255',
                'content' => 'required',
                'status' => 'required|boolean',
            ]);
    
            Page::create($request->all());
    
            return redirect()->back()->with('success', 'Page created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
            //throw $th;
        }
    }

    public function show($slug)

    {
        $theme = Theme::where('active', true)->first()->path;
        $data = []; // Data yang diperlukan
    
        // Temukan halaman berdasarkan slug
        $page = Page::where('slug', $slug)->firstOrFail();
        
        return view($theme . '.pages', compact('data','page'));
    }
}
