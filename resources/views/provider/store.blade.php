@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Provider Created Successfully</div>

                    <div class="card-body">
                        <p>Your provider has been created successfully!</p>
                        <a href="{{ route('providers.index') }}" class="btn btn-primary">Back to Provider List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
