@extends('backend.layouts.master')
@push('title')
    <title>Loan Details</title>
@endpush
@push('styles')
    <style>
        /* div.dataTables_wrapper div.dataTables_paginate {
                            display: none;
                        } */
        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(3.2);
        }
    </style>
@endpush
@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Dashboard > Loan Details</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Number of Payments</th>
                            <th>First Payment Date</th>
                            <th>Last Payment Date</th>
                            <th>Loan Amount</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Client ID</th>
                            <th>Number of Payments</th>
                            <th>First Payment Date</th>
                            <th>Last Payment Date</th>
                            <th>Loan Amount</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($loanDetails as $loan)
                            <tr>
                                <td>{{ $loan->clientid }}</td>
                                <td>{{ $loan->num_of_payment }}</td>
                                <td>{{ $loan->first_payment_date }}</td>
                                <td>{{ $loan->last_payment_date }}</td>
                                <td>{{ $loan->loan_amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
