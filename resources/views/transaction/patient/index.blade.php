@extends('layouts.app')

@section('title')
    {{ __('Patients') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset(mix('css/datatable.css')) }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('patient.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Patients') }}</a>
@endsection

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                @include('layouts.inc.alert')

                @if (Laratrust::isAbleTo('create-transaction'))
                    <a href="{{ route('patient.create') }}" class="btn btn-primary mb-4">
                        <i class="fa fa-plus"></i> {{ __('New Patient') }}
                    </a>
                @endif

                <table class="table" id="kt_table_1"></table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('layouts.inc.modal.delete', ['object' => 'patient'])

    <script src="{{ asset(mix('js/datatable.js')) }}"></script>
    <script src="{{ asset(mix('js/tooltip.js')) }}"></script>
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
                url: '{{ route('patient.data') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {
                    title: "{{ __('Name') }}",
                    data: 'name',
                    name: 'name',
                    defaultContent: '-',
                },
                {
                    title: "{{ __('NIK') }}",
                    data: 'nik',
                    name: 'nik',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Insurance') }}",
                    data: 'insurance_name',
                    name: 'insurance_name',
                    defaultContent: '-',
                },
                {
                    title: "{{ __('Insurance No.') }}",
                    data: 'insurance_no',
                    name: 'insurance_no',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Age') }}",
                    data: 'age',
                    name: 'age',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Gender') }}",
                    data: 'gender',
                    name: 'gender',
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
