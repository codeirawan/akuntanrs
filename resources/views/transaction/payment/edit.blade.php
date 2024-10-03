@extends('layouts.app')

@section('title')
    {{ __('Edit Payment Transaction') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('payment.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Payment') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('payment.edit', $payment->id) }}" class="kt-subheader__breadcrumbs-link">{{ __('Edit') }}
        {{ __('Payment Transaction') }}</a>
@endsection

@section('content')
    <form class="kt-form" method="POST" action="{{ route('payment.update', $payment->id) }}">
        @csrf
        @method('PUT')
        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Edit Payment Transaction') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('payment.index') }}" class="btn btn-secondary kt-margin-r-10">
                        <i class="la la-arrow-left"></i>
                        <span class="kt-hidden-mobile">{{ __('Back') }}</span>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="la la-check"></i>
                        <span class="kt-hidden-mobile">{{ __('Save Changes') }}</span>
                    </button>
                </div>
            </div>
            <div class="kt-portlet__body">

                @if ($payment->doctor_id)
                    <div class="card mb-4">
                        <div class="card-header">{{ __('Doctor Information') }}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>{{ __('Doctor') }}</label>
                                    <select name="doctor_id"
                                        class="form-control kt_selectpicker @error('doctor_id') is-invalid @enderror"
                                        required data-live-search="true" title="{{ __('Choose') }} {{ __('Doctor') }}">
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}"
                                                {{ old('doctor_id', $payment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                                {{ $doctor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="amount">{{ __('Amount') }}</label>
                                    <input id="amount" name="amount" type="number"
                                        class="form-control @error('amount') is-invalid @enderror" required
                                        value="{{ old('amount', $payment->amount) }}" autocomplete="off"
                                        placeholder="{{ __('Total Amount') }}">

                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($payment->supplier_id)
                    <!-- Group 2: Supplier Information -->
                    <div class="card mb-4">
                        <div class="card-header">{{ __('Supplier Information') }}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>{{ __('Supplier') }}</label>
                                    <select name="supplier_id"
                                        class="form-control kt_selectpicker @error('supplier_id') is-invalid @enderror"
                                        required data-live-search="true" title="{{ __('Choose') }} {{ __('Supplier') }}">
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ old('supplier_id', $payment->supplier_id) == $supplier->id ? 'selected' : '' }}
                                                data-contact="{{ $supplier->contact }}"> {{ $supplier->name }}
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Group 3: Item Information -->
                    <div class="card mb-4">
                        <div class="card-header">{{ __('Item Information') }}</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="item-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Quantity') }}</th>
                                            <th>{{ __('Unit') }}</th>
                                            <th>{{ __('Unit Price') }}</th>
                                            <th>{{ __('Total Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item-table-body">
                                        @foreach ($payment->items as $index => $item)
                                            <tr class="item-row">
                                                <td>
                                                    <select name="items[{{ $index }}][item_id]"
                                                        class="form-control item-select">
                                                        <option value="">{{ __('Select item option') }}</option>
                                                        @foreach ($items as $itemOption)
                                                            <option value="{{ $itemOption->id }}"
                                                                data-price="{{ $itemOption->price }}"
                                                                data-unit="{{ $itemOption->unit }}"
                                                                {{ $itemOption->id == $item->item_id ? 'selected' : '' }}>
                                                                {{ $itemOption->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" name="items[{{ $index }}][item_qty]"
                                                        class="form-control item-quantity" min="1"
                                                        value="{{ $item->item_qty }}">
                                                </td>
                                                <td><input type="text" name="items[{{ $index }}][item_unit]"
                                                        class="form-control item-unit" value="{{ $item->item_unit }}"
                                                        readonly>
                                                </td>
                                                <td><input type="number" name="items[{{ $index }}][unit_price]"
                                                        class="form-control item-price" value="{{ $item->unit_price }}"
                                                        readonly></td>
                                                <td><input type="number" name="items[{{ $index }}][total_price]"
                                                        class="form-control item-total-price"
                                                        value="{{ $item->total_price }}" readonly></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-dark ml-3"
                                    id="add-item-row">{{ __('Add Item') }}</button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Group 4: Payment Information -->
                <div class="card mb-4">
                    <div class="card-header">{{ __('Payment Information') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>{{ __('Payment Type') }}</label>
                                <select name="payment_type"
                                    class="form-control @error('payment_type') is-invalid @enderror" required>
                                    <option value="1" {{ $payment->payment_type == 1 ? 'selected' : '' }}>
                                        {{ __('Cash') }}</option>
                                    <option value="2" {{ $payment->payment_type == 2 ? 'selected' : '' }}>
                                        {{ __('Non Cash') }}</option>
                                    <option value="3" {{ $payment->payment_type == 3 ? 'selected' : '' }}>
                                        {{ __('Petty Cash') }}</option>
                                    <option value="4" {{ $payment->payment_type == 4 ? 'selected' : '' }}>
                                        {{ __('Receivables') }}</option>
                                </select>
                                @error('payment_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label>{{ __('Payment Status') }}</label>
                                <select name="payment_status"
                                    class="form-control @error('payment_status') is-invalid @enderror" required>
                                    <option value="1" {{ $payment->payment_status == 1 ? 'selected' : '' }}>
                                        {{ __('Paid') }}</option>
                                    <option value="2" {{ $payment->payment_status == 2 ? 'selected' : '' }}>
                                        {{ __('Unpaid') }}</option>
                                    <option value="3" {{ $payment->payment_status == 3 ? 'selected' : '' }}>
                                        {{ __('Pending') }}</option>
                                </select>
                                @error('payment_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label for="account_id">{{ __('Account') }}</label>
                                <select id="account_id" name="account_id"
                                    class="form-control kt_selectpicker @error('account_id') is-invalid @enderror" required
                                    data-live-search="true" title="{{ __('Choose') }} {{ __('Account') }}">
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}"
                                            {{ $payment->account_id == $account->id ? 'selected' : '' }}>
                                            {{ $account->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('account_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @if ($payment->supplier_id)
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>{{ __('Total Amount for Items') }}</label>
                                    <input type="number" id="items-total" class="form-control"
                                        value="{{ $payment->item_total }}" readonly>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <label>{{ __('Total Amount for Payment') }}</label>
                                    <input type="number" id="grand-total" class="form-control"
                                        value="{{ $payment->grand_total }}" readonly>
                                </div> --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            noneResultsText: "{{ __('No matching results for') }} {0}"
        });
    </script>

    <script>
        $(document).ready(function() {
            var rowIndex = {{ count($payment->items) }}; // Start from the existing items count

            // Function to update unit price, unit, and total price for each row
            function updateItemRow(row) {
                var selectedOption = row.find('.item-select option:selected');
                var price = selectedOption.data('price');
                var unit = selectedOption.data('unit');
                var quantity = row.find('.item-quantity').val();

                // Set the unit and price fields
                row.find('.item-unit').val(unit);
                row.find('.item-price').val(price);

                // Calculate total price (unit price * quantity)
                var totalPrice = price * quantity;
                row.find('.item-total-price').val(totalPrice.toFixed(2));

                // Update items total
                calculateItemTotal();
            }

            // Function to calculate the items total and update grand total
            function calculateItemTotal() {
                var itemTotal = 0;
                $('.item-total-price').each(function() {
                    itemTotal += parseFloat($(this).val()) || 0;
                });
                $('#items-total').val(itemTotal.toFixed(2));

                // Update grand total
                updateGrandTotal();
            }

            // Function to update the overall grand total
            function updateGrandTotal() {
                let serviceTotal = parseFloat($('#services-total').val()) || 0;
                let itemTotal = parseFloat($('#items-total').val()) || 0;
                let grandTotal = serviceTotal + itemTotal;

                $('#grand-total').val(grandTotal.toFixed(2)); // Display grand total
            }

            // Update item info when a item is selected
            $(document).on('change', '.item-select', function() {
                var row = $(this).closest('.item-row');
                updateItemRow(row);
            });

            // Update total price when the quantity changes
            $(document).on('input', '.item-quantity', function() {
                var row = $(this).closest('.item-row');
                updateItemRow(row);
            });

            // Add a new item row
            $('#add-item-row').click(function() {
                var newRow = `
                <tr class="item-row">
                    <td>
                        <select name="items[${rowIndex}][item_id]" class="form-control item-select">
                            <option value="">{{ __('Select item option') }}</option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->price }}" data-unit="{{ $item->unit }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[${rowIndex}][item_qty]" class="form-control item-quantity" min="1" value="1"></td>
                    <td><input type="text" name="items[${rowIndex}][item_unit]" class="form-control item-unit" readonly></td>
                    <td><input type="number" name="items[${rowIndex}][unit_price]" class="form-control item-price" readonly></td>
                    <td><input type="number" name="items[${rowIndex}][total_price]" class="form-control item-total-price" readonly></td>
                </tr>
            `;
                $('#item-table-body').append(newRow);
                rowIndex++; // Increment the row index for unique name attributes
            });

            // Initialize existing items and calculate totals
            $('.item-row').each(function() {
                updateItemRow($(this)); // Calculate for each existing item row
            });

            // Initialize services total from existing service rows
            function calculateServiceTotal() {
                var serviceTotal = 0;
                $('.service-row').each(function() {
                    var price = $(this).find('.service-price').val();
                    serviceTotal += parseFloat(price) || 0;
                });
                $('#services-total').val(serviceTotal.toFixed(2));
                updateGrandTotal(); // Update grand total after calculating service total
            }

            calculateServiceTotal(); // Initial calculation for services
            calculateItemTotal(); // Initial calculation for items
        });
    </script>
@endsection
