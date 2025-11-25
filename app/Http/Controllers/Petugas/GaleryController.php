<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Galery;
use App\Models\Post;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Foto;
use Illuminate\Support\Facades\Storage;

class GaleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galeries = Galery::with(['post', 'fotos'])->latest()->paginate(10);
        return view('petugas.galery.index', compact('galeries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posts = Post::with('kategori')->where('status', 'published')->get();
        $categories = Kategori::all();
        $maxPosition = Galery::max('position') ?? 0;
        return view('petugas.galery.create', compact('posts', 'categories', 'maxPosition'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'post_id' => 'required|exists:posts,id',
            'position' => 'required|integer|min:1',
            'status' => 'required|in:0,1',
            'files' => 'nullable',
            'files.*' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        $galery = Galery::create([
            'judul' => $validated['judul'],
            'post_id' => $validated['post_id'],
            'position' => $validated['position'],
            'status' => $validated['status'],
        ]);

        // Simpan foto-foto jika ada
        $uploaded = 0;
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                if (!$file->isValid()) {
                    continue;
                }

                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('fotos', $filename, 'public');

                Foto::create([
                    'galery_id' => $galery->id,
                    'file' => $path,
                ]);

                $uploaded++;
            }
        }
        
        return redirect()->route('petugas.galery.index')
            ->with('success', 'Galeri berhasil dibuat' . ($uploaded ? " dan {$uploaded} foto diupload!" : '!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Galery $galery)
    {
        $galery->load(['post', 'fotos']);
        return view('petugas.galery.show', compact('galery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galery $galery)
    {
        $posts = Post::with('kategori')->where('status', 'published')->get();
        $categories = Kategori::all();
        $maxPosition = Galery::max('position') ?? 0;
        return view('petugas.galery.edit', compact('galery', 'posts', 'categories', 'maxPosition'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galery $galery)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'position' => 'required|integer|min:1',
            'status' => 'required|in:0,1'
        ]);

        $galery->update($request->all());
        
        return redirect()->route('petugas.galery.index')->with('success', 'Galeri berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galery $galery)
    {
        $galery->delete();
        return redirect()->route('petugas.galery.index')->with('success', 'Galeri berhasil dihapus!');
    }
}
