<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Item;
use DataTables;
use Illuminate\Http\Request;
use Lang;
use Laratrust;

class ItemController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        return view('master.item.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        $items = Item::select('id', 'code', 'name', 'unit', 'price', 'category');

        return DataTables::of($items)
            ->addColumn('action', function ($item) {
                $edit = '<a href="' . route('master.item.edit', $item->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.item.destroy', $item->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $item->name . '"><i class="la la-trash"></i></a>';

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

        return view('master.item.create');
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        $this->validate($request, [
            'code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'unit' => ['required', 'string', 'max:191'],
            'price' => ['required', 'numeric'],
            'category' => ['required', 'in:1,2,3'],
        ]);

        $item = new Item;
        $item->code = $request->code;
        $item->name = $request->name;
        $item->unit = $request->unit;
        $item->price = $request->price;
        $item->category = $request->category;
        $item->created_by = auth()->user()->id;
        $item->save();

        $message = Lang::get('Item') . ' \'' . $item->name . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.item.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $item = Item::findOrFail($id);

        return view('master.item.edit', compact('item'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $item = Item::findOrFail($id);

        $this->validate($request, [
            'code' => ['required', 'string', 'max:191'],
            'name' => ['required', 'string', 'max:191'],
            'unit' => ['required', 'string', 'max:191'],
            'price' => ['required', 'numeric'],
            'category' => ['required', 'in:1,2,3'],
        ]);

        $item->code = $request->code;
        $item->name = $request->name;
        $item->unit = $request->unit;
        $item->price = $request->price;
        $item->category = $request->category;
        $item->updated_by = auth()->user()->id;
        $item->save();

        $message = Lang::get('Item') . ' \'' . $item->name . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.item.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-master')) {
            return abort(404);
        }

        $item = Item::findOrFail($id);
        $name = $item->name;
        $item->delete();

        $message = Lang::get('Item') . ' \'' . $name . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.item.index')->with('status', $message);
    }
}
