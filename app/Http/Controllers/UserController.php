<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
