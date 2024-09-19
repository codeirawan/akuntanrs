@extends('layouts.app')

@section('title', __('Cashier Transactions'))

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('transaction.cashier.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Cashier') }}</a>
@endsection

@section('content')
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Cashier Transactions') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        @if(Laratrust::isAbleTo('create-transaction'))
                            <a href="{{ route('transaction.cashier.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                {{ __('New Transaction') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <table class="table table-striped- table-bordered table-hover table-checkable" id="cashier-table">
                <thead>
                    <tr>
                        <th>{{ __('Transaction ID') }}</th>
                        <th>{{ __('Cashier Name') }}</th>
                        <th>{{ __('Transaction Date') }}</th>
                        <th>{{ __('Total Amount') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Confirm Delete') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete this transaction?') }}
                </div>
                <div class="modal-footer">
                    <form method="POST" id="form-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            var table = $('#cashier-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('transaction.cashier.data') }}',
                columns: [
                    {data: 'transaction_id', name: 'transaction_id'},
                    {data: 'cashier_name', name: 'cashier_name'},
                    {data: 'transaction_date', name: 'transaction_date'},
                    {data: 'total_amount', name: 'total_amount'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            // Handle the delete modal
            $('#modal-delete').on('show.bs.modal', function (e) {
                var button = $(e.relatedTarget);
                var href = button.data('href');
                $('#form-delete').attr('action', href);
            });
        });
    </script>
@endpush
