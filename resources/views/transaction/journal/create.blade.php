@extends('layouts.app')

@section('title', __('Journal Entries') . ' | ' . config('app.name'))

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
    <style>
        .btn-full-width {
            width: 100%;
        }

        .file-upload-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
            /* Space between items */
            margin-top: 10px;
        }

        .file-upload-item {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
        }

        .remove-file {
            color: red;
            cursor: pointer;
            font-size: 14px;
        }

        /* Fix for Bootstrap select to keep the search input on top */
        .bootstrap-select .dropdown-menu.inner {
            max-height: 200px;
            /* Set a fixed height for the dropdown */
            overflow-y: auto;
            /* Enable vertical scrolling for the options */
        }

        .bootstrap-select .bs-searchbox {
            position: sticky;
            top: 0;
            z-index: 1;
            background: white;
        }
    </style>
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('journal.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Journal Voucher') }}</a>
@endsection

@section('content')
    <form class="kt-form" method="POST" action="{{ route('journal.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="kt-portlet" id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{ __('Journal Entry') }}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{ route('journal.index') }}" class="btn btn-secondary kt-margin-r-10">
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
                @include('layouts.inc.alert')

                <div class="card mb-4">
                    <div class="card-header">{{ __('Create Journal Information') }}</div>
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="form-group col-md-3">
                                <label for="voucher_code">{{ __('Journal No.') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">JV</span>
                                    <input id="voucher_code" name="voucher_code" type="text"
                                        class="form-control @error('voucher_code') is-invalid @enderror"
                                        value="{{ old('voucher_code') }}" autocomplete="off">
                                </div>
                                @error('voucher_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> --}}
                            <div class="form-group col-md-3">
                                <label for="journal_date">{{ __('Journal Date') }}</label>
                                <input id="journal_date" name="journal_date" type="text"
                                    placeholder="{{ __('Select') }} {{ __('Date') }}"
                                    class="form-control @error('journal_date') is-invalid @enderror"
                                    value="{{ old('journal_date') }}" autocomplete="off" readonly>

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
                                        <th>{{ __('Debit') }}</th>
                                        <th>{{ __('Credit') }}</th>
                                        <th>{{ __('Remarks') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="journal-table-body">
                                    <!-- Existing journal row structure remains the same -->
                                    <tr class="journal-row">
                                        <td>
                                            <select name="entries[0][account_id]" class="form-control kt_selectpicker"
                                                required data-live-search="true"
                                                title="{{ __('Choose') }} {{ __('Account') }}">
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}"
                                                        {{ old('entries.0.account_id') == $account->id ? 'selected' : '' }}>
                                                        {{ $account->account_code . ' - ' . $account->sub_account_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="entries[0][debit]" class="form-control debit"
                                                step="0.01" value="{{ old('entries.0.debit') }}"
                                                oninput="validateDebitCredit(this)">
                                        </td>
                                        <td>
                                            <input type="number" name="entries[0][credit]" class="form-control credit"
                                                step="0.01" value="{{ old('entries.0.credit') }}"
                                                oninput="validateDebitCredit(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="entries[0][note]" class="form-control"
                                                value="{{ old('entries.0.note') }}">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger remove-journal-row"><i
                                                    class="la la-trash"></i></button>
                                            <input type="hidden" name="entries[0][is_remove]" value="0"
                                                class="remove-entry">
                                        </td>
                                    </tr>
                                    <tr class="journal-row">
                                        <td>
                                            <select name="entries[1][account_id]" class="form-control kt_selectpicker"
                                                required data-live-search="true"
                                                title="{{ __('Choose') }} {{ __('Account') }}">
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}"
                                                        {{ old('entries.1.account_id') == $account->id ? 'selected' : '' }}>
                                                        {{ $account->account_code . ' - ' . $account->sub_account_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="entries[1][debit]" class="form-control debit"
                                                step="0.01" value="{{ old('entries.1.debit') }}"
                                                oninput="validateDebitCredit(this)">
                                        </td>
                                        <td>
                                            <input type="number" name="entries[1][credit]" class="form-control credit"
                                                step="0.01" value="{{ old('entries.1.credit') }}"
                                                oninput="validateDebitCredit(this)">
                                        </td>
                                        <td>
                                            <input type="text" name="entries[1][note]" class="form-control"
                                                value="{{ old('entries.1.note') }}">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger remove-journal-row"><i
                                                    class="la la-trash"></i></button>
                                            <input type="hidden" name="entries[1][is_remove]" value="0"
                                                class="remove-entry">
                                        </td>
                                    </tr>
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
                                        <th id="total-debit">0.00</th>
                                        <th id="total-credit">0.00</th>
                                        <th id="balance-info">0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- File Upload Section -->
                {{-- <div class="card mb-4">
                    <div class="card-header">{{ __('Upload Attachments') }} (Max: 12 files, 1MB each)</div>
                    <div class="card-body">
                        <div>
                            <input type="file" id="attachments" name="attachments[]" multiple
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt" onchange="validateFiles()">
                            <div id="file-upload-grid" class="file-upload-grid"></div>
                        </div>
                    </div>
                </div> --}}
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
                    Are you sure you want to remove this journal entry?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmRemove">Remove</button>
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

        let journalIndex = 2;

        // Array to hold uploaded files
        let uploadedFiles = [];

        // Function to validate and display uploaded files
        function validateFiles() {
            const fileUploadInput = document.getElementById('attachments');
            const files = fileUploadInput.files;
            const validExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'txt'];
            const maxSize = 1 * 1024 * 1024; // 1 MB
            const maxFiles = 12; // Max files
            const fileUploadGrid = document.getElementById('file-upload-grid');

            // Clear previous uploads in the grid
            fileUploadGrid.innerHTML = '';

            // Show all previously uploaded files
            uploadedFiles.forEach(file => {
                displayFile(file);
            });

            // Check the number of selected files
            if (uploadedFiles.length + files.length > maxFiles) {
                alert(`You can upload a maximum of ${maxFiles} files.`);
                return;
            }

            // Validate each selected file
            for (const file of files) {
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (!validExtensions.includes(fileExtension)) {
                    alert(`Invalid file type: ${file.name}`);
                    continue; // Skip invalid files
                }

                if (file.size > maxSize) {
                    alert(`File size exceeds 1MB: ${file.name}`);
                    continue; // Skip files that exceed the max size
                }

                // Add valid file to the uploaded files array
                uploadedFiles.push(file);
                displayFile(file); // Display the valid file
            }

            // Clear the input for new selection
            fileUploadInput.value = '';
        }

        // Function to display a file in the grid
        function displayFile(file) {
            const fileUploadGrid = document.getElementById('file-upload-grid');
            const fileItem = document.createElement('div');
            fileItem.className = 'file-upload-item';
            fileItem.innerHTML = `
                <span>${file.name}</span>
                <div class="remove-file" onclick="removeFile('${file.name}')">Remove</div>
            `;
            fileUploadGrid.appendChild(fileItem);
        }

        // Function to remove a file from the grid and the uploaded files array
        function removeFile(fileName) {
            uploadedFiles = uploadedFiles.filter(file => file.name !== fileName); // Remove file from the array
            validateFiles(); // Re-validate to update the grid view
        }

        function validateDebitCredit(input) {
            const row = input.closest('.journal-row'); // Get the current row
            const debitInput = row.querySelector('.debit');
            const creditInput = row.querySelector('.credit');

            if (input === debitInput) {
                // If Debit is filled, clear Credit
                if (debitInput.value) {
                    creditInput.value = ''; // Clear Credit
                }
            } else if (input === creditInput) {
                // If Credit is filled, clear Debit
                if (creditInput.value) {
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

            let balance = totalDebit - totalCredit; // Calculate balance
            $('#total-debit').text(totalDebit.toFixed(2)); // Display total debit
            $('#total-credit').text(totalCredit.toFixed(2)); // Display total credit
            $('#balance-info').text(balance.toFixed(2)); // Display balance
        }

        // Add event listener for the add journal row button
        document.getElementById('add-journal-row').addEventListener('click', function() {
            // Fetch the old entries passed from the controller
            let oldEntries = @json(old('entries', [])); // Ensure this is present in your view

            // Get the old entry for the current index if it exists
            const oldEntry = oldEntries[journalIndex] || {}; // Retrieve old entry if it exists

            const newRow = `
                <tr class="journal-row">
                    <td>
                        <select name="entries[${journalIndex}][account_id]" class="form-control kt_selectpicker" required data-live-search="true" title="{{ __('Choose') }} {{ __('Account') }}">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" ${oldEntry.account_id == {{ $account->id }} ? 'selected' : ''}>
                                    {{ $account->account_code . ' - ' . $account->sub_account_name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="entries[${journalIndex}][debit]" class="form-control debit" step="0.01" value="${oldEntry.debit || ''}" oninput="validateDebitCredit(this)">
                    </td>
                    <td>
                        <input type="number" name="entries[${journalIndex}][credit]" class="form-control credit" step="0.01" value="${oldEntry.credit || ''}" oninput="validateDebitCredit(this)">
                    </td>
                    <td>
                        <input type="text" name="entries[${journalIndex}][note]" class="form-control" value="${oldEntry.note || ''}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger remove-journal-row"><i class="la la-trash"></i></button>
                        <input type="hidden" name="entries[${journalIndex}][is_remove]" value="0" class="remove-entry">
                    </td>
                </tr>
            `;

            // Append the new row
            $('#journal-table-body').append(newRow);

            // Increment the index for future rows
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
    <script src="{{ asset(mix('js/form/validation.js')) }}"></script>
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            liveSearch: true,
            liveSearchPlaceholder: "{{ __('Search Account') }}", // Add a placeholder if desired
            noneResultsText: "{{ __('No matching results') }} {0}", // Customize text when no match is found
            showContent: true, // Ensure the dropdown stays visible
            showTick: true // Add checkmark to selected items
        });
    </script>
@endsection
