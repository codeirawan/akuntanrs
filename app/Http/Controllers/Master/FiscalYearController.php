<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\FiscalYear;
use App\Models\Master\Company;
use DataTables;
use Illuminate\Http\Request;
use Lang;
use Laratrust;

class FiscalYearController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        return view('master.fiscal-year.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-master')) {
            return abort(404);
        }

        // $fiscalYears = FiscalYear::with('company:id,name')->select('id', 'company_id', 'start_date', 'end_date');
        $fiscalYears = FiscalYear::select('id', 'company_id', 'start_date', 'end_date')->orderByDesc('id');

        return DataTables::of($fiscalYears)
            ->addColumn('company', function ($fiscalYear) {
                return $fiscalYear->start_date;
            })
            ->addColumn('action', function ($fiscalYear) {
                $edit = '<a href="' . route('master.fiscal-year.edit', $fiscalYear->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Edit') . '"><i class="la la-edit"></i></a>';
                $delete = '<a href="#" data-href="' . route('master.fiscal-year.destroy', $fiscalYear->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-tooltip" title="' . Lang::get('Delete') . '" data-toggle="modal" data-target="#modal-delete" data-key="' . $fiscalYear->start_date . '"><i class="la la-trash"></i></a>';

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

        $companies = Company::all(); // Fetch companies for the select dropdown

        return view('master.fiscal-year.create', compact('companies'));
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-master')) {
            return abort(404);
        }

        $this->validate($request, [
            'company_id' => ['nullable', 'exists:company,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $company = Company::select('id', 'name', 'address', 'phone', 'email')->first();

        $fiscalYear = new FiscalYear;
        $fiscalYear->company_id = $company->id;
        $fiscalYear->start_date = $request->start_date;
        $fiscalYear->end_date = $request->end_date;
        $fiscalYear->created_by = auth()->user()->id;
        $fiscalYear->save();

        $message = Lang::get('Fiscal Year for') . ' \'' . $fiscalYear->start_date . '\' ' . Lang::get('successfully created.');
        return redirect()->route('master.fiscal-year.index')->with('status', $message);
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $fiscalYear = FiscalYear::findOrFail($id);
        $companies = Company::all();

        return view('master.fiscal-year.edit', compact('fiscalYear', 'companies'));
    }

    public function update($id, Request $request)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $fiscalYear = FiscalYear::findOrFail($id);

        $this->validate($request, [
            'company_id' => ['nullable', 'exists:company,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $fiscalYear->start_date = $request->start_date;
        $fiscalYear->end_date = $request->end_date;
        $fiscalYear->updated_by = auth()->user()->id;
        $fiscalYear->save();

        $message = Lang::get('Fiscal Year for') . ' \'' . $fiscalYear->start_date . '\' ' . Lang::get('successfully updated.');
        return redirect()->route('master.fiscal-year.index')->with('status', $message);
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-master')) {
            return abort(404);
        }

        $fiscalYear = FiscalYear::findOrFail($id);
        $companyName = $fiscalYear->start_date;
        $fiscalYear->delete();

        $message = Lang::get('Fiscal Year for') . ' \'' . $companyName . '\' ' . Lang::get('successfully deleted.');
        return redirect()->route('master.fiscal-year.index')->with('status', $message);
    }
}
