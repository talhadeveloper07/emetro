<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marketing;

class MarketingController extends Controller
{
    /**
     * Display a listing of the marketing module.
     */
    public function index()
    {
        $marketings = Marketing::latest()->paginate(12);
        return view('admin.marketing.index', compact('marketings'));
    }

    /**
     * Show the form for creating a new marketing module.
     */
    public function create()
    {
        return view('admin.marketing.create');
    }

    /**
     * Store a newly created marketing module.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string|',
            'document'     => 'required|file|mimes:pdf,doc,docx,ppt,pptx,mp4,jpg,png',
            'image'        => 'required|image|mimes:jpg,jpeg,png,webp',
            'content_type' => 'required|in:logo,brochure,image,video,presentation',
        ]);

        $data = $request->all();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $marketing = Marketing::create($data);

        return back()->with($marketing ? 'success' : 'error', 
            $marketing ? 'Media Asset created successfully.' : 'Media Asset not created.'
        );
    }

    /**
     * Show the form for editing the specified marketing module.
     */
    public function edit($id)
    {
        $marketing = Marketing::findOrFail($id);
        return view('admin.marketing.edit', compact('marketing'));
    }

    /**
     * Update the specified marketing module.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string|',
            'document'     => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,jpg,png',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'content_type' => 'required|in:logo,brochure,image,video,presentation',
        ]);

        $marketing = Marketing::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $updated = $marketing->update($data);

        return back()->with($updated ? 'success' : 'error', 
            $updated ? 'Media Asset updated successfully.' : 'Media Asset not updated.'
        );
    }

    /**
     * Remove the specified marketing module.
     */
    public function destroy($id)
    {
        $marketing = Marketing::findOrFail($id);
        $marketing->delete();
        return back()->with('success', 'Media Asset deleted successfully.');
    }


    /**
     * Filter by content type
     */
    public function logos()
    {
        $logos = Marketing::where('content_type', 'logo')->get();
        return view('admin.marketing.logos.index', compact('logos'));
    }

    public function images()
    {
        $images = Marketing::where('content_type', 'image')->get();
        return view('admin.marketing.images.index', compact('images'));
    }

    public function brochures()
    {
        $brochures = Marketing::where('content_type', 'brochure')->get();
        return view('admin.marketing.brochures.index', compact('brochures'));
    }

    public function videos()
    {
        $videos = Marketing::where('content_type', 'video')->get();
        return view('admin.marketing.videos.index', compact('videos'));
    }

    public function presentations()
    {
        $presentations = Marketing::where('content_type', 'presentation')->get();
        return view('admin.marketing.product_presentations.index', compact('presentations'));
    }
}