<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use App\Models\Galery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fotos = Foto::with('galery')->latest()->paginate(12);
        return view('petugas.foto.index', compact('fotos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $galeries = Galery::with('post')->get();
        return view('petugas.foto.create', compact('galeries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi fleksibel: support multiple (files[]), fallback single (file)
        $rules = [
            'galery_id' => 'required|exists:galery,id',
        ];

        // Jika multiple file
        if ($request->hasFile('files')) {
            $rules['files'] = 'required';
            $rules['files.*'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            // Single file
            $rules['file'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        $validated = $request->validate($rules);

        // Multiple upload path
        if ($request->hasFile('files')) {
            $uploaded = 0;
            foreach ($request->file('files') as $file) {
                if (!$file->isValid()) {
                    continue;
                }

                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('fotos', $filename, 'public');

                Foto::create([
                    'galery_id' => $validated['galery_id'],
                    'file' => $path,
                ]);

                $uploaded++;
            }

            return redirect()->route('petugas.foto.index')
                ->with('success', $uploaded . ' foto berhasil diupload!');
        }

        // Single upload fallback
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('fotos', $filename, 'public');

        Foto::create([
            'galery_id' => $validated['galery_id'],
            'file' => $path,
        ]);

        return redirect()->route('petugas.foto.index')
            ->with('success', 'Foto berhasil diupload!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Foto $foto)
    {
        return view('petugas.foto.show', compact('foto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Foto $foto)
    {
        $galeries = Galery::with('post')->get();
        return view('petugas.foto.edit', compact('foto', 'galeries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Foto $foto)
    {
        $request->validate([
            'galery_id' => 'required|exists:galery,id',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'galery_id' => $request->galery_id
        ];

        // Upload new file if provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($foto->file && file_exists(public_path('images/gallery/' . $foto->file))) {
                unlink(public_path('images/gallery/' . $foto->file));
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/gallery'), $filename);
            $data['file'] = $filename;
        }

        $foto->update($data);
        
        return redirect()->route('petugas.foto.index')->with('success', 'Foto berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Foto $foto)
    {
        // Delete file
        if ($foto->file && file_exists(public_path('images/gallery/' . $foto->file))) {
            unlink(public_path('images/gallery/' . $foto->file));
        }

        $foto->delete();
        return redirect()->route('petugas.foto.index')->with('success', 'Foto berhasil dihapus!');
    }
}
