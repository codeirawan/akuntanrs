<?php

namespace App\Http\Controllers\Transaction;

use Lang;
use Laratrust;
use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Transaction\Patient;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        return view('transaction.patient.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        $patients = Patient::select('id', 'name', 'nik', 'dob', 'gender', 'address', 'phone', 'email', 'insurance_name', 'insurance_no', 'note');

        return DataTables::of($patients)
            ->addColumn('age', function ($patient) {
                return Carbon::parse($patient->dob)->age;
            })
            ->addColumn('gender', function ($patient) {
                return $patient->gender == '0' ? 'P' : 'L';
            })
            ->addColumn('action', function ($patient) {
                $edit = '<a href="' . route('patient.edit', $patient->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('patient.destroy', $patient->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $patient->name . '"><i class="la la-trash"></i></a>';

                return (Laratrust::isAbleTo('update-transaction') ? $edit : '') . (Laratrust::isAbleTo('delete-transaction') ? $delete : '');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-transaction')) {
            return abort(404);
        }

        return view('transaction.patient.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-transaction')) {
            return abort(404);
        }

        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'nik' => ['required', 'string', 'max:191', 'unique:patients,nik'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'in:0,1'],  // Expecting 0 for female, 1 for male
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:15'],
            'email' => ['nullable', 'email', 'max:191'],
            'insurance_name' => ['nullable', 'string', 'max:191'],
            'insurance_no' => ['nullable', 'string', 'max:191'],
            'note' => ['nullable', 'string'],

        ]);

        $patient = new Patient;
        $patient->name = $request->name;
        $patient->nik = $request->nik;
        $patient->dob = $request->dob;
        $patient->gender = $request->gender;
        $patient->address = $request->address;
        $patient->phone = $request->phone;
        $patient->email = $request->email;
        $patient->insurance_name = $request->insurance_name;
        $patient->insurance_no = $request->insurance_no;
        $patient->note = $request->note;
        $patient->created_by = auth()->user()->id;
        $patient->save();

        $message = Lang::get('Patient') . ' \'' . $patient->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('patient.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-transaction')) {
            return abort(404);
        }

        $patient = Patient::findOrFail($id);

        return view('transaction.patient.edit', compact('patient'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-transaction')) {
            return abort(404);
        }

        $patient = Patient::findOrFail($id);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'nik' => ['required', 'string', 'max:191', 'unique:patients,nik,' . $patient->id],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'in:0,1'],  // Expecting 0 for female, 1 for male
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:15'],
            'email' => ['nullable', 'email', 'max:191'],
            'insurance_name' => ['nullable', 'string', 'max:191'],
            'insurance_no' => ['nullable', 'string', 'max:191'],
            'note' => ['nullable', 'string'],
        ]);

        $patient->name = $request->name;
        $patient->nik = $request->nik;
        $patient->dob = $request->dob;
        $patient->gender = $request->gender;
        $patient->address = $request->address;
        $patient->phone = $request->phone;
        $patient->email = $request->email;
        $patient->insurance_name = $request->insurance_name;
        $patient->insurance_no = $request->insurance_no;
        $patient->note = $request->note;
        $patient->updated_by = auth()->user()->id;
        $patient->save();

        $message = Lang::get('Patient') . ' \'' . $patient->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('patient.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-transaction')) {
            return abort(404);
        }

        $patient = Patient::findOrFail($id);
        $name = $patient->name;
        $patient->delete();

        $message = Lang::get('Patient') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('patient.index')->with('status', $message);
    }
}
