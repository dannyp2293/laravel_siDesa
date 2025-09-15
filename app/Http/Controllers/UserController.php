<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\validation\Rule;

class UserController extends Controller
{
    public function account_request_view()
    {
        $users = User::where('status', 'submitted')->get();
        return view('pages.account-request.index',['users' => $users,
    ]);

    }
    public function account_approval(Request $request, $userId)
{
    $request->validate([
        'for' => ['required', Rule::in(['approve', 'reject', 'deactive'])],
    ]);

    $for = $request->input('for');
    $user = User::findOrFail($userId);

    if ($for == 'approve') {
        $user->status = 'approved';
        $user->save();

        return redirect()->route('account-request.index')
            ->with('success', 'Berhasil menyetujui akun');
    }

    if ($for == 'reject') {
        $user->status = 'rejected';
        $user->save();

        return redirect()->route('account-request.index')
            ->with('success', 'Berhasil menolak akun');
    }

    if (in_array($for, ['activate', 'deactivate'])) {
        $user->status = $for == 'activate' ? 'approved' : 'rejected';
        $user->save();

        return redirect()->route('account-list') // atau back() sesuai kebutuhan
            ->with('success', $for == 'activate'
                ? 'Berhasil mengaktifkan akun'
                : 'Berhasil menonaktifkan akun');
    }

    return back()->with('error', 'Aksi tidak dikenal');
}


    public function account_list_view()
    {
        $users = User::where('role_id', 2)->where('status', '!=', 'submitted')->get();
        return view ('pages.account-list.index',['users' => $users,
    ]);

    }
    public function profile_view()
    {

        return view('pages.profile.index', );
    }

    public function update_profile(Request $request, $userId)
    {
         $request->validate([
            'name' => 'required|min:3',

        ]);
        $user =User::findOrFail($userId);
        $user->name= $request->input('name');
        $user->save();

        return back()->with ('success', 'Berhasil mengubah data');
    }
    public function change_password_view()
    {
       return view('pages.profile.change-password') ;
    }
}
