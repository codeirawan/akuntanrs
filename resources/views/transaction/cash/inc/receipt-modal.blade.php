<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modalId }}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modalId }}Label">{{ $modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="kt-form" method="POST" action="{{ $actionRoute }}" enctype="multipart/form-data">
                    @csrf
                    <div class="kt-portlet__body">
                        @include('layouts.inc.alert')

                        <div class="card mb-4">
                            <div class="card-header">{{ __($cardHeader) }}</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="receipt_date">{{ __($modalTitle) }} {{ __('Date') }}</label>
                                        <input id="receipt_date" name="receipt_date" type="text"
                                            placeholder="{{ __('Select') }} {{ __('Date') }}"
                                            class="form-control @error('receipt_date') is-invalid @enderror"
                                            value="{{ old('receipt_date') }}" autocomplete="off" readonly>

                                        @error('receipt_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="receipt-table">
                                        <thead class="bg-secondary text-center">
                                            <tr>
                                                <th>{{ __('Account') }}</th>
                                                <th>{{ __('Amount') }}</th>
                                                <th>{{ __('Remarks') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody id="receipt-table-body">
                                            <tr class="receipt-row">
                                                <td>
                                                    <select name="receipts[0][account_id]"
                                                        class="form-control kt_selectpicker" required
                                                        data-live-search="true"
                                                        title="{{ __('Choose') }} {{ __('Account') }}">
                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account->id }}"
                                                                {{ old('receipts.0.account_id') == $account->id ? 'selected' : '' }}>
                                                                {{ $account->account_code . ' - ' . $account->sub_account_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="receipts[0][amount]"
                                                        class="form-control receipt-amount" step="0.01"
                                                        value="{{ old('receipts.0.amount') }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="receipts[0][note]" class="form-control"
                                                        value="{{ old('receipts.0.note') }}">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger remove-receipt-row"><i
                                                            class="la la-trash"></i></button>
                                                    <input type="hidden" name="receipts[0][is_remove]" value="0"
                                                        class="remove-entry-receipt">
                                                </td>
                                            </tr>
                                        </tbody>

                                        <tr class="receipt-row">
                                            <td colspan="4">
                                                <button type="button" class="btn btn-primary btn-full-width"
                                                    id="add-receipt-row">+</button>
                                            </td>
                                        </tr>

                                        <tfoot>
                                            <tr class="text-right">
                                                <th colspan="1">{{ __('Total Amount') }}</th>
                                                <th id="total-receipt-amount">0.00</th>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">{{ $submitButtonText }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModalReceipt" tabindex="-10" role="dialog"
    aria-labelledby="confirmationModalReceiptLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalReceiptLabel">{{ __('Confirm Removal') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to remove this entry?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmRemoveReceipt">{{ __('Remove') }}</button>
            </div>
        </div>
    </div>
</div>
