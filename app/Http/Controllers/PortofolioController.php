<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    // READ: tampilkan semua data
    public function index()
    {
        $portofolio = Portofolio::latest()->paginate(10);
        return view('portofolio.index', compact('portofolio'));
    }

    // CREATE: tampilkan form tambah
    public function create()
    {
        return view('portofolio.create');
    }

    // CREATE: simpan data baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_demo'   => 'nullable|url',
            'link_github' => 'nullable|url',
            'teknologi'   => 'nullable|string|max:255',
            'tanggal'     => 'nullable|date',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('portofolio', 'public');
        }

        Portofolio::create($data);

        return redirect()->route('portofolio.index')
            ->with('success', 'Portofolio berhasil ditambahkan.');
    }

    // READ: detail satu data
    public function show(Portofolio $portofolio)
    {
        return view('portofolio.show', compact('portofolio'));
    }

    // UPDATE: tampilkan form edit
    public function edit(Portofolio $portofolio)
    {
        return view('portofolio.edit', compact('portofolio'));
    }

    // UPDATE: simpan perubahan
    public function update(Request $request, Portofolio $portofolio)
    {
        $data = $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_demo'   => 'nullable|url',
            'link_github' => 'nullable|url',
            'teknologi'   => 'nullable|string|max:255',
            'tanggal'     => 'nullable|date',
        ]);

        if ($request->hasFile('gambar')) {
            // hapus gambar lama agar storage tidak menumpuk
            if ($portofolio->gambar) {
                Storage::disk('public')->delete($portofolio->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('portofolio', 'public');
        }

        $portofolio->update($data);

        return redirect()->route('portofolio.index')
            ->with('success', 'Portofolio berhasil diperbarui.');
    }

    // DELETE: hapus data
    public function destroy(Portofolio $portofolio)
    {
        if ($portofolio->gambar) {
            Storage::disk('public')->delete($portofolio->gambar);
        }

        $portofolio->delete();

        return redirect()->route('portofolio.index')
            ->with('success', 'Portofolio berhasil dihapus.');
    }
}