<!-- resources/views/clients/store.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Client Created Successfully</div>

                    <div class="card-body">
                        <p>Your client has been created successfully!</p>
                        <a href="{{ route('client.index') }}" class="btn btn-primary">Back to Client List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
