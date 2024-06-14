@extends('layouts.app')

@section('title', 'client-list')

@section('content')
<div class="col-sm-9 col-md-10 main-content" style="margin-top: 5px;">
    <div class="btn-group">
        <a href="{{ route('client.create') }}" class="btn btn-primary btn-md">
            <span class="glyphicon glyphicon-plus-sign"></span> Add Client
        </a>
    </div>
    <div class="top10">
        <form class="form-inline filter" role="form" method="post" action="{{ route('client.filter') }}" accept-charset="utf-8">
            @csrf
            @method("POST")
            <div class="row">
                <div class="col-sm-1 form-group">
                    <label for="rows">Show</label><br/>
                    <select class="form-control input-xs" name="rows" >
                        <option {{ old('rows') == '50' ? 'selected' : '' }}>50</option>
                        <option {{ old('rows') == '100' ? 'selected' : '' }}>100</option>
                        <option {{ old('rows') == '150' ? 'selected' : '' }}>150</option>
                        <option {{ old('rows') == '200' ? 'selected' : '' }}>200</option>
                    </select>
                </div>

                <div class="col-md-2 form-group">
                    <label for="client_name">Client Name</label><br/>
                    <input type="text" class="form-control input-xs" name="client_name" id="client_name" placeholder="client_name" size="20" value="{{ old('client_name') }}">
                </div>

                <div class="col-md-2 form-group">
                    <label for="type">Type</label><br/>
                    <input type="text" class="form-control input-xs" name="type" id="type" placeholder="type" size="18" value="{{ old('type') }}">
                </div>

                <div class="col-md-2 form-group">
                    <label for="status">Status</label><br/>
                    <select class="form-control input-xs" name="status" id="status">
                        <option value="">All</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-md-2 form-group">
                    <label for="exampleInputPassword2"></label><br/>
                    <button type="submit" class="btn btn-danger btn-md">
                        <span class="fas fa-search"></span> Filter
                    </button>
                </div>

            </div>
        </form>
    </div>


    <div class="top10">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Provider</th>
                    <th>Type</th>
                    <th>Opening Balance</th>
                    <th>Receive</th>
                    <th>Sales</th>
                    <th>Commission</th>
                    <th>Total Balance</th>
                    {{-- <th>Date</th> --}}
                    <th>Note</th>
                    <th>Action</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)

                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->client_name}}</td>
                    <td>{{ $client->provider->provider_name }}</td>
                    <td>{{ $client->type }}</td>
                    <td>{{ $client->opening_balance }}</td>
                    <td>
                        <a href="{{ route('client.receive-report', $client->id) }}" target="_blank"  style="text-decoration: none; color: black;">{{ $client->receive }}</a>
                    </td>
                    <td>
                        <a href="{{ route('client.sales-report', $client->id) }}" target="_blank" style="text-decoration: none; color: black;">{{ $client->sales }}</a>

                    </td>
                    <td>{{ $client->commission_rate }}</td>
                    <td>
                        <a href="{{ route('client.generate-report', $client->id) }}" target="_blank" style="text-decoration: none; color: black;"><b>{{ $client->total_balance }}</b></a>
                    </td>
                    {{-- <td>{{$client->created_at}}</td> --}}
                    <td>{{ $client->note }}</td>

                    <td>
                        <div class="btn-group">
                            <form action="{{ route('client.receive-payment-form', $client->id) }}" method="get">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Receive </button>
                            </form>
                            <form action="{{ route('client.add-sales-page', $client->id) }}" method="get">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary"> Sales</button>
                            </form>
                            <form action="{{ route('client.edit', $client->id) }}" method="get">
                                @csrf

                                <button type="submit" class="btn btn-sm btn-primary">Edit</button>
                            </form>
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('client.toggle-status', $client->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $client->active ? 'btn-success' : 'btn-danger' }}">
                                {{ $client->active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

    </div>
</div>
@endsection
