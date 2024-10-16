@extends('layouts.app')

@section('title')
    {{ __('Edit Receipt Transaction') }} | {{ config('app.name') }}
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('receipt.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Receipt') }}</a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('receipt.edit', $receipt->id) }}" class="kt-subheader__breadcrumbs-link">{{ __('Edit') }}
        {{ __('Receipt Transaction') }}</a>
@endsection

@section('content')
    <form class="kt-form" method="POST" action="{{ route('receipt.update', $receipt->id) }}">
        @csrf
        @method('PUT')
        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Edit Receipt Transaction') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('receipt.index') }}" class="btn btn-secondary kt-margin-r-10">
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

                @if ($receipt->patient_id)
                    <!-- Group 1: Patient Information -->
                    <div class="card mb-4">
                        <div class="card-header">{{ __('Patient Information') }}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>{{ __('Patient') }}</label>
                                    <select name="patient_id"
                                        class="form-control kt_selectpicker @error('patient_id') is-invalid @enderror"
                                        required data-live-search="true" title="{{ __('Choose') }} {{ __('Patient') }}">
                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}"
                                                {{ $receipt->patient_id == $patient->id ? 'selected' : '' }}
                                                data-nik="{{ $patient->nik }}"
                                                data-age="{{ \Carbon\Carbon::parse($patient->dob)->age }}"
                                                data-gender="{{ $patient->gender == 0 ? 'P' : 'L' }}"
                                                data-insurance-name="{{ $patient->insurance_name ? $patient->insurance_name : '-' }}"
                                                data-insurance-id="{{ $patient->insurance_no ? $patient->insurance_no : '-' }}"
                                                data-phone="{{ $patient->phone ? $patient->phone : '-' }}"
                                                data-email="{{ $patient->email ? $patient->email : '-' }}">
                                                {{ $patient->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('patient_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label>{{ __('NIK') }}</label>
                                    <input type="text" id="nik" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-1">
                                    <label>{{ __('Gender') }}</label>
                                    <input type="text" id="gender" class="form-control" readonly>
                                </div>
                                <div class="col-lg-1">
                                    <label>{{ __('Age') }}</label>
                                    <input type="text" id="age" class="form-control" readonly>
                                </div>
                                <div class="col-lg-2">
                                    <label>{{ __('Phone') }}</label>
                                    <input type="text" id="phone" class="form-control" readonly>
                                </div>
                                <div class="col-lg-2">
                                    <label>{{ __('Email') }}</label>
                                    <input type="email" id="email" class="form-control" readonly>
                                </div>

                                <div class="col-lg-3">
                                    <label>{{ __('Insurance Name') }}</label>
                                    <input type="text" id="insurance_name" class="form-control" readonly>
                                </div>
                                <div class="col-lg-3">
                                    <label>{{ __('Insurance No') }}</label>
                                    <input type="text" id="insurance_no" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Group 3: Service Information -->
                    <div class="card mb-4">
                        <div class="card-header">{{ __('Service Information') }}</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="service-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Service Name') }}</th>
                                            <th>{{ __('Unit') }}</th>
                                            <th>{{ __('Doctor') }}</th>
                                            <th>{{ __('Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="service-table-body">
                                        @foreach ($receipt->services as $index => $service)
                                            <tr class="service-row">
                                                <td>
                                                    <select name="services[{{ $index }}][service_id]"
                                                        class="form-control service-select">
                                                        @foreach ($services as $availableService)
                                                            <option value="{{ $availableService->id }}"
                                                                {{ $service->service_id == $availableService->id ? 'selected' : '' }}
                                                                data-price="{{ $availableService->price }}">
                                                                {{ $availableService->service_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="services[{{ $index }}][unit_id]"
                                                        class="form-control kt_selectpicker" data-live-search="true"
                                                        title="{{ __('Choose') }} {{ __('Unit') }}">
                                                        @foreach ($units as $unit)
                                                            <option value="{{ $unit->id }}"
                                                                {{ $service->unit_id == $unit->id ? 'selected' : '' }}>
                                                                {{ $unit->unit_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="services[{{ $index }}][doctor_id]"
                                                        class="form-control kt_selectpicker" data-live-search="true"
                                                        title="{{ __('Choose') }} {{ __('Doctor') }}">
                                                        @foreach ($doctors as $doctor)
                                                            <option value="{{ $doctor->id }}"
                                                                {{ $service->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                                {{ $doctor->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input name="services[{{ $index }}][price]" type="number"
                                                        class="form-control service-price" value="{{ $service->price }}"
                                                        readonly></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-dark ml-3"
                                    id="add-service-row">{{ __('Add Service') }}</button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Group 3: Medicine Information -->
                <div class="card mb-4">
                    <div class="card-header">{{ __('Medicine Information') }}</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="medicine-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Unit') }}</th>
                                        <th>{{ __('Unit Price') }}</th>
                                        <th>{{ __('Total Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="medicine-table-body">
                                    @foreach ($receipt->medicines as $index => $medicine)
                                        <tr class="medicine-row">
                                            <td>
                                                <select name="medicines[{{ $index }}][item_id]"
                                                    class="form-control medicine-select">
                                                    <option value="">{{ __('Select medicine option') }}</option>
                                                    @foreach ($medicines as $medicineOption)
                                                        <option value="{{ $medicineOption->id }}"
                                                            data-price="{{ $medicineOption->price }}"
                                                            data-unit="{{ $medicineOption->unit }}"
                                                            {{ $medicineOption->id == $medicine->item_id ? 'selected' : '' }}>
                                                            {{ $medicineOption->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" name="medicines[{{ $index }}][item_qty]"
                                                    class="form-control medicine-quantity" min="1"
                                                    value="{{ $medicine->item_qty }}">
                                            </td>
                                            <td><input type="text" name="medicines[{{ $index }}][item_unit]"
                                                    class="form-control medicine-unit" value="{{ $medicine->item_unit }}"
                                                    readonly></td>
                                            <td><input type="number" name="medicines[{{ $index }}][unit_price]"
                                                    class="form-control medicine-price"
                                                    value="{{ $medicine->unit_price }}" readonly></td>
                                            <td><input type="number" name="medicines[{{ $index }}][total_price]"
                                                    class="form-control medicine-total-price"
                                                    value="{{ $medicine->total_price }}" readonly></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-dark ml-3"
                                id="add-medicine-row">{{ __('Add Medicine') }}</button>
                        </div>
                    </div>
                </div>

                <!-- Group 4: Payment Information -->
                <div class="card mb-4">
                    <div class="card-header">{{ __('Payment Information') }}</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>{{ __('Payment Type') }}</label>
                                <select name="payment_type"
                                    class="form-control @error('payment_type') is-invalid @enderror" required>
                                    <option value="1" {{ $receipt->payment_type == 1 ? 'selected' : '' }}>
                                        {{ __('Cash') }}</option>
                                    <option value="2" {{ $receipt->payment_type == 2 ? 'selected' : '' }}>
                                        {{ __('Non Cash') }}</option>
                                    <option value="3" {{ $receipt->payment_type == 3 ? 'selected' : '' }}>
                                        {{ __('Petty Cash') }}</option>
                                    <option value="4" {{ $receipt->payment_type == 4 ? 'selected' : '' }}>
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
                                    <option value="1" {{ $receipt->payment_status == 1 ? 'selected' : '' }}>
                                        {{ __('Paid') }}</option>
                                    <option value="2" {{ $receipt->payment_status == 2 ? 'selected' : '' }}>
                                        {{ __('Unpaid') }}</option>
                                    <option value="3" {{ $receipt->payment_status == 3 ? 'selected' : '' }}>
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
                                            {{ $receipt->account_id == $account->id ? 'selected' : '' }}>
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
                        <div class="form-group row">
                            @if ($receipt->patient_id)
                                <div class="col-lg-4">
                                    <label>{{ __('Total Amount for Services') }}</label>
                                    <input type="number" id="services-total" class="form-control"
                                        value="{{ $receipt->service_total }}" readonly>
                                </div>
                            @endif
                            <div class="col-lg-4">
                                <label>{{ __('Total Amount for Medicines') }}</label>
                                <input type="number" id="medicines-total" class="form-control"
                                    value="{{ $receipt->medicine_total }}" readonly>
                            </div>
                            <div class="col-lg-4">
                                <label>{{ __('Total Amount for Receipt') }}</label>
                                <input type="number" id="grand-total" class="form-control"
                                    value="{{ $receipt->grand_total }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script src="{{ asset('js/form/validation.js') }}"></script>
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            noneResultsText: "{{ __('No matching results for') }} {0}"
        });
    </script>
    <script>
        $(document).ready(function() {
            // When the patient select changes
            $('select[name="patient_id"]').on('change', function() {
                // Get the selected patient option
                var selectedPatient = $(this).find(':selected');

                // Set the values of other fields
                $('#nik').val(selectedPatient.data('nik') || 'N/A');
                $('#gender').val(selectedPatient.data('gender') || 'N/A');
                $('#age').val(selectedPatient.data('age') || 'N/A');
                $('#phone').val(selectedPatient.data('phone') || 'N/A');
                $('#email').val(selectedPatient.data('email') || 'N/A');
                $('#insurance_name').val(selectedPatient.data('insurance-name') || 'N/A');
                $('#insurance_no').val(selectedPatient.data('insurance-id') || 'N/A');
            });

            // Trigger the change event on page load to populate the fields with the default selected patient
            $('select[name="patient_id"]').trigger('change');
        });
    </script>
    <script>
        $(document).ready(function() {
            let serviceIndex = {{ count($receipt->services) }}; // Start from the existing services count

            // Function to update service prices based on selected service
            function updateServicePrices() {
                let grandTotal = 0; // Initialize grand total for services

                $('#service-table-body .service-row').each(function() {
                    var serviceSelect = $(this).find('.service-select');
                    var servicePrice = serviceSelect.find('option:selected').data('price');
                    $(this).find('.service-price').val(servicePrice);

                    // Accumulate the total price
                    grandTotal += parseFloat(servicePrice) || 0; // Ensure proper numeric addition
                });

                // Update the services total input field
                $('#services-total').val(grandTotal.toFixed(2)); // Display services total

                // Update the overall grand total
                updateGrandTotal();
            }

            // Function to update the overall grand total
            function updateGrandTotal() {
                let serviceTotal = parseFloat($('#services-total').val()) || 0;
                let medicineTotal = parseFloat($('#medicines-total').val()) || 0;
                let grandTotal = serviceTotal + medicineTotal;

                $('#grand-total').val(grandTotal.toFixed(2)); // Display grand total
            }

            // Call updateServicePrices when service changes
            $(document).on('change', '.service-select', updateServicePrices);

            // Add new service row
            $('#add-service-row').click(function() {
                var newRow = `
                    <tr class="service-row">
                        <td>
                            <select name="services[${serviceIndex}][service_id]" class="form-control service-select">
                                <option value="">{{ __('Select service option') }}</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                        {{ $service->service_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="services[${serviceIndex}][unit_id]" class="form-control kt_selectpicker" data-live-search="true"
                                    title="{{ __('Choose') }} {{ __('Unit') }}">
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="services[${serviceIndex}][doctor_id]" class="form-control kt_selectpicker" data-live-search="true"
                                    title="{{ __('Choose') }} {{ __('Doctor') }}">
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input name="services[${serviceIndex}][price]" type="number" class="form-control service-price" readonly></td>
                    </tr>
                `;

                $('#service-table-body').append(newRow);
                serviceIndex++; // Increment the row index
                $('.kt_selectpicker').selectpicker('refresh'); // Refresh the select picker for the new row
                updateServicePrices(); // Update grand total after adding a new row
            });

            // Initialize existing services
            @foreach ($receipt->services as $index => $service)
                $('#service-table-body').append(`
                    <tr class="service-row">
                        <td>
                            <select name="services[${index}][service_id]" class="form-control service-select">
                                <option value="">{{ __('Select service option') }}</option>
                                @foreach ($services as $availableService)
                                    <option value="{{ $availableService->id }}"
                                        {{ $service->service_id == $availableService->id ? 'selected' : '' }}
                                        data-price="{{ $availableService->price }}">
                                        {{ $availableService->service_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="services[${index}][unit_id]" class="form-control kt_selectpicker" data-live-search="true"
                                    title="{{ __('Choose') }} {{ __('Unit') }}">
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ $service->unit_id == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->unit_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="services[${index}][doctor_id]" class="form-control kt_selectpicker" data-live-search="true"
                                    title="{{ __('Choose') }} {{ __('Doctor') }}">
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}"
                                        {{ $service->doctor_id == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input name="services[${index}][price]" type="number" class="form-control service-price" value="{{ $service->price }}" readonly></td>
                    </tr>
                `);
            @endforeach

            // Call updateServicePrices to initialize totals
            updateServicePrices(); // Initial calculation
        });
    </script>

    <script>
        $(document).ready(function() {
            var rowIndex = {{ count($receipt->medicines) }}; // Start from the existing medicines count

            // Function to update unit price, unit, and total price for each row
            function updateMedicineRow(row) {
                var selectedOption = row.find('.medicine-select option:selected');
                var price = selectedOption.data('price');
                var unit = selectedOption.data('unit');
                var quantity = row.find('.medicine-quantity').val();

                // Set the unit and price fields
                row.find('.medicine-unit').val(unit);
                row.find('.medicine-price').val(price);

                // Calculate total price (unit price * quantity)
                var totalPrice = price * quantity;
                row.find('.medicine-total-price').val(totalPrice.toFixed(2));

                // Update medicines total
                calculateMedicineTotal();
            }

            // Function to calculate the medicines total and update grand total
            function calculateMedicineTotal() {
                var medicineTotal = 0;
                $('.medicine-total-price').each(function() {
                    medicineTotal += parseFloat($(this).val()) || 0;
                });
                $('#medicines-total').val(medicineTotal.toFixed(2));

                // Update grand total
                updateGrandTotal();
            }

            // Function to update the overall grand total
            function updateGrandTotal() {
                let serviceTotal = parseFloat($('#services-total').val()) || 0;
                let medicineTotal = parseFloat($('#medicines-total').val()) || 0;
                let grandTotal = serviceTotal + medicineTotal;

                $('#grand-total').val(grandTotal.toFixed(2)); // Display grand total
            }

            // Update medicine info when a medicine is selected
            $(document).on('change', '.medicine-select', function() {
                var row = $(this).closest('.medicine-row');
                updateMedicineRow(row);
            });

            // Update total price when the quantity changes
            $(document).on('input', '.medicine-quantity', function() {
                var row = $(this).closest('.medicine-row');
                updateMedicineRow(row);
            });

            // Add a new medicine row
            $('#add-medicine-row').click(function() {
                var newRow = `
                <tr class="medicine-row">
                    <td>
                        <select name="medicines[${rowIndex}][item_id]" class="form-control medicine-select">
                            <option value="">{{ __('Select medicine option') }}</option>
                            @foreach ($medicines as $medicine)
                                <option value="{{ $medicine->id }}" data-price="{{ $medicine->price }}" data-unit="{{ $medicine->unit }}">{{ $medicine->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="medicines[${rowIndex}][item_qty]" class="form-control medicine-quantity" min="1" value="1"></td>
                    <td><input type="text" name="medicines[${rowIndex}][item_unit]" class="form-control medicine-unit" readonly></td>
                    <td><input type="number" name="medicines[${rowIndex}][unit_price]" class="form-control medicine-price" readonly></td>
                    <td><input type="number" name="medicines[${rowIndex}][total_price]" class="form-control medicine-total-price" readonly></td>
                </tr>
            `;
                $('#medicine-table-body').append(newRow);
                rowIndex++; // Increment the row index for unique name attributes
            });

            // Initialize existing medicines and calculate totals
            $('.medicine-row').each(function() {
                updateMedicineRow($(this)); // Calculate for each existing medicine row
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
            calculateMedicineTotal(); // Initial calculation for medicines
        });
    </script>
@endsection
