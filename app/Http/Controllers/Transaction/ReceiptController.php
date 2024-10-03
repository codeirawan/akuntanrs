<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Master\Account;
use App\Models\Master\Doctor;
use App\Models\Master\Item;
use App\Models\Master\Service;
use App\Models\Master\Unit;
use App\Models\Transaction\Patient;
use App\Models\Transaction\Receipt;
use App\Models\Transaction\ReceiptItem;
use App\Models\Transaction\ReceiptService;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Lang;
use Laratrust;


class ReceiptController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        return view('transaction.receipt.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        $receipts = Receipt::select('id', 'receipt_code', 'receipt_date', 'payment_type', 'payment_status')->orderByDesc('updated_at');

        return DataTables::of($receipts)
            // ->addColumn('service_type', function ($receipt) {
            //     $types = [1 => 'Rawat Inap', 2 => 'Rawat Jalan', 3 => 'Pembelian Obat'];
            //     return $types[$receipt->service_type] ?? 'Unknown';
            // })
            ->addColumn('payment_type', function ($receipt) {
                $types = [1 => 'Cash', 2 => 'Non Cash', 3 => 'Petty Cash', 4 => 'Receivables'];
                return $types[$receipt->payment_type] ?? 'Unknown';
            })
            ->addColumn('payment_status', function ($receipt) {
                $status = [1 => 'Paid', 2 => 'Unpaid', 3 => 'Pending'];
                return $status[$receipt->payment_status] ?? 'Unknown';
            })
            ->addColumn('action', function ($receipt) {
                $edit = Laratrust::isAbleTo('update-transaction') ? '<a href="' . route('receipt.edit', $receipt->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit"><i class="la la-edit"></i></a>' : '';
                $delete = Laratrust::isAbleTo('delete-transaction') ? '<a href="#" data-href="' . route('receipt.destroy', $receipt->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete" data-toggle="modal" data-target="#modal-delete"><i class="la la-trash"></i></a>' : '';

                return $edit . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!Laratrust::isAbleTo('create-transaction')) {
            return abort(404);
        }

        $accounts = Account::all();
        $doctors = Doctor::all();
        $medicines = Item::all();
        $patients = Patient::all();
        $services = Service::all();
        $units = Unit::all();

        return view('transaction.receipt.create', compact(
            'accounts',
            'doctors',
            'medicines',
            'patients',
            'services',
            'units',
        ));
    }

    public function store(Request $request)
    {
        if (!Laratrust::isAbleTo('create-transaction')) {
            return abort(404);
        }

        $this->validate($request, [
            'payment_type' => ['required', 'integer', 'in:1,2,3,4'],
            'payment_status' => ['required', 'integer', 'in:1,2,3'],
            'account_id' => ['required', 'exists:accounts,id'],
            'services' => ['sometimes', 'array'],
            'medicines' => ['sometimes', 'array'],
        ]);

        $totalAmountService = 0;
        if ($request->has('services')) {
            foreach ($request->services as $item) {
                $totalAmountService += $services['price'] ?? 0;
            }
        }

        $totalAmountMedicine = 0;
        if ($request->has('medicines')) {
            foreach ($request->medicines as $medicine) {
                $totalAmountMedicine += $medicine['total_price'] ?? 0;
            }
        }

        $receipt = Receipt::create([
            'receipt_code' => 'RC-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(4)),
            'receipt_date' => Carbon::now(),
            'payment_type' => $request->payment_type,
            'payment_status' => $request->payment_status,
            'account_id' => $request->account_id,
            'patient_id' => $request->patient_id,
            'amount' => $totalAmountService + $totalAmountMedicine,
            'note' => $request->note,
            'created_by' => Auth::id(),
        ]);

        if ($request->has('services')) {
            foreach ($request->services as $index => $service) {
                $receiptService = new ReceiptService([
                    'receipt_id' => $receipt->id,
                    'service_id' => $service['service_id'] ?? null,
                    'unit_id' => $service['unit_id'] ?? null,
                    'doctor_id' => $service['doctor_id'] ?? null,
                    'price' => $service['price'] ?? null,
                ]);
                $receiptService->save();
            }
        }

        if ($request->has('medicines')) {
            foreach ($request->medicines as $index => $medicine) {
                $receiptItem = new ReceiptItem([
                    'receipt_id' => $receipt->id,
                    'item_id' => $medicine['item_id'] ?? null,
                    'item_code' => $medicine['item_code'] ?? null,
                    'item_name' => $medicine['item_name'] ?? null,
                    'item_qty' => $medicine['item_qty'] ?? null,
                    'item_unit' => $medicine['item_unit'] ?? null,
                    'unit_price' => $medicine['unit_price'] ?? null,
                    'total_price' => $medicine['total_price'] ?? null,
                    'item_type' => $medicine['item_type'] ?? null,
                ]);
                $receiptItem->save();
            }
        }

        return redirect()->route('receipt.index')->with('status', 'Receipt created successfully.');
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-transaction')) {
            return abort(404);
        }

        $accounts = Account::all();
        $doctors = Doctor::all();
        $medicines = Item::all();
        $patients = Patient::all();
        $receipt = Receipt::with('medicines', 'services')->findOrFail($id);
        $services = Service::all();
        $units = Unit::all();

        return view('transaction.receipt.edit', compact(
            'accounts',
            'doctors',
            'medicines',
            'patients',
            'receipt',
            'services',
            'units',
        ));
    }

    public function update(Request $request, $id)
    {
        if (!Laratrust::isAbleTo('update-transaction')) {
            return abort(404);
        }

        // Validate the incoming request data
        $this->validate($request, [
            'payment_type' => ['required', 'integer', 'in:1,2,3,4'],
            'payment_status' => ['required', 'integer', 'in:1,2,3'],
            'account_id' => ['required', 'exists:accounts,id'],
            'services' => ['sometimes', 'array'],
            'medicines' => ['sometimes', 'array'],
        ]);

        // Find the existing receipt
        $receipt = Receipt::findOrFail($id);

        // Update the receipt fields
        $receipt->update([
            'payment_type' => $request->payment_type,
            'payment_status' => $request->payment_status,
            'account_id' => $request->account_id,
            'patient_id' => $request->patient_id,
            'note' => $request->note,
            'updated_by' => Auth::id(),
        ]);

        // Update services
        if ($request->has('services')) {
            // Clear existing services for the receipt
            $receipt->services()->delete();

            foreach ($request->services as $service) {
                $receiptService = new ReceiptService([
                    'receipt_id' => $receipt->id,
                    'service_id' => $service['service_id'] ?? null,
                    'unit_id' => $service['unit_id'] ?? null,
                    'doctor_id' => $service['doctor_id'] ?? null,
                    'price' => $service['price'] ?? null,
                ]);
                $receiptService->save();
            }
        }

        // Update medicines
        if ($request->has('medicines')) {
            // Clear existing medicines for the receipt
            $receipt->medicines()->delete();

            foreach ($request->medicines as $medicine) {
                $receiptItem = new ReceiptItem([
                    'receipt_id' => $receipt->id,
                    'item_id' => $medicine['item_id'] ?? null,
                    'item_code' => $medicine['item_code'] ?? null,
                    'item_name' => $medicine['item_name'] ?? null,
                    'item_qty' => $medicine['item_qty'] ?? null,
                    'item_unit' => $medicine['item_unit'] ?? null,
                    'unit_price' => $medicine['unit_price'] ?? null,
                    'total_price' => $medicine['total_price'] ?? null,
                    'item_type' => $medicine['item_type'] ?? null,
                ]);
                $receiptItem->save();
            }
        }

        return redirect()->route('receipt.index')->with('status', 'Receipt updated successfully.');
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-transaction')) {
            return abort(404);
        }

        $receipt = Receipt::findOrFail($id);
        $receipt->delete();

        return redirect()->route('receipt.index')->with('status', 'Receipt deleted successfully.');
    }
}
