@extends('layouts.app')

@section('title', 'provider-list')

@section('content')
<div class="col-sm-9 col-md-10 main-content" style="margin-top: 5px;">
    <div class="btn-group">
        <a href="{{ route('provider.create') }}" class="btn btn-primary btn-md">
            <span class="glyphicon glyphicon-plus-sign"></span> Add Provider
        </a>

    </div>
     <div class="btn-group">
        <a href="{{ route('provider.report') }}" class="btn btn-primary btn-md">
        <span class="glyphicon glyphicon-plus-sign"></span> Payment Report</a>
    </div>
   <div class="btn-group">
    @if($firstProviderId)
    <a href="{{ route('provider.transfer-report', $firstProviderId) }}" class="btn btn-primary btn-md">
@else
    <a href="{{ route('provider.index') }}" class="btn btn-primary btn-md">
@endif
    <span class="glyphicon glyphicon-plus-sign"></span> Transfer Report
</a>

    </div>
    <div class="top10">
        <form class="form-inline filter" role="form"  action="{{ route('providers.filter') }}" accept-charset="utf-8" method="post">
            @csrf
            @method("POST")
            <input type="hidden" name="uri" value=""/>

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
                    <label for="provider">Provider Name</label><br/>
                    <input type="text" class="form-control input-xs" name="provider_name" id="provider_name" placeholder="provider_name" size="20" value="{{ old('provider_name') }}">
                </div>

                <div class="col-md-2 form-group">
                    <label for="provider_type">Provider Type</label><br/>
                    <input type="text" class="form-control input-xs" name="provider_type" id="provider_type" placeholder="provider_type" size="18" value="{{ old('provider_type') }}">
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
                    <th>Provider </th>
                    <th>Provider Type</th>
                    <th>Opening Balance</th>
                    <th>Receive</th>
                    <th>Total Balance</th>
                    <th>Note</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($providers as $provider)

                <tr>
                    <td>{{ $provider->id }}</td>
                    <td>{{ $provider->provider_name }}</td>
                    <td>{{ $provider->provider_type }}</td>
                    <td>{{ $provider->opening_balance }}</td>
                    <td><a href="{{ route('provider.receive-report', $provider->id) }}" target="_blank"  style="text-decoration: none; color: black;">{{ $provider->receive }}</a></td>
                    <td>{{ $provider->total_balance }}</td>
                    <td>{{ $provider->note }}</td>
                    <td>
                        <form action="{{ route('provider.toggle-status', $provider->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $provider->active ? 'btn-success' : 'btn-danger' }}">
                                {{ $provider->active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>

                    <td>
                        <div class="btn-group">
                            <form action="{{ route('provider.receive-payment-form', $provider->id) }}" method="get">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Payment </button>
                            </form>
                            <form action="{{ route('provider.transfer', $provider->id) }}" method="get">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary"> Transfer</button>
                            </form>
                            <form action="{{ route('provider.destroy', $provider->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this provider?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection
