@extends('layouts.app')

@section('title', 'Provider Details')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">



                <div class="card-body">
                    <p><strong>ID:</strong> {{ $provider->id}}</p>
                    <p><strong>Provider Name:</strong> {{ $provider->provider_name }}</p>
                    <p><strong>Provider Type:</strong> {{ $provider->provider_type }}</p>
                    <p><strong>Opening Balance:</strong> {{ $provider->opening_balance }}</p>
                    <p><strong>Receive:</strong> {{ $provider->receive }}</p>
                    <p><strong>Total Balance:</strong> {{ $provider->total_balance }}</p>
                    <p><strong>Note:</strong> {{ $provider->note }}</p>
                    <p><strong>Status:</strong> {{ $provider->active ? 'Active' : 'Inactive' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
