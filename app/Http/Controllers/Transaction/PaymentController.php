<?php

namespace App\Http\Controllers\Transaction;

use Lang;
use Laratrust;
use DataTables;
use Carbon\Carbon;
use App\Models\Master\Item;
use App\Models\Master\Unit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Master\Doctor;
use App\Models\Master\Account;
use App\Models\Master\Service;
use App\Models\Master\Supplier;
use App\Models\Transaction\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\PaymentItem;


class PaymentController extends Controller
{
    public function index()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        return view('transaction.payment.index');
    }

    public function data()
    {
        if (!Laratrust::isAbleTo('view-transaction')) {
            return abort(404);
        }

        $payments = Payment::select('id', 'payment_code', 'payment_date', 'payment_type', 'payment_status')->orderByDesc('updated_at');

        return DataTables::of($payments)
            ->addColumn('payment_type', function ($payment) {
                $types = [1 => 'Cash', 2 => 'Non Cash', 3 => 'Petty Cash', 4 => 'Receivables'];
                return $types[$payment->payment_type] ?? 'Unknown';
            })
            ->addColumn('payment_status', function ($payment) {
                $status = [1 => 'Paid', 2 => 'Unpaid', 3 => 'Pending'];
                return $status[$payment->payment_status] ?? 'Unknown';
            })
            ->addColumn('action', function ($payment) {
                $edit = Laratrust::isAbleTo('update-transaction') ? '<a href="' . route('payment.edit', $payment->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit"><i class="la la-edit"></i></a>' : '';
                $delete = Laratrust::isAbleTo('delete-transaction') ? '<a href="#" data-href="' . route('payment.destroy', $payment->id) . '" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete" data-toggle="modal" data-target="#modal-delete"><i class="la la-trash"></i></a>' : '';

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
        $items = Item::all();
        $suppliers = Supplier::all();
        $units = Unit::all();

        return view('transaction.payment.create', compact(
            'accounts',
            'doctors',
            'items',
            'suppliers',
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
            'doctor_id' => ['nullable', 'exists:doctors,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'items' => ['sometimes', 'array'],
        ]);

        // Calculate total amount from all items
        $totalAmount = 0;
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $totalAmount += $item['total_price'] ?? 0; // Add each item's total price to the total amount
            }
        }

        $payment = Payment::create([
            'payment_code' => 'PY-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(4)),
            'payment_date' => Carbon::now(),
            'payment_type' => $request->payment_type,
            'payment_status' => $request->payment_status,
            'amount' => $totalAmount,
            'account_id' => $request->account_id,
            'doctor_id' => $request->doctor_id,
            'supplier_id' => $request->supplier_id,
            'note' => $request->note,
            'created_by' => Auth::id(),
        ]);

        if ($request->has('items')) {
            foreach ($request->items as $index => $medicine) {
                $paymentItem = new PaymentItem([
                    'payment_id' => $payment->id,
                    'item_id' => $medicine['item_id'] ?? null,
                    'item_code' => $medicine['item_code'] ?? null,
                    'item_name' => $medicine['item_name'] ?? null,
                    'item_qty' => $medicine['item_qty'] ?? null,
                    'item_unit' => $medicine['item_unit'] ?? null,
                    'unit_price' => $medicine['unit_price'] ?? null,
                    'total_price' => $medicine['total_price'] ?? null,
                    'item_type' => $medicine['item_type'] ?? null,
                ]);
                $paymentItem->save();
            }
        }

        return redirect()->route('payment.index')->with('status', 'Payment created successfully.');
    }

    public function edit($id)
    {
        if (!Laratrust::isAbleTo('update-transaction')) {
            return abort(404);
        }

        $accounts = Account::all();
        $doctors = Doctor::all();
        $items = Item::all();
        $payment = Payment::with('items')->findOrFail($id);
        $suppliers = Supplier::all();
        $units = Unit::all();

        return view('transaction.payment.edit', compact(
            'accounts',
            'doctors',
            'items',
            'payment',
            'suppliers',
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
            'doctor_id' => ['nullable', 'exists:doctors,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'items' => ['sometimes', 'array'],
        ]);

        // Find the existing payment
        $payment = Payment::findOrFail($id);

        // Calculate total amount from all items
        $totalAmount = 0;
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $totalAmount += $item['total_price'] ?? 0; // Add each item's total price to the total amount
            }
        }

        // Update the payment fields
        $payment->update([
            'payment_type' => $request->payment_type,
            'payment_status' => $request->payment_status,
            'amount' => $request->amount ?? $totalAmount,
            'account_id' => $request->account_id,
            'doctor_id' => $request->doctor_id,
            'supplier_id' => $request->supplier_id,
            'note' => $request->note,
            'updated_by' => Auth::id(),
        ]);

        // Update items
        if ($request->has('items')) {
            // Clear existing items for the payment
            $payment->items()->delete();

            foreach ($request->items as $medicine) {
                $paymentItem = new PaymentItem([
                    'payment_id' => $payment->id,
                    'item_id' => $medicine['item_id'] ?? null,
                    'item_code' => $medicine['item_code'] ?? null,
                    'item_name' => $medicine['item_name'] ?? null,
                    'item_qty' => $medicine['item_qty'] ?? null,
                    'item_unit' => $medicine['item_unit'] ?? null,
                    'unit_price' => $medicine['unit_price'] ?? null,
                    'total_price' => $medicine['total_price'] ?? null,
                    'item_type' => $medicine['item_type'] ?? null,
                ]);
                $paymentItem->save();
            }
        }

        return redirect()->route('payment.index')->with('status', 'Payment updated successfully.');
    }

    public function destroy($id)
    {
        if (!Laratrust::isAbleTo('delete-transaction')) {
            return abort(404);
        }

        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('payment.index')->with('status', 'Payment deleted successfully.');
    }
}
