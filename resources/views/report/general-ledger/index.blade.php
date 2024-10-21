@extends('layouts.app')

@section('title', __('General Ledger') . ' | ' . config('app.name'))

@section('style')
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('general-ledger.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('General Ledger') }}</a>
@endsection

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                @include('layouts.inc.alert')

                <!-- Filter Account and Date Range -->
                <form action="{{ route('general-ledger.index') }}" method="GET" class="mb-4">
                    <div class="form-row align-items-end">
                        <div class="col">
                            <label for="account_id">{{ __('Select Account') }}</label>
                            <select name="account_id" id="account_id" class="form-control kt_selectpicker"
                                data-live-search="true" title="{{ __('Choose') }} {{ __('Account') }}">
                                {{-- <option value="">{{ __('All Accounts') }}</option> --}}
                                @foreach ($accounts as $index => $account)
                                    <option value="{{ $account->id }}"
                                        {{ session('selected_account') == $account->id || ($index === 0 && !session('selected_account')) ? 'selected' : '' }}>
                                        {{ $account->account_code }} - {{ $account->sub_account_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="month">{{ __('Select Month') }}</label>
                            <select name="month" id="month" class="form-control">
                                <option value="">{{ __('All Months') }}</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}"
                                        {{ session('selected_month') == $i || (session('selected_month') === null && $i == date('n')) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col">
                            <label for="year">{{ __('Select Year') }}</label>
                            <input type="number" name="year" id="year" class="form-control"
                                value="{{ session('selected_year', date('Y')) }}" min="2000"
                                max="{{ date('Y') }}">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="kt_table_1">
                        <thead>
                            <tr>
                                <th>{{ __('Journal No.') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Account') }}</th>
                                <th>{{ __('Debit Amount') }}</th>
                                <th>{{ __('Credit Amount') }}</th>
                                <th>{{ __('Balance') }}</th>
                                <th>{{ __('Remarks') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($journals as $journal)
                                <tr>
                                    <td>{{ $journal->voucher_code }}</td>
                                    <td>{{ $journal->journal_date->format('Y/m/d') }}</td>
                                    <td>{{ $journal->account->account_code ?? 'N/A' }}
                                        {{ $journal->account->sub_account_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($journal->debit, 2) }}</td>
                                    <td>{{ number_format($journal->credit, 2) }}</td>
                                    <td>{{ number_format($journal->debit - $journal->credit, 2) }}</td>
                                    <td>{{ $journal->note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">{{ __('Total') }}</th>
                                <th>{{ number_format($totalDebit, 2) }}</th>
                                <th>{{ number_format($totalCredit, 2) }}</th>
                                <th>{{ number_format($totalDebit - $totalCredit, 2) }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#kt_table_1').DataTable({
                language: {
                    emptyTable: "{{ __('No data available in table') }}",
                    info: "{{ __('Showing _START_ to _END_ of _TOTAL_ entries') }}",
                    infoEmpty: "{{ __('Showing 0 to 0 of 0 entries') }}",
                    infoFiltered: "({{ __('filtered from _MAX_ total entries') }})",
                    lengthMenu: "{{ __('Show _MENU_ entries') }}",
                    loadingRecords: "{{ __('Loading') }}...",
                    processing: "{{ __('Processing') }}...",
                    search: "{{ __('Search') }}",
                    zeroRecords: "{{ __('No matching records found') }}"
                }
            });
        });
    </script>
    <script>
        document.getElementById('filterForm').onsubmit = function() {
            const accountId = document.getElementById('account_id').value;
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;

            let query = '';

            if (accountId) {
                query += `account_id=${accountId}&`;
            }
            if (month) {
                query += `month=${month}&`;
            }
            if (year) {
                query += `year=${year}`;
            }

            // Set the form action with the query parameters
            this.action = `{{ route('general-ledger.index') }}?${query}`;
        };
    </script>
    <script type="text/javascript">
        $('.kt_selectpicker').selectpicker({
            liveSearch: true,
            liveSearchPlaceholder: "{{ __('Search Account') }}",
            noneResultsText: "{{ __('No matching results') }} {0}",
            showContent: true,
            showTick: true
        });
    </script>
@endsection
