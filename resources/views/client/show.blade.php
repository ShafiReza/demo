@extends('layouts.app')

@section('title', 'Client Details')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">

                    <div class="client-card">
                        <p><strong>ID</strong> {{ $clients->id??"" }}</p>
                        <p><strong>Client Name</strong> {{ $clients->client_name??"" }}</p>
                        <p><strong>Provider</strong> {{ $clients->provider->provider_name??"" }}</p>
                        <p><strong>Type</strong> {{ $clients->type??"" }}</p>
                        <p><strong>Opening Balance</strong> {{ $clients->opening_balance??"" }}</p>
                        <p><strong>Receive</strong> {{ $clients->receive??"" }}</p>
                        <p><strong>Sales</strong> {{ $clients->sales??"" }}</p>
                        <p><strong>Commission</strong> {{ $clients->commission_rate??"" }}</p>
                        <p><strong>Total Balance</strong> {{ $clients->total_balance??"" }}</p>
                        <p><strong>Time</strong> {{ $clients->created_at??"" }}</p>
                        <p><strong>Note:</strong> {{ $clients->note??"" }}</p>
                        {{-- <p><strong>Status:</strong> {{ $clients->active ? 'Active' : 'Inactive'??"" }}</p> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
