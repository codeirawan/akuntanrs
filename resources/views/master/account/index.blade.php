@extends('layouts.app')

@section('title')
    {{ __('Account') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.account.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Account') }}</a>
@endsection

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                @include('layouts.inc.alert')

                @if (Laratrust::isAbleTo('create-master'))
                    <a href="{{ route('master.account.create') }}" class="btn btn-primary mb-4">
                        <i class="fa fa-plus"></i> {{ __('New Account') }}
                    </a>
                @endif

                <table class="table" id="kt_table_1"></table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('layouts.inc.modal.delete', ['object' => 'account'])

    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/tooltip.js') }}"></script>
    <script type="text/javascript">
        $('#kt_table_1').DataTable({
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
                url: '{{ route('master.account.data') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [{
                    title: "{{ __('Account Code') }}",
                    data: 'account_code',
                    name: 'account_code',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Account Name') }}",
                    data: 'account_name',
                    name: 'account_name',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Sub Account Name') }}",
                    data: 'sub_account_name',
                    name: 'sub_account_name',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Account Type') }}",
                    data: 'account_type',
                    name: 'account_type',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Debit/Credit Type') }}",
                    data: function(row) {
                        return row.is_debit ? "{{ __('Debit') }}" : "{{ __('Credit') }}";
                    },
                    class: 'text-center',
                },
                {
                    title: "{{ __('Balance Sheet Flag') }}",
                    data: function(row) {
                        return row.bs_flag ?
                            '<i class="la la-check text-success font-weight-bold"></i>' :
                            '<i class="la la-times text-danger font-weight-bold"></i>';
                    },
                    class: 'text-center',
                },
                {
                    title: "{{ __('Profit/Loss Flag') }}",
                    data: function(row) {
                        return row.pl_flag ?
                            '<i class="la la-check text-success font-weight-bold"></i>' :
                            '<i class="la la-times text-danger font-weight-bold"></i>';
                    },
                    class: 'text-center',
                },
                {
                    title: "{{ __('Opening Balance') }}",
                    data: 'opening_balance',
                    name: 'opening_balance',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Opening Balance Date') }}",
                    data: 'opening_balance_date',
                    name: 'opening_balance_date',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Is Active') }}",
                    data: function(row) {
                        return row.is_active ?
                            '<i class="la la-check text-success font-weight-bold"></i>' :
                            '<i class="la la-times text-danger font-weight-bold"></i>';
                    },
                    class: 'text-center',
                },
                {
                    title: "{{ __('Action') }}",
                    data: 'action',
                    name: 'action',
                    defaultContent: '-',
                    class: 'text-center',
                    searchable: false,
                    orderable: false
                }
            ],
            drawCallback: function() {
                $('.btn-tooltip').tooltip();
            }
        });
    </script>
@endsection
