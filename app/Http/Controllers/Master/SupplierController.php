<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Supplier;
use DataTables;
use Illuminate\Http\Request;
use Lang;
use Laratrust;

class SupplierController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        return view('master.supplier.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        $suppliers = Supplier::select('id', 'name', 'contact', 'address');

        return DataTables::of($suppliers)
            ->addColumn('action', function ($supplier) {
                $edit = '<a href="' . route('master.supplier.edit', $supplier->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.supplier.destroy', $supplier->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $supplier->name . '"><i class="la la-trash"></i></a>';

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

        return view('master.supplier.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'contact' => ['required', 'string', 'max:191'],
            'address' => ['required', 'string', 'max:191'],
        ]);

        $supplier = new Supplier;
        $supplier->name = $request->name;
        $supplier->contact = $request->contact;
        $supplier->address = $request->address;
        $supplier->created_by = auth()->user()->id;
        $supplier->save();

        $message = Lang::get('Supplier') . ' \'' . $supplier->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.supplier.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $supplier = Supplier::findOrFail($id);

        return view('master.supplier.edit', compact('supplier'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $supplier = Supplier::findOrFail($id);

        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'contact' => ['required', 'string', 'max:191'],
            'address' => ['required', 'string', 'max:191'],
        ]);

        $supplier->name = $request->name;
        $supplier->contact = $request->contact;
        $supplier->address = $request->address;
        $supplier->updated_by = auth()->user()->id;
        $supplier->save();

        $message = Lang::get('Supplier') . ' \'' . $supplier->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.supplier.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-master')) {
            return abort(404);
        }

        $supplier = Supplier::findOrFail($id);
        $name = $supplier->name;
        $supplier->delete();

        $message = Lang::get('Supplier') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.supplier.index')->with('status', $message);
    }
}
