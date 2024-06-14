@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="col-sm-9 col-md-10 main-content" style="margin-top: 5px;">

    <form method="GET" action="{{ route('client.sales-report', $client->id) }}" class="form-inline mb-3">
        <div class="row">
        <div class="col-md-2 form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="form-control mx-sm-2" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-2 form-group">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" class="form-control mx-sm-2" value="{{ request('end_date') }}">
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
        <h4>Sales Report for {{ $client->client_name }}</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Commission</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->created_at }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->commission }} </td>
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
