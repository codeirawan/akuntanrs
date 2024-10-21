<script>
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
        uploadedFilesReceipt.forEach(displayFile); // Show all previously uploaded files

        // Check the number of selected files
        if (uploadedFilesReceipt.length + files.length > maxFiles) {
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

            uploadedFilesReceipt.push(file); // Add valid file to the uploaded files array
            displayFile(file); // Display the valid file
        }

        fileUploadInput.value = ''; // Clear the input for new selection
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
        uploadedFilesReceipt = uploadedFilesReceipt.filter(file => file.name !== fileName); // Remove file from the array
        validateFiles(); // Re-validate to update the grid view
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.kt_selectpicker').selectpicker({
            liveSearch: true,
            liveSearchPlaceholder: "{{ __('Search Account') }}",
            noneResultsText: "{{ __('No matching results') }} {0}",
            showContent: true,
            showTick: true
        });
        toggleSaveButtonReceipt();
        calculateAmountReceipt();
        toggleAddButtonReceipt();
    });

    let receiptIndex = 1;
    const maxRowsReceipt = 5; // Maximum allowed rows
    let uploadedFilesReceipt = []; // Array to hold uploaded files
    let rowToRemoveReceipt; // Variable to hold the row to be removed

    // Function to toggle the visibility of the Add button
    function toggleAddButtonReceipt() {
        if (receiptIndex >= maxRowsReceipt) {
            $('#add-receipt-row').hide(); // Hide the button if max rows reached
        } else {
            $('#add-receipt-row').show(); // Show the button if less than max rows
        }
    }

    // Function to calculate totals amounts
    function calculateAmountReceipt() {
        let totalAmount = 0;
        const maxAmount = 999999999; // Set a maximum value for input

        $('.receipt-row').each(function() {
            // Ensure that the receipt row is not marked for removal
            if ($(this).find('.remove-entry-receipt').val() !== '1') {
                // Find the receipt amount input
                const receiptInput = $(this).find('.receipt-amount');
                const amountString = receiptInput.val(); // Get the input value

                // Check if amountString is defined
                if (amountString) {
                    // Clean the input value
                    const cleanedAmountString = amountString.replace(/\./g, '').replace(',',
                        '.'); // Remove formatting
                    let amount = parseFloat(cleanedAmountString) || 0; // Parse as float

                    // Check if the input amount exceeds the max allowed amount
                    if (amount > maxAmount) {
                        amount = maxAmount; // Cap the amount to the max value
                    }

                    totalAmount += amount; // Accumulate the total
                }
            }
        });

        // Format the total amount to the Indonesian locale format
        $('#total-receipt-amount').text(totalAmount.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
    }

    // Function to toggle the save button based on validation
    function toggleSaveButtonReceipt() {
        let totalAmount = 0;

        $('.receipt-row').filter(function() {
            return $(this).find('.remove-entry-receipt').val() != '1'; // Exclude removed receipts
        }).each(function() {
            const receiptInput = $(this).find('.receipt-amount');
            const amountString = receiptInput.val(); // Get the input value

            // Clean and parse the receipt amount
            if (amountString) {
                const cleanedAmountString = amountString
                    .replace(/\./g, '') // Remove thousands separators (.)
                    .replace(',', '.'); // Replace decimal comma with dot

                const amount = parseFloat(cleanedAmountString) || 0; // Parse as float
                totalAmount += amount; // Accumulate the total
            }
        });

        // Format the total amount to the Indonesian locale format
        $('#total-receipt-amount').text(totalAmount.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })); // Ensure the decimal point is replaced with a comma

        // Enable button if valid amount values and receipt date is not empty
        const receiptDate = $('#receipt_date').val().trim();
        $('button[type="submit"]').prop('disabled', !(totalAmount > 0 && totalAmount <= 9999999999) || receiptDate ===
            '');
    }

    // Event listener for the add receipt row button
    document.getElementById('add-receipt-row').addEventListener('click', function() {
        if (receiptIndex >= maxRowsReceipt) {
            return; // Prevent adding more rows if max rows are reached
        }

        let oldEntries = @json(old('receipts', [])); // Fetch the old receipts passed from the controller
        const oldEntry = oldEntries[receiptIndex] || {}; // Retrieve old entry if it exists

        const newRow = `
            <tr class="receipt-row">
                <td>
                    <select name="receipts[${receiptIndex}][account_id]" class="form-control kt_selectpicker" required data-live-search="true" title="{{ __('Choose') }} {{ __('Account') }}">
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" ${oldEntry.account_id == {{ $account->id }} ? 'selected' : ''}>
                                {{ $account->account_code . ' - ' . $account->sub_account_name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" name="receipts[${receiptIndex}][amount]" class="form-control receipt-amount" step="0.01" value="${oldEntry.amount || ''}">
                </td>
                <td>
                    <input type="text" name="receipts[${receiptIndex}][note]" class="form-control" value="${oldEntry.note || ''}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger remove-receipt-row"><i class="la la-trash"></i></button>
                    <input type="hidden" name="receipts[${receiptIndex}][is_remove]" value="0" class="remove-entry-receipt">
                </td>
            </tr>
        `;

        $('#receipt-table-body').append(newRow); // Append the new row
        receiptIndex++; // Increment the index for future rows
        toggleAddButtonReceipt(); // Update Add button visibility

        // Reinitialize selectpicker for the new select element
        $('.kt_selectpicker:last').selectpicker({
            liveSearch: true,
            liveSearchPlaceholder: "{{ __('Search Account') }}",
            noneResultsText: "{{ __('No matching results') }} {0}",
            showContent: true,
            showTick: true
        }).selectpicker('refresh');
    });

    // Event delegation to handle the removal of receipt rows
    $('#receipt-table-body').on('click', '.remove-receipt-row', function() {
        rowToRemoveReceipt = $(this).closest('tr'); // Store the row to be removed
        $('#confirmationModalReceipt').modal('show'); // Show the confirmation modal
    });

    // Handle the confirmation button click
    $('#confirmRemoveReceipt').on('click', function() {
        const $row = rowToRemoveReceipt; // Get the stored row
        $row.find('.remove-entry-receipt').val('1'); // Mark the entry as removed
        $row.hide(); // Hide the row

        receiptIndex--; // Decrement index since a row was removed
        calculateAmountReceipt(); // Calculate balance and toggle save button
        toggleSaveButtonReceipt();
        toggleAddButtonReceipt(); // Update Add button visibility
        $('#confirmationModalReceipt').modal('hide'); // Hide the modal after confirmation
    });

    $('#receipt-table-body').on('blur', '.receipt-amount', function() {
        // Get the raw value from the input
        const rawValue = $(this).val().replace(/\./g, '').replace(',',
            '.'); // Remove dots and replace comma with dot
        const amount = parseFloat(rawValue) || 0; // Parse it to a float

        // Format the value for display
        const formattedAmount = amount.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        $(this).val(formattedAmount); // Set the formatted value back to the input

        calculateAmountReceipt(); // Calculate totals
        toggleSaveButtonReceipt(); // Update the save button state
    });

    $('#receipt_date').datepicker({
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
