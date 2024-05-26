@extends('backend.layouts.master')
@push('title')
    <title>EMI Details</title>
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
            <h6 class="m-0 font-weight-bold text-primary float-left">Dashboard > EMI Details</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            @foreach ($emiDetails[0] as $key => $value)
                                @if ($key != 'clientid')
                                    <th>{{ $key }}</th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emiDetails as $detail)
                            <tr>
                                <td>{{ $detail->clientid }}</td>
                                @foreach ($detail as $key => $value)
                                    @if ($key != 'clientid')
                                        <td>{{ number_format($value, 2) }}</td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
