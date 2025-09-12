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
        $for =$request->input('for');
        $user = User::findOrFail($userId);
        $user->status = $for =='approve' ? 'approved' :'rejected';
        $user->save();

        return back()->with ('success', $for == 'approve' ? 'Berhasil menyetujui akun' : 'Berhasil menolak akun') ;
        //  return redirect()
        // ->route('account-request.index') // ganti dengan route index kamu
        // ->with('success', $for == 'approve'
        //     ? 'Berhasil menyetujui akun'
        //     : 'Berhasil menolak akun');
    }

    public function account_list_view()
    {
        $users = User::where('role_id', 2)->where('status', '!=', 'submitted')->get();
        return view ('pages.account-list.index',['users' => $users,
    ]);

    }
}
