<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function account_request_view()
    {
        $users = User::where('status', 'submitted')->get();
        $residents = Resident::where('user_Id', null)->get();
        return view('pages.account-request.index',['users' => $users,
        'residents' => $residents,
    ]);

    }
    public function account_approval(Request $request, $userId)
{
    $request->validate([
        'for' => ['required', Rule::in(['approve', 'reject', 'deactive'])],
        'resident_id' => ['nullable', 'exists:users,id']
    ]);

    $for = $request->input('for');
    $user = User::findOrFail($userId);

    if ($for == 'approve') {
        $user->status = 'approved';
        $user->save();

        $residentId = $request->input('resident_id');

        if($request->has('resident_id') &&  isset ($residentId)){
            Resident::where('id',$residentId)
            ->update(['user_id'=> $user->id
            ,]);
        }

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
    public function change_password(Request $request, $userId){
        $request->validate([
            'old_password' => 'required|min:8',
             'new_password' => 'required|min:8',
        ]);
        $user =User::findOrFail($userId);

        // $currentPasswordIsValid = Hash::check($request->input('old_password'), $user->password);

        // Cek password lama
    if (!Hash::check($request->old_password, $user->password)) {
        return back()->with('error', 'Gagal mengubah password, password lama tidak valid');
    }

    // Simpan password baru (pakai Hash::make)
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Password berhasil diubah!');
}

    //     if($currentPasswordIsValid){
    //         $user->password = $request->input('new_password');
    //     $user->save();

    //     return back()->with ('success', 'Berhasil mengubah data');
    //     }
    //     return back()->with('error', 'gagal mengubah password, password lama tidak valid');





    // }
}
