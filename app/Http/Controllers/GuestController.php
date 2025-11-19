<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Profile;
use App\Models\Galery;
use App\Models\Foto;
use App\Models\Testimonial;
use App\Models\Kategori;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Show the home page
     */
    public function home()
    {
        $profile = Profile::first();
        
        // Get latest Agenda posts (termasuk kategori tambahan)
        $agendaKategori = Kategori::where('judul', 'Agenda')->first();
        $latestAgenda = collect();
        if ($agendaKategori) {
            $latestAgenda = Post::with(['kategori', 'kategoris', 'petugas'])
                ->where('status', 'published')
                ->where(function($q) use ($agendaKategori) {
                    $q->where('kategori_id', $agendaKategori->id)
                      ->orWhereHas('kategoris', function($subq) use ($agendaKategori) {
                          $subq->where('kategori_id', $agendaKategori->id);
                      });
                })
                ->latest()
                ->take(3)
                ->get();
        }
        
        // Get latest Informasi posts (termasuk kategori tambahan)
        $informasiKategori = Kategori::where('judul', 'Informasi Terkini')->first();
        $latestInformasi = collect();
        if ($informasiKategori) {
            $latestInformasi = Post::with(['kategori', 'kategoris', 'petugas'])
                ->where('status', 'published')
                ->where(function($q) use ($informasiKategori) {
                    $q->where('kategori_id', $informasiKategori->id)
                      ->orWhereHas('kategoris', function($subq) use ($informasiKategori) {
                          $subq->where('kategori_id', $informasiKategori->id);
                      });
                })
                ->latest()
                ->take(3)
                ->get();
        }
        
        $testimonials = Testimonial::approved()
            ->latest()
            ->take(6)
            ->get();
            
        return view('guest.home', compact('profile', 'latestAgenda', 'latestInformasi', 'testimonials'));
    }

    /**
     * Show the profile page
     */
    public function profil()
    {
        $profile = Profile::first();
        return view('guest.profil', compact('profile'));
    }

    /**
     * Show the gallery page
     */
    public function galeri(Request $request)
    {
        // Get kategori IDs untuk Informasi Terkini, Agenda, dan Galeri Sekolah
        $informasiKategori = Kategori::where('judul', 'Informasi Terkini')->first();
        $agendaKategori = Kategori::where('judul', 'Agenda')->first();
        $galeriKategori = Kategori::where('judul', 'Galeri Sekolah')->first();
        
        $kategoriIds = [];
        if ($informasiKategori) $kategoriIds[] = $informasiKategori->id;
        if ($agendaKategori) $kategoriIds[] = $agendaKategori->id;
        if ($galeriKategori) $kategoriIds[] = $galeriKategori->id;
        
        $query = Galery::with(['post.kategori', 'post.kategoris', 'fotos'])
            ->where('status', 1)
            ->whereHas('post', function($q) use ($kategoriIds) {
                $q->where('status', 'published')
                  ->where(function($subq) use ($kategoriIds) {
                      // Kategori utama
                      $subq->whereIn('kategori_id', $kategoriIds)
                           // Atau kategori tambahan (many to many)
                           ->orWhereHas('kategoris', function($kq) use ($kategoriIds) {
                               $kq->whereIn('kategori_id', $kategoriIds);
                           });
                  });
            });
            
        // Filter by post_id if provided (filtering by specific gallery post title)
        if ($request->has('post') && $request->post) {
            $query->where('post_id', $request->post);
        }
        
        $galeries = $query->orderBy('position')->get();
        
        // Get posts untuk filter chips - semua post yang memiliki galeri dan memiliki salah satu kategori
        // Menampilkan judul post dari tabel post
        $filterPosts = collect();
        if (!empty($kategoriIds)) {
            $filterPosts = Post::with(['kategori', 'kategoris'])
                ->where('status', 'published')
                ->where(function($q) use ($kategoriIds) {
                    $q->whereIn('kategori_id', $kategoriIds)
                      ->orWhereHas('kategoris', function($subq) use ($kategoriIds) {
                          $subq->whereIn('kategori_id', $kategoriIds);
                      });
                })
                ->whereHas('galeries', function($q) {
                    $q->where('status', 1);
                })
                ->select('posts.*')
                ->distinct()
                ->orderBy('judul', 'asc')
                ->get();
        }
        
        // Posts untuk content section (dari kategori Galeri Sekolah saja)
        $galeriPosts = collect();
        if ($galeriKategori) {
            $galeriPosts = Post::with(['kategori', 'kategoris', 'petugas'])
                ->where('status', 'published')
                ->where(function($q) use ($galeriKategori) {
                    $q->where('kategori_id', $galeriKategori->id)
                      ->orWhereHas('kategoris', function($subq) use ($galeriKategori) {
                          $subq->where('kategori_id', $galeriKategori->id);
                      });
                })
                ->latest()
                ->take(6)
                ->get();
        }
            
        return view('guest.galeri', compact('galeries', 'galeriPosts', 'filterPosts'));
    }

    /**
     * Show gallery page with a selected item (full-detail route for hybrid UX)
     */
    public function galeriShow(Galery $galery)
    {
        // Pastikan hanya galeri aktif yang bisa ditampilkan
        abort_unless($galery->status == 1, 404);

        $galery->load([
            'post',
            'fotos',
            'likes',
            'bookmarks',
            'comments' => function ($query) {
                $query->with([
                    'user',
                    'children.user',
                ])->orderByDesc('created_at');
            },
        ]);
        $recommendations = Galery::with('fotos')
            ->where('status', 1)
            ->where('id', '!=', $galery->id)
            ->latest('position')
            ->take(6)
            ->get();

        return view('guest.galeri_show', compact('galery', 'recommendations'));
    }

    /**
     * Show agenda page (Posts dengan kategori "Agenda")
     */
    public function agenda()
    {
        $agendaKategori = Kategori::where('judul', 'Agenda')->first();
        
        // Jika kategori belum ada, tetap tampilkan halaman kosong
        $posts = collect();
        
        if ($agendaKategori) {
            $posts = Post::with(['kategori', 'kategoris', 'petugas'])
                ->where('status', 'published')
                ->where(function($q) use ($agendaKategori) {
                    $q->where('kategori_id', $agendaKategori->id)
                      ->orWhereHas('kategoris', function($subq) use ($agendaKategori) {
                          $subq->where('kategori_id', $agendaKategori->id);
                      });
                })
                ->latest()
                ->paginate(9);
        }
            
        return view('guest.agenda.index', compact('posts'));
    }

    /**
     * Show single agenda detail
     */
    public function agendaShow(Post $post)
    {
        // Pastikan post adalah kategori Agenda dan published (bisa dari kategori utama atau tambahan)
        $agendaKategori = Kategori::where('judul', 'Agenda')->first();
        abort_unless($agendaKategori, 404);
        
        $post->load(['kategori', 'kategoris', 'petugas', 'galeries.fotos']);
        
        $hasAgendaKategori = $post->kategori_id == $agendaKategori->id || 
                            $post->kategoris->contains('id', $agendaKategori->id);
        abort_unless($post->status === 'published' && $hasAgendaKategori, 404);
        
        // Get related posts (posts lain dengan kategori Agenda)
        $relatedPosts = Post::with(['kategori'])
            ->where('status', 'published')
            ->where(function($q) use ($agendaKategori) {
                $q->where('kategori_id', $agendaKategori->id)
                  ->orWhereHas('kategoris', function($subq) use ($agendaKategori) {
                      $subq->where('kategori_id', $agendaKategori->id);
                  });
            })
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();
        
        return view('guest.agenda.show', compact('post', 'relatedPosts'));
    }

    /**
     * Show informasi page (Posts dengan kategori "Informasi Terkini")
     */
    public function informasi()
    {
        $informasiKategori = Kategori::where('judul', 'Informasi Terkini')->first();
        
        // Jika kategori belum ada, tetap tampilkan halaman kosong
        $posts = collect();
        
        if ($informasiKategori) {
            $posts = Post::with(['kategori', 'kategoris', 'petugas'])
                ->where('status', 'published')
                ->where(function($q) use ($informasiKategori) {
                    $q->where('kategori_id', $informasiKategori->id)
                      ->orWhereHas('kategoris', function($subq) use ($informasiKategori) {
                          $subq->where('kategori_id', $informasiKategori->id);
                      });
                })
                ->latest()
                ->paginate(9);
        }
            
        return view('guest.informasi.index', compact('posts'));
    }

    /**
     * Show single informasi detail
     */
    public function informasiShow(Post $post)
    {
        // Pastikan post adalah kategori Informasi Terkini dan published (bisa dari kategori utama atau tambahan)
        $informasiKategori = Kategori::where('judul', 'Informasi Terkini')->first();
        abort_unless($informasiKategori, 404);
        
        $post->load(['kategori', 'kategoris', 'petugas', 'galeries.fotos']);
        
        $hasInformasiKategori = $post->kategori_id == $informasiKategori->id || 
                                $post->kategoris->contains('id', $informasiKategori->id);
        abort_unless($post->status === 'published' && $hasInformasiKategori, 404);
        
        // Get related posts (posts lain dengan kategori Informasi Terkini)
        $relatedPosts = Post::with(['kategori'])
            ->where('status', 'published')
            ->where(function($q) use ($informasiKategori) {
                $q->where('kategori_id', $informasiKategori->id)
                  ->orWhereHas('kategoris', function($subq) use ($informasiKategori) {
                      $subq->where('kategori_id', $informasiKategori->id);
                  });
            })
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();
        
        return view('guest.informasi.show', compact('post', 'relatedPosts'));
    }

    /**
     * Show the contact page
     */
    public function kontak()
    {
        return view('guest.kontak');
    }
}
