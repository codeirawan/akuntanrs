@extends('layouts.app')

@section('title', __('Cash Flow Statement') . ' | ' . config('app.name'))

@section('style')
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endsection

@section('breadcrumb')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('cash-flow.index') }}" class="kt-subheader__breadcrumbs-link">{{ __('Cash Flow Statement') }}</a>
@endsection

@section('content')
    <div class="kt-portlet">
        <div class="kt-portlet__body">
            <div class="kt-portlet__content">
                @include('layouts.inc.alert')

                <!-- Filter by Date Range -->
                <form action="{{ route('cash-flow.index') }}" method="GET" class="mb-4" id="filterForm">
                    <div class="form-row align-items-end">
                        <div class="col">
                            <label for="start_date">{{ __('Start Date') }}</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ $selectedStartDate }}">
                        </div>
                        <div class="col">
                            <label for="end_date">{{ __('End Date') }}</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ $selectedEndDate }}">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                        </div>
                    </div>
                </form>

                <!-- Display Cash Flow -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Description') }}</th>
                                <th>{{ __('Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ __('Cash Inflows') }}</td>
                                <td>{{ number_format($cashInflows, 2) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Cash Outflows') }}</td>
                                <td>{{ number_format($cashOutflows, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ __('Net Cash Flow') }}</strong></td>
                                <td><strong>{{ number_format($netCashFlow, 2) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('filterForm').onsubmit = function() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            let query = '';

            if (startDate) {
                query += `start_date=${startDate}&`;
            }
            if (endDate) {
                query += `end_date=${endDate}`;
            }

            // Set the form action with the query parameters
            this.action = `{{ route('cash-flow.index') }}?${query}`;
        };
    </script>
@endsection
