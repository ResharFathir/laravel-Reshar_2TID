<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use App\Models\Profile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Url;

class PortofolioController extends Controller
{
    public function index(): View
    {
        $portofolios = Portofolio::query()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();
        $profile = Profile::first();
        $technologies = $portofolios
            ->flatMap(fn (Portofolio $portofolio) => array_map('trim', explode(',', $portofolio->teknologi)))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('portfolio.index', compact('portofolios', 'profile', 'technologies'));
    }

    public function create(): View
    {
        return view('portfolio.create', ['profile' => Profile::first()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'teknologi' => 'required|string|max:255',
            'link' => ['nullable', (new Url)->protocols(['http', 'https']), 'max:2048'],
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('portofolio', 'public');
        }

        Portofolio::create($data);

        return redirect()->route('portofolio.index')
            ->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function show(Portofolio $portofolio): View
    {
        return view('portfolio.show', ['portofolio' => $portofolio, 'profile' => Profile::first()]);
    }

    public function edit(Portofolio $portofolio): View
    {
        return view('portfolio.edit', ['portofolio' => $portofolio, 'profile' => Profile::first()]);
    }

    public function update(Request $request, Portofolio $portofolio): RedirectResponse
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'teknologi' => 'required|string|max:255',
            'link' => ['nullable', (new Url)->protocols(['http', 'https']), 'max:2048'],
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hapus_gambar' => 'nullable|boolean',
        ]);

        unset($data['hapus_gambar']);

        if ($request->hasFile('gambar')) {
            if ($portofolio->gambar) {
                Storage::disk('public')->delete($portofolio->gambar);
            }

            $data['gambar'] = $request->file('gambar')
                ->store('portofolio', 'public');
        } elseif ($request->boolean('hapus_gambar')) {
            if ($portofolio->gambar) {
                Storage::disk('public')->delete($portofolio->gambar);
            }

            $data['gambar'] = null;
        }

        $portofolio->update($data);

        return redirect()->route('portofolio.index')
            ->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(Portofolio $portofolio): RedirectResponse
    {
        if ($portofolio->gambar) {
            Storage::disk('public')->delete($portofolio->gambar);
        }

        $portofolio->delete();

        return redirect()->route('portofolio.index')
            ->with('success', 'Portofolio berhasil dihapus.');
    }
}