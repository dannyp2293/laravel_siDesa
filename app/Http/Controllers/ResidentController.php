<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResidentController extends Controller
{
    public function index()
    {
            $residents = Resident::all();

            return view('pages.resident.index',[
                'residents' => $residents,
            ]);
        }

            public function create()
            {
                return view('pages.resident.create');

            }

            public function store(Request $request)
            {
                $validateData = $request->validate([
                    'nik' => ['required', 'min:16', 'max:16'],
                    'name' => ['required',  'max:100'],
                    'gender' => ['required',Rule::in(['male', 'female'])],
                    'birth_date' => ['required', 'max:100'],
                    'birth_place' => ['required', 'max:100'],
                    'address' => ['required', 'max:700'],
                    'religion' => ['nullable', 'max:100'],
                    'marital_status' => ['required',Rule::in(['single', 'married', 'divorce'])],
                    'occupation' => ['nullable', 'max:100'],
                    'phone' => ['nullable', 'max:15'],
                    'status' => ['required',Rule::in(['active', 'moved', 'deceased'])],

                ]);
                Resident::create($validateData);
                return redirect('/resident')->with('Success', 'Berhasil menambahkan data');
            }
            public function edit($id)
            {
                $resident = Resident::findOrFail($id);

                return view('pages.resident.edit',['resident' => $resident, ]);
            }
            public function update(Request $request, $id)
            {
             $validateData = $request->validate([
                    'nik' => ['required', 'min:16', 'max:16'],
                    'name' => ['required',  'max:100'],
                    'gender' => ['required',Rule::in(['male', 'female'])],
                    'birth_date' => ['required', 'max:100'],
                    'address' => ['required', 'max:700'],
                    'religion' => ['nullable', 'max:100'],
                    'marital_status' => ['required',Rule::in(['single', 'married', 'divorce'])],
                     'occupation' => ['nullable', 'max:100'],
                       'phone' => ['nullable', 'max:15'],
                       'status' => ['required',Rule::in(['active', 'moved', 'deceased'])],

                ]);
                Resident::findOrFail($id)->update($validateData);
                return redirect('/resident')->with('Succes', 'Berhasil mengubah data');
            }

         public function destroy($id)
            {
                $resident = Resident::findOrFail($id);
                $resident->delete();
                return redirect('/resident')->with('succes', 'berhasil menghapus data');

            }
    }


