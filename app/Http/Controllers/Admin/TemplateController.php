<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Template::all();
        return view('templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:templates,name|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'type' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        if ($request->hasFile('image')) {
            // This saves the file to storage/app/public/templates
            $path = $request->file('image')->store('templates', 'public');
            $validated['image'] = $path;
        }

        Template::create($validated);

        return redirect()->route('templates.index')->with('success', 'Service created with image!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        return view('templates.edit', compact('template')); // Create the edit.blade.php similarly to create
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:templates,name,' . $template->id,
            'description' => 'required',
            'price' => 'required|numeric',
            'type' => 'required|in:template,custom',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // 1. Delete old image if it exists
            if ($template->image) {
                Storage::disk('public')->delete($template->image);
            }
            // 2. Store new image
            $validated['image'] = $request->file('image')->store('templates', 'public');
        }

        $template->update($validated);

        return redirect()->route('templates.index')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        if ($template->image) {
            Storage::disk('public')->delete($template->image);
        }

        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Service and image deleted.');
    }
}
