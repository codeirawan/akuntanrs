@extends('layouts.app')

@section('title', __('Edit Cash & Bank') . ' | ' . config('app.name'))

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/journal.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('journal.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Cash & Bank') }}</a>
@endsection

@section('content')
    <form class="kt-form" method="POST" action="{{ route('cash.update', $journal->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ __('Edit ') . ($journal->voucher_code && Str::startsWith($journal->voucher_code, 'RV') ? __('Receipt') : __('Payment')) }}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('cash.index') }}" class="btn btn-secondary kt-margin-r-10">
                        <i class="la la-arrow-left"></i>
                        <span class="kt-hidden-mobile">{{ __('Back') }}</span>
                    </a>
                    @if (Laratrust::isAbleTo('delete-transaction'))
                        <button type="submit" name="action" value="delete_all" class="btn btn-danger kt-margin-r-10"
                            id="delete-all-journals">
                            <i class="la la-trash"></i> {{ __('Delete All') }}
                        </button>
                    @endif
                    @if (Laratrust::isAbleTo('update-transaction'))
                        <button type="submit" name="action" value="update" class="btn btn-primary">
                            <i class="la la-check"></i> {{ __('Update') }}
                        </button>
                    @endif
                </div>
            </div>
            <div class="kt-portlet__body">
                @include('layouts.inc.alert')

                <div class="card mb-4">
                    <div class="card-header">
                        {{ __('Edit Detail ' . ($journal->voucher_code && Str::startsWith($journal->voucher_code, 'RV') ? 'Receipt' : 'Payment')) }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="voucher_code">{{ __('Journal No.') }}</label>
                                <input id="voucher_code" name="voucher_code" type="text""
                                    class="form-control @error('voucher_code') is-invalid @enderror"
                                    value="{{ old('voucher_code', $journal->voucher_code) }}" autocomplete="off" readonly>

                                @error('voucher_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="journal_date">
                                    {{ $journal->voucher_code && Str::startsWith($journal->voucher_code, 'RV') ? __('Receipt') : __('Payment') }}
                                    {{ __(' Date') }}
                                </label>
                                <input id="journal_date" name="journal_date" type="text"
                                    placeholder="{{ __('Select') }} {{ __('Date') }}"
                                    class="form-control @error('journal_date') is-invalid @enderror"
                                    value="{{ old('journal_date', $journal->journal_date) }}" autocomplete="off" readonly>

                                @error('journal_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="journal-table">
                                <thead class="bg-secondary text-center">
                                    <tr>
                                        <th>{{ __('Account') }}</th>
                                        @if (!empty($journals) && !Str::startsWith($journals[0]->voucher_code, 'PV'))
                                            <th>{{ __('Amount') }}</th>
                                        @endif
                                        @if (!empty($journals) && !Str::startsWith($journals[0]->voucher_code, 'RV'))
                                            <th>{{ __('Amount') }}</th>
                                        @endif
                                        <th>{{ __('Remarks') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="journal-table-body">
                                    @foreach ($journals as $index => $entry)
                                        <tr class="journal-row">
                                            <td>
                                                <!-- Hidden input for the Cash & Bank ID -->
                                                <input type="hidden" name="entries[{{ $index }}][id]"
                                                    value="{{ $entry->id }}">
                                                <input type="hidden" name="entries[{{ $index }}][is_remove]"
                                                    value="0" class="remove-entry">

                                                <select name="entries[{{ $index }}][account_id]"
                                                    class="form-control kt_selectpicker" required data-live-search="true"
                                                    title="{{ __('Choose') }} {{ __('Account') }}">
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}"
                                                            {{ $account->id == $entry->account_id ? 'selected' : '' }}>
                                                            {{ $account->account_code . ' - ' . $account->sub_account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            @if (!Str::startsWith($entry->voucher_code, 'PV'))
                                                <td>
                                                    <input type="number" name="entries[{{ $index }}][debit]"
                                                        class="form-control debit" step="0.01"
                                                        value="{{ old('entries.' . $index . '.debit', $entry->debit) }}"
                                                        oninput="validateDebitCredit(this)">
                                                </td>
                                            @endif
                                            @if (!Str::startsWith($entry->voucher_code, 'RV'))
                                                <td>
                                                    <input type="number" name="entries[{{ $index }}][credit]"
                                                        class="form-control credit" step="0.01"
                                                        value="{{ old('entries.' . $index . '.credit', $entry->credit) }}"
                                                        oninput="validateDebitCredit(this)">
                                                </td>
                                            @endif
                                            <td>
                                                <input type="text" name="entries[{{ $index }}][note]"
                                                    class="form-control"
                                                    value="{{ old('entries.' . $index . '.note', $entry->note) }}">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger remove-journal-row">
                                                    <i class="la la-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tr class="journal-row">
                                    <td colspan="4">
                                        <button type="button" class="btn btn-primary btn-full-width"
                                            id="add-journal-row">+</button>
                                    </td>
                                </tr>
                                <tfoot>
                                    <tr>
                                        <th colspan="1">{{ __('Total') }}</th>
                                        <th id="total-amount"></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this Cash & Bank?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmRemove">Remove</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteAllJournalsModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteAllJournalsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAllJournalsModalLabel">{{ __('Confirm Deletion') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete all journal entries? This action cannot be undone.') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <!-- Button that triggers the form submission -->
                    <button type="button" class="btn btn-danger"
                        id="confirm-delete-all">{{ __('Delete All') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script type="text/javascript">
        // Disable the save button initially
        toggleSaveButton();

        let journalIndex = {{ count($journals) }};

        // Function to validate Debit and Credit fields
        function validateDebitCredit(input) {
            const row = input.closest('.journal-row'); // Get the current row
            const debitInput = row.querySelector('.debit');
            const creditInput = row.querySelector('.credit');

            // If Debit input exists and is filled, clear Credit input if it exists
            if (input === debitInput && debitInput && debitInput.value) {
                if (creditInput) { // Check if the credit input exists before clearing it
                    creditInput.value = ''; // Clear Credit
                }
            }
            // If Credit input exists and is filled, clear Debit input if it exists
            else if (input === creditInput && creditInput && creditInput.value) {
                if (debitInput) { // Check if the debit input exists before clearing it
                    debitInput.value = ''; // Clear Debit
                }
            }

            // Recalculate the balance after input changes
            calculateBalance();
            toggleSaveButton();
        }

        // Function to calculate the balance and totals
        function calculateBalance() {
            let totalDebit = 0;
            let totalCredit = 0;

            $('.journal-row').each(function() {
                // Check if the row is marked for removal
                if ($(this).find('.remove-entry').val() !== '1') {
                    // Only calculate if the row is not marked for deletion
                    totalDebit += parseFloat($(this).find('.debit').val()) || 0; // Sum debit values
                    totalCredit += parseFloat($(this).find('.credit').val()) || 0; // Sum credit values
                }
            });

            let totalAmount = totalDebit + totalCredit; // Calculate balance
            $('#total-amount').text(totalAmount.toFixed(2)); // Display balance
        }

        // Add event listener for add journal row button
        document.getElementById('add-journal-row').addEventListener('click', function() {
            const voucherCode =
            '{{ $journal->voucher_code }}'; // Get the voucher code dynamically from the server-side
            let debitField = '';
            let creditField = '';

            // Conditionally render debit and credit fields based on voucher code
            if (!voucherCode.startsWith('PV')) {
                debitField = `
            <td>
                <input type="number" name="entries[${journalIndex}][debit]" class="form-control debit" step="0.01" oninput="validateDebitCredit(this)">
            </td>`;
            }

            if (!voucherCode.startsWith('RV')) {
                creditField = `
            <td>
                <input type="number" name="entries[${journalIndex}][credit]" class="form-control credit" step="0.01" oninput="validateDebitCredit(this)">
            </td>`;
            }

            // Generate new row with the appropriate fields
            const newRow = `
                <tr class="journal-row">
                    <td>
                        <select name="entries[${journalIndex}][account_id]" class="form-control kt_selectpicker" required data-live-search="true" title="{{ __('Choose') }} {{ __('Account') }}">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">
                                    {{ $account->account_code . ' - ' . $account->sub_account_name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    ${debitField}
                    ${creditField}
                    <td>
                        <input type="text" name="entries[${journalIndex}][note]" class="form-control">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger remove-journal-row"><i class="la la-trash"></i></button>
                    </td>
                    <input type="hidden" name="entries[${journalIndex}][is_remove]" value="0" class="remove-entry">
                </tr>
            `;

            // Append the new row
            $('#journal-table-body').append(newRow);
            journalIndex++;

            // Reinitialize selectpicker for the new select element and customize live search
            $('.kt_selectpicker').selectpicker({
                liveSearch: true,
                liveSearchPlaceholder: "{{ __('Search Account') }}", // Add a placeholder if desired
                noneResultsText: "{{ __('No matching results') }} {0}", // Customize text when no match is found
                showContent: true, // Ensure the dropdown stays visible
                showTick: true // Add checkmark to selected items
            }).selectpicker('refresh');
        });


        let rowToRemove; // Variable to hold the row to be removed

        // Event delegation to handle the removal of journal rows
        $('#journal-table-body').on('click', '.remove-journal-row', function() {
            rowToRemove = $(this).closest('tr'); // Store the row to be removed
            $('#confirmationModal').modal('show'); // Show the confirmation modal
        });

        // Handle the confirmation button click
        $('#confirmRemove').on('click', function() {
            const $row = rowToRemove; // Get the stored row
            $row.find('.remove-entry').val('1'); // Mark the entry as removed
            $row.hide(); // Hide the row

            // Calculate balance and toggle save button
            calculateBalance();
            toggleSaveButton();

            $('#confirmationModal').modal('hide'); // Hide the modal after confirmation
        });

        // Function to toggle the save button based on validation
        function toggleSaveButton() {
            // Recalculate total debit and credit
            let totalDebit = 0;
            let totalCredit = 0;

            $('.journal-row').filter(function() {
                return $(this).find('.remove-entry').val() != 1; // Exclude removed entries
            }).each(function() {
                totalDebit += parseFloat($(this).find('.debit').val()) || 0; // Default to 0 if NaN
                totalCredit += parseFloat($(this).find('.credit').val()) || 0; // Default to 0 if NaN
            });

            // Update the displayed totals
            $('#total-debit').text(totalDebit.toFixed(2)); // Display with 2 decimal places
            $('#total-credit').text(totalCredit.toFixed(2)); // Display with 2 decimal places

            // Check if there are valid debit/credit values
            let hasDebitOrCredit = totalDebit > 0 || totalCredit > 0;

            // Check if the journal date is empty
            let journalDate = $('#journal_date').val().trim();

            // Enable button if there are debit/credit values, balance is zero, and journal date is not empty
            if (hasDebitOrCredit && totalDebit === totalCredit && journalDate !== '') {
                $('button[type="submit"]').prop('disabled', false);
            } else {
                $('button[type="submit"]').prop('disabled', true);
            }
        }

        // Event listener to toggle save button on input change
        $('.debit, .credit, #journal_date').on('input change', toggleSaveButton);

        // Initialize the balance on page load
        $(document).ready(function() {
            calculateBalance();
            toggleSaveButton();
        });
    </script>
    <script>
        $('#journal_date').datepicker({
            autoclose: true,
            clearBtn: true,
            disableTouchKeyboard: true,
            format: "dd-mm-yyyy",
            language: "{{ config('app.locale') }}",
            startDate: "0d",
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            },
            todayBtn: "linked",
            todayHighlight: true
        });
    </script>
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            liveSearch: true,
            liveSearchPlaceholder: "{{ __('Search Account') }}", // Add a placeholder if desired
            noneResultsText: "{{ __('No matching results') }} {0}", // Customize text when no match is found
            showContent: true, // Ensure the dropdown stays visible
            showTick: true // Add checkmark to selected items
        });
    </script>
    <script>
        // Confirm before deleting all journals
        document.getElementById('delete-all-journals').addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete all journal entries? This action cannot be undone.')) {
                e.preventDefault(); // Stop form submission if the user cancels
            }
        });
    </script>
@endsection
