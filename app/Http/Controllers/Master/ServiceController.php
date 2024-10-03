<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Service;
use DataTables;
use Illuminate\Http\Request;
use Lang;
use Laratrust;

class ServiceController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        return view('master.service.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        $services = Service::select('id', 'service_code', 'service_name', 'price', 'description', 'service_type');

        return DataTables::of($services)
            ->addColumn('action', function ($service) {
                $edit = '<a href="' . route('master.service.edit', $service->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.service.destroy', $service->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $service->service_name . '"><i class="la la-trash"></i></a>';

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

        return view('master.service.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        $request->validate([
            'service_code' => 'required|string|max:50|unique:services',
            'service_name' => 'required|string|max:191',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'service_type' => 'required|integer|in:1,2,3,4,5',
        ]);

        Service::create([
            'service_code' => $request->service_code,
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description,
            'service_type' => $request->service_type,
            'created_by' => auth()->user()->id,
        ]);

        return redirect()->route('master.service.index')->with('status', Lang::get('Service') . ' \'' . $request->service_name . '\' ' . Lang::get('successfully created.'));
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $service = Service::findOrFail($id);

        return view('master.service.edit', compact('service'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $service = Service::findOrFail($id);

        $request->validate([
            'service_code' => 'required|string|max:50|unique:services,service_code,' . $service->id,
            'service_name' => 'required|string|max:191',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'service_type' => 'required|integer|in:1,2,3,4,5',
        ]);

        $service->update([
            'service_code' => $request->service_code,
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description,
            'service_type' => $request->service_type,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('master.service.index')->with('status', Lang::get('Service') . ' \'' . $service->service_name . '\' ' . Lang::get('successfully updated.'));
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-master')) {
            return abort(404);
        }

        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('master.service.index')->with('status', Lang::get('Service') . ' \'' . $service->service_name . '\' ' . Lang::get('successfully deleted.'));
    }
}
