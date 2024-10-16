@extends('layouts.app')

@section('title')
    {{ __('Services') }} | {{ config('app.name') }}
@endsection

@section('style')
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span><a href="{{ route('master.service.index') }}"
        class="kt-subheader__breadcrumbs-link">{{ __('Services') }}</a>
@endsection

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                @include('layouts.inc.alert')

                @if (Laratrust::isAbleTo('create-master'))
                    <a href="{{ route('master.service.create') }}" class="btn btn-primary mb-4">
                        <i class="fa fa-plus"></i> {{ __('New Service') }}
                    </a>
                @endif

                <table class="table" id="kt_table_1"></table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('layouts.inc.modal.delete', ['object' => 'service'])

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
                url: '{{ route('master.service.data') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {
                    title: "{{ __('Service Code') }}",
                    data: 'service_code',
                    name: 'service_code',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Service Name') }}",
                    data: 'service_name',
                    name: 'service_name',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Price') }}",
                    data: 'price',
                    name: 'price',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Description') }}",
                    data: 'description',
                    name: 'description',
                    defaultContent: '-',
                    class: 'text-center',
                },
                {
                    title: "{{ __('Service Type') }}",
                    data: 'service_type',
                    name: 'service_type',
                    defaultContent: '-',
                    class: 'text-center',
                    render: function(data) {
                        switch(data) {
                            case 1: return 'Consultation';
                            case 2: return 'Surgery';
                            case 3: return 'Diagnostic';
                            case 4: return 'Inpatient';
                            case 5: return 'Outpatient';
                            default: return '-';
                        }
                    }
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
