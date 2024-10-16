@extends('layouts.app')

@section('title')
    {{ __('Receipts') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('receipt.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Receipts') }}</a>
@endsection

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                @include('layouts.inc.alert')

                @if (Laratrust::isAbleTo('create-transaction'))
                    <a href="{{ route('receipt.create.medical') }}" class="btn btn-primary mb-4">
                        <i class="fa fa-stethoscope"></i> {{ __('New Medical Record') }}
                    </a>
                    <a href="{{ route('receipt.create.medicine') }}" class="btn btn-dark mb-4">
                        <i class="fa fa-pills"></i> {{ __('New Medicine Purchase') }}
                    </a>
                @endif

                <table class="table" id="kt_table_1"></table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('layouts.inc.modal.delete', ['object' => 'receipt'])

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
                url: '{{ route('receipt.data') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {
                    title: "{{ __('ID') }}",
                    data: 'receipt_code',
                    name: 'receipt_code',
                    defaultContent: '-',
                },
                {
                    title: "{{ __('Date') }}",
                    data: 'receipt_date',
                    name: 'receipt_date',
                    defaultContent: '-',
                    class: 'text-center',
                },
                // {
                //     title: "{{ __('Service Type') }}",
                //     data: 'service_type',
                //     name: 'service_type',
                //     defaultContent: '-',
                // },
                {
                    title: "{{ __('Payment Type') }}",
                    data: 'payment_type',
                    name: 'payment_type',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Payment Status') }}",
                    data: 'payment_status',
                    name: 'payment_status',
                    defaultContent: '-',
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
