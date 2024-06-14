@extends('layouts.app')

@section('title', 'Transfer Amount')

@section('content')

<div class="col-sm-3 col-md-3 main-content" style="margin-top: 5px;">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <form action="{{ route('provider.transfer-funds') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="from_provider">From Provider:</label>
            <select name="from_provider" class="form-control">

                @foreach ($provider as $providers)
                    <option value="{{ $providers->id }}">{{ $providers->provider_name }}</option>
                @endforeach

            </select>
        </div>
        <div class="form-group">
            <label for="transfer_amount">Transfer Amount:</label>
            <input type="text" name="transfer_amount" class="form-control">
        </div>
        <div class="form-group">
            <label for="to_provider">To Provider:</label>
            <select name="to_provider" class="form-control">
                <!-- Populate dropdown options with provider list -->
                @foreach($provider as $provider)
                    <option value="{{ $provider->id }}">{{ $provider->provider_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="note">Note:</label>
            <textarea name="note" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Transfer</button>
    </form>

</div>
@endsection
