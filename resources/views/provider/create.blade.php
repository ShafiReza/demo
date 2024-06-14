@extends('layouts.app')

@section('title', 'Add Provider')

@section('content')

    <div class="col-sm-3 col-md-3 main-content" style="margin-top: 5px;">
        <!-- Your given content goes here -->
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <form action="{{ route('provider.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="provider_name">Provider Name</label>
                <input type="text" name="provider_name" id="provider_name" class="form-control" placeholder="Provider Name"
                    value="{{ old('provider_name') }}">
            </div>
            <div class="form-group">
                <label for="provider_type">Provider Type</label>
                <input type="text" name="provider_type" id="provider_type" class="form-control"
                    placeholder="Provider Type" value="{{ old('provider_type') }}">
            </div>
            <div class="form-group">
                <label for="opening_balance"> Balance</label>
                <input type="text" name="opening_balance" id="opening_balance" class="form-control"
                    placeholder="Opening Balance" value="{{ old('opening_balance') }}">
            </div>
            <div class="form-group">
                <label for="note">Note</label>
                <textarea name="note" id="note" class="form-control" rows="2">{{ old('note') }}</textarea>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="active" value="1" {{ old('active') ? 'checked' : '' }}> Active
                    </label>
                </div>
            </div>
            <div class="btn-group">
                <button class="btn btn-primary btn-md">
                    <span class="glyphicon glyphicon-plus-sign"></span> Add Provider
                </button>
            </div>
        </form>
    </div>
@endsection
