@extends('layouts.app')

@section('title', 'Transfer History')

@section('content')
<div class="col-sm-9 col-md-9 main-content">
    <h2>Transfer History</h2>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>From Provider</th>
                    <th>Transfer Amount</th>
                    <th>To Provider</th>
                    <th>Note</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transfers as $transfer)
                <tr>
                    <td>{{ $transfer->fromProvider->provider_name }}</td>
                    <td>{{ $transfer->transfer_amount }}</td>
                    <td>{{ $transfer->toProvider->provider_name }}</td>
                    <td>{{ $transfer->note }}</td>
                    <td>{{ $transfer->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
