<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Doctor;
use App\Models\Master\Specialty;
use DataTables;
use Illuminate\Http\Request;
use Lang;
use Laratrust;

class DoctorController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        return view('master.doctor.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        $doctors = Doctor::with('specialty')->select('id', 'name', 'specialty_id')->get();

        return DataTables::of($doctors)
            ->addColumn('specialty', function ($doctor) {
                return $doctor->specialty ? $doctor->specialty->name : '';
            })
            ->addColumn('action', function ($doctor) {
                $edit = Laratrust::isAbleTo('update-master') ?
                    '<a href="' . route('master.doctor.edit', $doctor->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>'
                    : '';

                $delete = Laratrust::isAbleTo('delete-master') ?
                    '<a href="#" data-href="' . route('master.doctor.destroy', $doctor->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $doctor->name . '"><i class="la la-trash"></i></a>'
                    : '';

                return $edit . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function create()
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        $specialties = Specialty::all();
        return view('master.doctor.create', compact('specialties'));
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'specialty_id' => ['required', 'exists:specialties,id'],
        ]);

        $doctor = new Doctor;
        $doctor->name = $request->name;
        $doctor->specialty_id = $request->specialty_id;
        $doctor->created_by = auth()->user()->id;
        $doctor->save();

        $message = Lang::get('Doctor') . ' \'' . $doctor->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.doctor.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $doctor = Doctor::findOrFail($id);
        $specialties = Specialty::all();

        return view('master.doctor.edit', compact('doctor', 'specialties'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $doctor = Doctor::findOrFail($id);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'specialty_id' => ['required', 'exists:specialties,id'],
        ]);

        $doctor->name = $request->name;
        $doctor->specialty_id = $request->specialty_id;
        $doctor->updated_by = auth()->user()->id;
        $doctor->save();

        $message = Lang::get('Doctor') . ' \'' . $doctor->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.doctor.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-master')) {
            return abort(404);
        }

        $doctor = Doctor::findOrFail($id);
        $name = $doctor->name;
        $doctor->delete();

        $message = Lang::get('Doctor') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.doctor.index')->with('status', $message);
    }
}
