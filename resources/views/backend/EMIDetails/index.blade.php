@extends('backend.layouts.master')
@push('title')
    <title>Process EMI Data</title>
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
            <h6 class="m-0 font-weight-bold text-primary float-left">Dashboard > Process EMI Data</h6>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <h1 style="margin-bottom: 20px;">Process EMI Data</h1>
                <form action="{{ route('emi_details.process') }}" method="POST">
                    @csrf
                    <button type="submit"
                        style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Process
                        Data</button>
                </form>
            </div>
        </div>
    </div>
@endsection
