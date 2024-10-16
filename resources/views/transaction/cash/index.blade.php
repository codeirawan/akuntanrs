@extends('layouts.app')

@section('title')
    {{ __('Journal Entries') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/journal.css') }}" rel="stylesheet">
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
                    <button type="button" class="btn btn-primary mb-4 kt-margin-r-5" data-toggle="modal"
                        data-target="#isModalReceipt">
                        <i class="fa fa-plus"></i> {{ __('New Receipt') }}
                    </button>

                    <button type="button" class="btn btn-danger mb-4" data-toggle="modal" data-target="#isModalPayment">
                        <i class="fa fa-plus"></i> {{ __('New Payment') }}
                    </button>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="kt_table_1"></table>
                </div>

            </div>
        </div>
    </div>

    <!-- Show Modal for Receipt -->
    @include('transaction.cash.inc.receipt-modal', [
        'modalId' => 'isModalReceipt',
        'modalTitle' => 'Receipt',
        'cardHeader' => 'Create New Receipt',
        'actionRoute' => route('cash.store'),
        'submitButtonText' => 'Save Receipt',
    ])

    <!-- Show Modal for Payment -->
    @include('transaction.cash.inc.payment-modal', [
        'modalId' => 'isModalPayment',
        'modalTitle' => 'Payment',
        'cardHeader' => 'Create New Payment',
        'actionRoute' => route('cash.store'),
        'submitButtonText' => 'Save Payment',
    ])
@endsection
@section('script')
    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script type="text/javascript">
        $('#kt_table_1').DataTable({
            order: [
                [6, 'desc']
            ],
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
                url: '{{ route('cash.data') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [{
                    data: 'voucher_code',
                    name: 'voucher_code',
                    title: "{{ __('Journal No.') }}",
                    class: 'text-center',
                },
                {
                    data: 'journal_date',
                    name: 'journal_date',
                    title: "{{ __('Date') }}",
                    class: 'text-center',
                },
                {
                    data: 'account',
                    name: 'account',
                    title: "{{ __('Account') }}",
                    class: 'text-left',
                },
                {
                    data: 'debit',
                    name: 'debit',
                    title: "{{ __('Receipt') }}",
                    class: 'text-right',
                },
                {
                    data: 'credit',
                    name: 'credit',
                    title: "{{ __('Payment') }}",
                    class: 'text-right',
                },
                {
                    data: 'note',
                    name: 'note',
                    title: "{{ __('Remarks') }}",
                    class: 'text-left',
                },
                {
                    data: 'updated',
                    name: 'updated',
                    title: "{{ __('Updated') }}",
                    class: 'text-left',
                    render: function(data, type, row) {
                        // Format the updated date
                        const updatedDate = row.updated_at ? moment(row.updated_at).format('DD-MM-YYYY') :
                            '-';
                        // Get the name of the user who updated or created the entry
                        const updatedBy = row.updated_by ? row.updated_by_name : row.created_by_name;

                        // Return the string with a line break
                        return `${updatedDate}<br>by ${updatedBy}`; // This allows the HTML to render correctly
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    title: "{{ __('Action') }}",
                    class: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            drawCallback: function() {
                const cell = document.querySelector('td.text-left.sorting_1');
                if (cell) {
                    console.log(cell.innerHTML); // This will now work correctly
                } else {
                    console.error('Element not found');
                }
            }
        });
    </script>
    @include('transaction.cash.inc.receipt-script')
    @include('transaction.cash.inc.payment-script')
@endsection
