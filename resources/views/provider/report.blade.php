@extends('layouts.app', ['id' => $provider->id])

@section('title', ' Report')

@section('content')

    <div class="col-sm-9 col-md-10 main-content" style="margin-top: 5px;">

        <form action="{{ route('provider.report') }}" method="GET" class="form-inline mb-3">
            <div class="row">

                <div class="col-md-2 form-group">
                    <label></label><br />
                    <button class="btn btn-primary" onclick="printContent()">
                        <span class="fas fa-print"></span> Print
                    </button>
                </div>

            </div>
        </form>
        <div class="prnt" id="prnt">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Provider </th>
                        <th>Provider Type</th>
                        <th>Opening Balance</th>
                        <th>Receive</th>
                        <th>Total Balance</th>
                        <th class="no-print"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($providers as $provider)
                        <tr>
                            <td>{{ $provider->id }}</td>
                            <td>{{ $provider->provider_name }}</td>
                            <td>{{ $provider->provider_type }}</td>
                            <td>{{ $provider->opening_balance }}</td>
                            <td>{{ $provider->receive }}</td>
                            <td>{{ $provider->total_balance }}</td>
                            <td class="no-print">
                                <form action="{{ route('provider.destroy', $provider->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this provider?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="color: blue;">
                        <th colspan="2"></th>
                        <th>Total Receive</th>
                        <th style="color: green;">Total Balance</th>
                        <th colspan=""></th>
                    </tr>
                    <tr style="color: blue;">
                        <td colspan="2"></td>
                        <td>{{$totalReceive = $providers->sum('receive');}}</td>
                        <td style="color: green;">
                            {{$totalBalance = $providers->sum('total_balance');}}
                        </td>


                        <td colspan=""></td>
                    </tr>
                </tfoot>
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
             <style>
                @media print {
                    .no-print {
                        display: none !important;
                    }
                    body {
                        font-size: 7pt;
                    }
                }
            </style>
        </div>
    </div>
@endsection
