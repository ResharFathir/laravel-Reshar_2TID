<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    private function authorizeManager(): void
    {
        abort_unless(in_array(auth()->user()->role, ['admin', 'owner'], true), 403);
    }

    public function index()
    {
        $this->authorizeManager();
        return view('bumalo.accounts.index', ['accounts' => User::orderBy('role')->orderBy('name')->paginate(15)]);
    }

    public function create()
    {
        $this->authorizeManager();
        return view('bumalo.accounts.form', ['account' => new User(['role' => request('role', 'customer')]), 'editing' => false]);
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $data = $request->validate([
            'name' => 'required|string|max:120', 'email' => 'required|email|max:190|unique:users,email',
            'phone' => 'nullable|string|max:30', 'role' => ['required', Rule::in(['admin', 'owner', 'warehouse', 'customer'])],
            'password' => 'required|string|min:8|confirmed',
        ]);
        User::create($data);
        return redirect()->route('admin.accounts.index')->with('success', 'Akun baru berhasil dibuat.');
    }

    public function edit(User $account)
    {
        $this->authorizeManager();
        return view('bumalo.accounts.form', ['account' => $account, 'editing' => true]);
    }

    public function update(Request $request, User $account)
    {
        $this->authorizeManager();
        $data = $request->validate([
            'name' => 'required|string|max:120', 'email' => ['required', 'email', 'max:190', Rule::unique('users', 'email')->ignore($account->id)],
            'phone' => 'nullable|string|max:30', 'role' => ['required', Rule::in(['admin', 'owner', 'warehouse', 'customer'])],
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if (!in_array($account->role, ['admin', 'owner'], true) || !in_array($data['role'], ['admin', 'owner'], true)) {
            $this->ensureAnotherManager($account);
        }
        if (blank($data['password'])) unset($data['password']);
        $account->update($data);
        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $account)
    {
        $this->authorizeManager();
        abort_if($account->is(auth()->user()), 422, 'Akun yang sedang digunakan tidak dapat dihapus.');
        $this->ensureAnotherManager($account);
        $account->delete();
        return redirect()->route('admin.accounts.index')->with('success', 'Akun berhasil dihapus.');
    }

    private function ensureAnotherManager(User $account): void
    {
        if (in_array($account->role, ['admin', 'owner'], true)) {
            abort_if(User::whereIn('role', ['admin', 'owner'])->count() <= 1, 422, 'Simpan setidaknya satu akun admin atau pemilik.');
        }
    }
}
