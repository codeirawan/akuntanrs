<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Patient;
use DataTables;
use Illuminate\Http\Request;
use Lang;
use Laratrust;

class PatientController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        return view('master.patient.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        $patients = Patient::select('id', 'name', 'nik', 'dob', 'gender', 'address');

        return DataTables::of($patients)
            ->addColumn('gender', function ($patient) {
                return $patient->gender == 'p' ? 'Perempuan' : 'Laki-laki';
            })
            ->addColumn('action', function ($patient) {
                $edit = '<a href="' . route('master.patient.edit', $patient->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.patient.destroy', $patient->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $patient->name . '"><i class="la la-trash"></i></a>';

                return (Laratrust::isAbleTo('update-master') ? $edit : '') . (Laratrust::isAbleTo('delete-master') ? $delete : '');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        return view('master.patient.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'nik' => ['required', 'string', 'max:191', 'unique:patients,nik'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'in:p,l'],
            'address' => ['required', 'string'],
        ]);

        $patient = new Patient;
        $patient->name = $request->name;
        $patient->nik = $request->nik;
        $patient->dob = $request->dob;
        $patient->gender = $request->gender;
        $patient->address = $request->address;
        $patient->created_by = auth()->user()->id;
        $patient->save();

        $message = Lang::get('Patient') . ' \'' . $patient->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.patient.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $patient = Patient::findOrFail($id);

        return view('master.patient.edit', compact('patient'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $patient = Patient::findOrFail($id);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'nik' => ['required', 'string', 'max:191', 'unique:patients,nik,' . $patient->id],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'in:p,l'],
            'address' => ['required', 'string'],
        ]);

        $patient->name = $request->name;
        $patient->nik = $request->nik;
        $patient->dob = $request->dob;
        $patient->gender = $request->gender;
        $patient->address = $request->address;
        $patient->updated_by = auth()->user()->id;
        $patient->save();

        $message = Lang::get('Patient') . ' \'' . $patient->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.patient.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-master')) {
            return abort(404);
        }

        $patient = Patient::findOrFail($id);
        $name = $patient->name;
        $patient->delete();

        $message = Lang::get('Patient') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.patient.index')->with('status', $message);
    }
}
