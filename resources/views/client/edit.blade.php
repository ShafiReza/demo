@extends('layouts.app')

@section('title', 'Edit Client')

@section('content')

<div class="col-sm-3 col-md-3 main-content" style="margin-top: 5px;">
    <form action="{{ route('client.update', $client->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="client_name">Client Name</label>
            <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Client Name" value="{{ $client->client_name }}">
        </div>
        <div class="form-group">
            <label for="provider_name">Provider Name</label>
            <select name="provider_id" class="form-control">
                @foreach ($providers as $provider)
                <option value="{{ $provider->id }}" {{ $client->provider_id == $provider->id ? 'selected' : '' }}>{{ $provider->provider_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" name="type" id="type" class="form-control" placeholder="Type" value="{{ $client->type }}">
        </div>
        <div class="form-group">
            <label for="commission_rate">Commission Rate</label>
            <input type="text" name="commission_rate" id="commission_rate" class="form-control" placeholder="Commission Rate" value="{{ $client->commission_rate }}">
        </div>

        <div class="form-group">
            <label for="note">Note</label>
            <textarea name="note" id="note" class="form-control" rows="2">{{ $client->note }}</textarea>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="active" value="1" {{ $client->active ? 'checked' : '' }}> Active
                </label>
            </div>
        </div>
        <div class="btn-group">
            <button type="submit" class="btn btn-sm btn-primary">Update</button>
        </div>
    </form>
</div>

@endsection
