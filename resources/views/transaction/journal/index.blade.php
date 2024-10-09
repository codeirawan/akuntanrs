@extends('layouts.app')

@section('title')
    {{ __('Journal Entries') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('journal.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Journal Entries') }}</a>
@endsection

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                @include('layouts.inc.alert')

                @if (Laratrust::isAbleTo('create-transaction'))
                    <a href="{{ route('journal.create') }}" class="btn btn-primary mb-4">
                        <i class="fa fa-plus"></i> {{ __('New Journal Entry') }}
                    </a>
                @endif

                <table id="kt_table_1" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th rowspan="2">{{ __('Date') }}</th>
                            <th rowspan="2">{{ __('Journal No.') }}</th>
                            <th colspan="3">{{ __('Debit') }}</th>
                            <th colspan="3">{{ __('Credit') }}</th>
                            <th rowspan="2">{{ __('Action') }}</th>
                        </tr>
                        <tr>
                            <th>{{ __('Account') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Remarks') }}</th>
                            <th>{{ __('Account') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Remarks') }}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script type="text/javascript">
        $('#kt_table_1').DataTable({
            order: [[1, 'desc']],
            processing: true,
            serverSide: true,
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
            },
            ajax: {
                method: 'POST',
                url: '{{ route('journal.data') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [{
                    data: 'journal_date',
                    name: 'journal_date',
                    title: "{{ __('Date') }}"
                },
                {
                    data: 'voucher_code',
                    name: 'voucher_code',
                    title: "{{ __('Journal No.') }}",
                },
                {
                    data: 'accounts_debit',
                    name: 'accounts_debit',
                    title: "{{ __('Account') }}",
                    class: 'text-left',
                },
                {
                    data: 'debit',
                    name: 'debit',
                    title: "{{ __('Amount') }}",
                    class: 'text-right',
                },
                {
                    data: 'debit_note',
                    name: 'debit_note',
                    title: "{{ __('Remarks') }}",
                    class: 'text-left',
                },
                {
                    data: 'accounts_credit',
                    name: 'accounts_credit',
                    title: "{{ __('Account') }}",
                    class: 'text-left',
                },
                {
                    data: 'credit',
                    name: 'credit',
                    title: "{{ __('Amount') }}",
                    class: 'text-right',
                },
                {
                    data: 'credit_note',
                    name: 'credit_note',
                    title: "{{ __('Remarks') }}",
                    class: 'text-left',
                },
                {
                    data: 'action',
                    name: 'action',
                    title: "{{ __('Action') }}",
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });
    </script>
@endsection
