@extends('layouts.app')

@section('title', 'client-add')

@section('content')

    <div class="col-sm-3 col-md-3 main-content" style="margin-top: 5px;">
        <!-- Your given content goes here -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('client.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="client_name">Client Name</label>
                <input type="text" name="client_name" id="client_name" class="form-control" placeholder="client_name"
                    value="{{ old('client_name') }}">
            </div>
            <div class="form-group">
                <label for="provider_name">Provider Name</label>
                <select name="provider_id" class="form-control" id="provider_id">
                    <option>-----Select Provider------</option>
                    @foreach ($providers as $provider)

                        <option value="{{ $provider->id }}" data-provider-type="{{ $provider->provider_type }}">{{ $provider->provider_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <input type="text" name="type" id="type" class="form-control" placeholder="Type" value="{{ old('type') }}">
            </div>

            <div class="form-group">
                <label for="commission_rate">Commission Rate</label>
                <input type="text" name="commission_rate" id="commission_rate" class="form-control"
                    placeholder="Commission Rate" value="{{ old('commission_rate') }}">

            </div>
            <div class="form-group">
                <label for="opening_balance">Opening Balance</label>
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
                    <span class="glyphicon glyphicon-plus-sign"></span> Add User
                </button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#provider_id').change(function() {
                const providerId = $(this).val();
                // Assuming that provider_type is sent as a data attribute with the provider option
                const providerType = $('#provider_id option[value="' + providerId + '"]').data('provider-type');
                $('#type').val(providerType);
            });
        });
    </script>


@endsection
