@extends('layouts.app')

@section('title', __('Edit Cash & Bank') . ' | ' . config('app.name'))

@section('style')
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
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
                                <tbody id="cash-table-body">
                                    @foreach ($journals as $index => $entry)
                                        <tr class="journal-row">
                                            <td>
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
                                                    <input type="text" name="entries[{{ $index }}][debit]"
                                                        class="form-control debit" step="0.01"
                                                        value="{{ old('entries.' . $index . '.debit', $entry->debit) }}">
                                                </td>
                                            @endif
                                            @if (!Str::startsWith($entry->voucher_code, 'RV'))
                                                <td>
                                                    <input type="text" name="entries[{{ $index }}][credit]"
                                                        class="form-control credit" step="0.01"
                                                        value="{{ old('entries.' . $index . '.credit', $entry->credit) }}">
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
                                            id="add-cash-row">+</button>
                                    </td>
                                </tr>
                                <tfoot class="text-right">
                                    <tr>
                                        <th colspan="1">{{ __('Total') }}</th>
                                        <th id="total-journal-amount"></th>
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
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script type="text/javascript">
        // Initialize the balance on page load
        $(document).ready(function() {
            calculateAmount();
            toggleSaveButton();
            formatAmountsOnLoad(); // Call to format amounts on load
        });

        let journalIndex = {{ count($journals) }};

        // Function to format numbers to the desired format: 7.999.783,78
        function formatAmount(amount) {
            // Parse the amount to a number (if it's a string) to ensure correct formatting
            const parsedAmount = parseFloat(amount);

            // Format the amount using toLocaleString
            return parsedAmount.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Function to format amounts for all existing rows on page load
        function formatAmountsOnLoad() {
            $('.journal-row').each(function() {
                const debitInput = $(this).find('.debit');
                const creditInput = $(this).find('.credit');

                // Format the existing values
                const formattedDebit = formatAmount(debitInput.val());
                const formattedCredit = formatAmount(creditInput.val());

                // Set the formatted values back into the inputs
                debitInput.val(formattedDebit);
                creditInput.val(formattedCredit);
            });
        }

        function calculateAmount() {
            let totalDebit = 0;
            let totalCredit = 0;

            $('.journal-row').each(function() {
                // Check if the row is marked for removal
                if ($(this).find('.remove-entry').val() !== '1') {
                    // Ensure debit and credit have default values
                    const debitValue = $(this).find('.debit').val() || '0';
                    const creditValue = $(this).find('.credit').val() || '0';

                    // Parse float after removing any commas (thousands separators)
                    let debitAmount = parseFloat(debitValue.replace(/,/g, '')) || 0;
                    let creditAmount = parseFloat(creditValue.replace(/,/g, '')) || 0;

                    totalDebit += debitAmount; // Sum debit values
                    totalCredit += creditAmount; // Sum credit values
                }
            });

            // Calculate the balance as difference between debit and credit
            let totalAmount = totalDebit + totalCredit; // Change to subtraction for balance

            // Format the total amount before displaying
            $('#total-journal-amount').text(formatAmount(totalAmount.toFixed(2))); // Display balance
        }

        // Add event listener for add journal row button
        document.getElementById('add-cash-row').addEventListener('click', function() {
            const voucherCode = '{{ $journal->voucher_code }}';
            let debitField = '';
            let creditField = '';

            // Conditionally render debit and credit fields based on voucher code
            if (!voucherCode.startsWith('PV')) {
                debitField = `
                <td>
                    <input type="text" name="entries[${journalIndex}][debit]" class="form-control debit" step="0.01">
                </td>`;
            }

            if (!voucherCode.startsWith('RV')) {
                creditField = `
                <td>
                    <input type="text" name="entries[${journalIndex}][credit]" class="form-control credit" step="0.01">
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
            $('#cash-table-body').append(newRow);
            journalIndex++;

            // Reinitialize selectpicker for the newly added select element
            $('.kt_selectpicker:last').selectpicker({
                liveSearch: true,
                liveSearchPlaceholder: "{{ __('Search Account') }}", // Placeholder for search
                noneResultsText: "{{ __('No matching results') }} {0}", // Text for no match
                showContent: true, // Dropdown visibility
                showTick: true // Show checkmark for selected
            }).selectpicker('refresh');
        });

        function toggleSaveButton() {
            let totalDebit = 0;
            let totalCredit = 0;

            // Loop through each journal-row that is not marked for removal
            $('.journal-row').filter(function() {
                return $(this).find('.remove-entry').val() != 1; // Exclude removed entries
            }).each(function() {
                const debitInput = $(this).find('.debit').val() || ''; // Ensure debit is not undefined
                const creditInput = $(this).find('.credit').val() || ''; // Ensure credit is not undefined

                // Only try to replace if the value is a valid non-empty string
                if (debitInput) {
                    totalDebit += parseFloat(debitInput.replace(/\./g, '').replace(',', '.')) ||
                        0; // Safely parse debit values
                }

                if (creditInput) {
                    totalCredit += parseFloat(creditInput.replace(/\./g, '').replace(',', '.')) ||
                        0; // Safely parse credit values
                }
            });

            // Update the displayed totals
            $('#total-debit').text(totalDebit.toFixed(2)); // Display with 2 decimal places
            $('#total-credit').text(totalCredit.toFixed(2)); // Display with 2 decimal places

            // Check if there are valid debit/credit values
            let hasDebitOrCredit = totalDebit > 0 || totalCredit > 0;

            // Check if the journal date is empty
            let journalDate = $('#journal_date').val().trim();

            // Enable button if there are debit/credit values, balance is zero, and journal date is not empty
            if (hasDebitOrCredit && journalDate !== '') {
                $('button[type="submit"]').prop('disabled', false);
            } else {
                $('button[type="submit"]').prop('disabled', true);
            }
        }

        // Event delegation for debit and credit fields on blur
        $('#cash-table-body').on('blur', '.debit, .credit', function() {
            const formattedValue = formatAmount($(this).val());
            $(this).val(formattedValue); // Set the formatted value back into the input
            toggleSaveButton(); // Recalculate and validate after formatting
            calculateAmount();
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
