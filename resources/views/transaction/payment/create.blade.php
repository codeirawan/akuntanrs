@extends('layouts.app')

@section('title')
    {{ __('Create Payment Transaction') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('payment.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Payment') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('payment.create') }}" class="kt-subheader__breadcrumbs-link">{{ __('Create') }}
        {{ __('Payment Transaction') }}</a>
@endsection

@section('content')
    <form class="kt-form" method="POST" action="{{ route('payment.store') }}">
        @csrf
        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title"></h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('payment.index') }}" class="btn btn-secondary kt-margin-r-10">
                        <i class="la la-arrow-left"></i>
                        <span class="kt-hidden-mobile">{{ __('Back') }}</span>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="la la-check"></i>
                        <span class="kt-hidden-mobile">{{ __('Save') }}</span>
                    </button>
                </div>
            </div>
            <div class="kt-portlet__body">



                @if (request()->is('payment/create/doctor*'))
                    <!-- Group 1: Doctor Information -->
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
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
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
                                        value="{{ old('amount') }}" autocomplete="off"
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

                @if (request()->is('payment/create/item*'))
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
                                                {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}
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
                                        <tr class="item-row">
                                            <td>
                                                <select name="items[0][item_id]" class="form-control item-select">
                                                    <option value="">{{ __('Select item option') }}</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->id }}"
                                                            data-price="{{ $item->price }}"
                                                            data-unit="{{ $item->unit }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" name="items[0][item_qty]"
                                                    class="form-control item-quantity" min="1" value="1">
                                            </td>
                                            <td><input type="text" name="items[0][item_unit]"
                                                    class="form-control item-unit" readonly></td>
                                            <td><input type="number" name="items[0][unit_price]"
                                                    class="form-control item-price" readonly></td>
                                            <td><input type="number" name="items[0][total_price]"
                                                    class="form-control item-total-price" readonly></td>
                                        </tr>
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
                                    {{-- <option value="">{{ __('Select payment type') }}</option> --}}
                                    <option value="1">{{ __('Cash') }}</option>
                                    <option value="2">{{ __('Non Cash') }}</option>
                                    <option value="3">{{ __('Petty Cash') }}</option>
                                    <option value="4">{{ __('Receivables') }}</option>
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
                                    <option value="1">{{ __('Paid') }} </option>
                                    <option value="2">{{ __('Unpaid') }}</option>
                                    <option value="3">{{ __('Pending') }}</option>
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
                                            {{ old('account_id') == $account->id ? 'selected' : '' }}>
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
                        @if (request()->is('payment/create/item*'))
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label>{{ __('Total Amount for Items') }}</label>
                                    <input type="number" id="items-total" class="form-control" readonly>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <label>{{ __('Total Amount for Payment') }}</label>
                                    <input type="number" id="grand-total" class="form-control" readonly>
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
            // Update supplier information based on selected supplier
            $('select[name="supplier_id"]').change(function() {
                var selectedOption = $(this).find('option:selected');
                $('#contact').val(selectedOption.data('contact'));
                $('#age').val(selectedOption.data('age'));
                $('#gender').val(selectedOption.data('gender'));
                $('#insurance_name').val(selectedOption.data('insurance-name'));
                $('#insurance_no').val(selectedOption.data('insurance-id'));
                $('#phone').val(selectedOption.data('phone'));
                $('#email').val(selectedOption.data('email'));
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var rowIndex = 1; // Start row index after the first row


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

            // Initialize the first row
            updateItemRow($('#item-table-body .item-row').first());
        });
    </script>
@endsection
