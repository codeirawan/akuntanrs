<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Company;
use Illuminate\Http\Request;
use Lang;
use Laratrust;

class CompanyController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $company = Company::select('id', 'name', 'address', 'phone', 'email')->first();

        return view('master.company.index', compact('company'));
    }

    public function update($id = null, Request $request)
    {
        if (!Laratrust::isAbleTo('update-master')) {
            return abort(404);
        }

        $this->validate($request, [
            'name' => ['required', 'string', 'max:191'],
            'address' => ['nullable', 'string', 'max:191'],
            'phone' => ['nullable', 'string', 'max:191'],
            'email' => ['nullable', 'string', 'max:191'],
        ]);

        $company = Company::find($id);
        if ($company) {
            $company->updated_by = auth()->user()->id;
            $message = Lang::get('Company') . ' \'' . $company->name . '\' ' . Lang::get('successfully updated.');
        } else {
            $company = new Company;
            $company->created_by = auth()->user()->id;
            $message = Lang::get('Company') . ' \'' . $company->name . '\' ' . Lang::get('successfully created.');
        }

        $company->name = $request->name;
        $company->address = $request->address;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->save();

        return redirect()->route('master.company.index')->with('status', $message);
    }
}
