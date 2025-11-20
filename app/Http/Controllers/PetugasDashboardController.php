<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Galery;
use App\Models\Foto;
use App\Models\Kategori;

class PetugasDashboardController extends Controller
{
    /**
     * Show petugas dashboard
     */
    public function dashboard()
    {
        $totalPosts = Post::count();
        $totalGaleries = Galery::count();
        $totalFotos = Foto::count();
        
        $recentPosts = Post::with(['kategori', 'petugas'])
            ->latest()
            ->take(5)
            ->get();

        $kategoris = Kategori::withCount([
                'posts',
                'postsManyToMany as posts_many_to_many_count',
            ])->latest()->take(10)->get();
        
        return view('petugas.dashboard', compact(
            'totalPosts', 
            'totalGaleries', 
            'totalFotos',
            'recentPosts',
            'kategoris'
        ));
    }
}
