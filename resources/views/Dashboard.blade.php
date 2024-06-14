@extends('layouts.app')

@section('title', 'Dashboard')


@section('content')
    <div class="col-md-9 main" style="height: 100%;">
        <h2 class="sub-header">Welcome</h2>
        <p>PMS</p>

        <div class="row mt-3">
            <div class="col-md-4 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">First Table</h3>
                    </div>
                    <div class="card-body">
                        <table class="table sales-table">
                            <thead>
                                <tr>
                                    <th>Topic</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total Payment Received</td>
                                    <td>{{ $totalPaymentReceived }}</td>
                                </tr>
                                <tr>
                                    <td>Total Server Sales</td>
                                    <td>{{ $totalServerSales }}</td>
                                </tr>
                                <tr>
                                    <td>Total Sim Sales</td>
                                    <td>{{ $totalSimSales }}</td>
                                </tr>
                                <tr>
                                    <td>Difference Receive vs Server Sales</td>
                                    <td>{{ $differenceReceiveVsServerSales }}</td>
                                </tr>
                                <tr>
                                    <td>Difference Server Sales vs Sim Sales</td>
                                    <td>{{ $differenceServerVsSimSales }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Second Table</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Topic</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>This month payment receive</td>
                                    <td>{{ $thisMonthPaymentReceive }}</td>
                                </tr>
                                <tr>
                                    <td>This month total server sales</td>
                                    <td>{{ $thisMonthTotalServerSales->total_server_sales }}</td>
                                </tr>
                                <tr>
                                    <td>Last Month Forwarding payment</td>
                                    <td>{{ $lastMonthForwardingPayment }}</td>
                                </tr>
                                <tr>
                                    <td>Last Month Forwarding Sim balance</td>
                                    <td>{{ $lastMonthTotalUserSales->total_user_sales }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-3">
            <div class="col-md-7 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sales Information</h3>
                        <a href="{{ route('sales') }}" class="float-right"><i class="glyphicon glyphicon-refresh"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table sales-table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Sales</th>
                                    <th>Commission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalCommission = 0; // Initialize total commission outside the loop
                                @endphp

                                @foreach ($clients as $client)
                                    <tr>
                                        <td>{{ $client->type }}</td>
                                        <td>{{ $client->sales }}</td>
                                        @php
                                            // Calculate commission for this client
                                            $commission = $payments
                                                ->where('client_id', $client->id)
                                                ->where('type', 'sales')
                                                ->sum('commission');
                                            $totalCommission += $commission; // Update total commission
                                        @endphp
                                        <td>{{ $commission }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
        <!-- Second card content -->

    </div>

    </div>


@endsection
