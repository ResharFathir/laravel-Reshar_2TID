<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectsP;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('pelanggan')->latest()->get();

        return view('portofolio.index', compact('projects'));
    }

    public function create()
    {
        $pelanggan = ProjectsP::all();

        return view('portofolio.create', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => ['required', 'exists:pelanggan,pelanggan_id'],
            'nama_projek' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'status' => ['required', Rule::in(['pending', 'ongoing', 'completed'])],
        ]);

        Project::create($validated);

        return redirect()->route('portofolio.index')
            ->with('success', 'Projek berhasil ditambahkan.');
    }

    public function edit(Project $project)
    {
        $pelanggan = ProjectsP::all();

        return view('portofolio.edit', compact('project', 'pelanggan'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'pelanggan_id' => ['required', 'exists:pelanggan,pelanggan_id'],
            'nama_projek' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'status' => ['required', Rule::in(['pending', 'ongoing', 'completed'])],
        ]);

        $project->update($validated);

        return redirect()->route('portofolio.index')
            ->with('success', 'Projek berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('portofolio.index')
            ->with('success', 'Projek berhasil dihapus.');
    }
}