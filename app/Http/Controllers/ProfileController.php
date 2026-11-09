<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Url;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $profile = Profile::first() ?? new Profile;

        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hapus_foto' => ['nullable', 'boolean'],
            'headline' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:5000'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', (new Url)->protocols(['http', 'https']), 'max:255'],
            'github' => ['nullable', (new Url)->protocols(['http', 'https']), 'max:255'],
            'skills' => ['nullable', 'string', 'max:5000'],
            'education' => ['nullable', 'string', 'max:5000'],
        ]);

        unset($data['photo'], $data['hapus_foto']);

        $profile = Profile::first() ?? new Profile;

        if ($request->hasFile('photo')) {
            if ($profile->photo_path) {
                Storage::disk('public')->delete($profile->photo_path);
            }

            $data['photo_path'] = $request->file('photo')->store('profiles', 'public');
        } elseif ($request->boolean('hapus_foto')) {
            if ($profile->photo_path) {
                Storage::disk('public')->delete($profile->photo_path);
            }

            $data['photo_path'] = null;
        }

        $profile->fill($data)->save();

        return redirect()->route('portofolio.index')
            ->with('success', 'Profil CV berhasil diperbarui.');
    }

    public function destroyPhoto(): RedirectResponse
    {
        $profile = Profile::first();

        if (! $profile?->photo_path) {
            return redirect()->route('profile.edit')
                ->with('success', 'Foto profil memang belum tersedia.');
        }

        Storage::disk('public')->delete($profile->photo_path);
        $profile->update(['photo_path' => null]);

        return redirect()->route('profile.edit')
            ->with('success', 'Foto profil berhasil dihapus.');
    }
}