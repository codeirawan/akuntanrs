<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Unit;
use DataTables;
use Illuminate\Http\Request;
use Lang;
use Laratrust;

class UnitController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        return view('master.unit.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        $units = Unit::select('id', 'unit_name');

        return DataTables::of($units)
            ->addColumn('action', function ($unit) {
                $edit = '<a href="' . route('master.unit.edit', $unit->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.unit.destroy', $unit->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $unit->unit_name . '"><i class="la la-trash"></i></a>';

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

        return view('master.unit.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        $this->validate($request, [
            'unit_name' => ['required', 'string', 'max:191'],
        ]);

        $unit = new Unit;
        $unit->unit_name = $request->unit_name;
        $unit->created_by = auth()->user()->id; // Assuming you are setting created_by from authenticated user
        $unit->save();

        $message = Lang::get('Unit') . ' \'' . $unit->unit_name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.unit.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $unit = Unit::select('id', 'unit_name')->findOrFail($id);

        return view('master.unit.edit', compact('unit'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $unit = Unit::findOrFail($id);

        $this->validate($request, [
            'unit_name' => ['required', 'string', 'max:191'],
        ]);

        $unit->unit_name = $request->unit_name;
        $unit->updated_by = auth()->user()->id; // Assuming you are setting updated_by from authenticated user
        $unit->save();

        $message = Lang::get('Unit') . ' \'' . $unit->unit_name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.unit.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-master')) {
            return abort(404);
        }

        $unit = Unit::findOrFail($id);
        $name = $unit->unit_name;
        $unit->delete();

        $message = Lang::get('Unit') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.unit.index')->with('status', $message);
    }
}
