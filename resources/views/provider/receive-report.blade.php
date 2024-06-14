@extends('layouts.app' , ['id' => $provider->id])

@section('title', 'Receive Report')

@section('content')

<div class="col-sm-9 col-md-10 main-content" style="margin-top: 5px;">

    <form action="{{ route('provider.receive-report', $provider->id) }}" method="GET" class="form-inline mb-3">
        <div class="row">
        <div class="col-md-2 form-group">
            <label for="from_date">From:</label>
            <input type="date" id="from_date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>
        <div class="col-md-2 form-group">
            <label for="to_date">To:</label>
            <input type="date" id="to_date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>
       
        <div class="col-md-2 form-group">
            <label></label><br/>
        <button type="submit" class="btn btn-primary btn-md"><span class="fas fa-search"></span>Filter</button>
        <button class="btn btn-primary" onclick="printContent()">
            <span class="fas fa-print"></span> Print
        </button>
        </div>

        </div>
    </form>
    <div class="prnt" id="prnt">
        <h4>Receive Report for {{ $provider->provider_name}}</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Money</th>
                <th>Date</th>
                <th>Type</th>
                <th>Balance</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td>{{$payment->amount }}</td>
                <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                <td>{{ ucfirst($payment->type) }}</td>
                <td>{{ $payment->updated_balance }}</td>
                <td>{{ $payment->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        function printContent() {
            var printContent = document.getElementById("prnt").innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        }
    </script>
</div>
</div>
@endsection
