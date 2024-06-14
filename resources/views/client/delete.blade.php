@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Confirm Deletion</div>

                    <div class="card-body">
                        <p>Are you sure you want to delete this client?</p>

                        <form action="{{ route('client.destroy', $client->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            <a href="{{ route('client.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
