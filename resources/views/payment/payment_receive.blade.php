@extends('layouts.app')

@section('title', 'client-list')

@section('content')

    <div class="col-sm-9 col-md-10 main-content" style="margin-top: 5px;">

        <div class="top10">

            <form action="{{ route('payments.filterPayments') }}" class="form-inline filter" role="form" method="post"
                accept-charset="utf-8">
                @csrf
                <!-- Form content -->
                <input type="hidden" name="uri" value="" />
                <div class="row">
                    <div class="col-md-1 form-group">
                        <label for="rows">Show</label>
                        <select class="form-control input-xs" name="rows" onchange="updatePerPage(this)">
                            <option>10</option>
                            <option selected="">50</option>
                            <option>100</option>
                            <option>150</option>
                            <option>200</option>
                            <option>400</option>
                            <option>500</option>
                        </select>
                    </div>


                    <div class="col-md-2 form-group">
                        <label for="date1">Date From</label>
                        <input type="date" class="form-control input-xs datepicker" name="from" id="date1"
                            placeholder="Date From" size="18" value="{{ old('from') }}" />
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="date2">Date To</label>
                        <input type="date" class="form-control input-xs datepicker" name="to" id="date2"
                            placeholder="Date To" size="18" value="{{ old('to') }}" />
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="client_name">Client Name:</label>
                        <input type="text" id="client_name" name="client_name" class="form-control" value="{{ request('client_name') }}">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="provider_name">Provider Name:</label>
                        <input type="text" id="provider_name" name="provider_name" class="form-control" value="{{ request('provider_name') }}">
                    </div>
                    <div class="col-md-1 form-group">
                        <label for="type">Type:</label>
                        <select id="type" name="type" class="form-control">
                            <option value="">All</option>
                            <option value="sales" {{ request('type') == 'sales' ? 'selected' : '' }}>Sales</option>
                            <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Credit</option>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="exampleInputPassword2"></label><br />
                        <button type="submit" class="btn btn-danger btn-md" onclick="filterPayments()">
                            <span class="glyphicon glyphicon-search"></span>
                            Filter
                        </button>
                        <button class="btn btn-primary" onclick="printContent()">
                            <span class="fas fa-print"></span> Print
                        </button>

                    </div>
                </div>
            </form>


            <div class="prnt" id="prnt">
                <table class="table table-striped table-hover">
                    <thead class="hidden-print">
                        <tr>
                            <th>SL</th>
                            <th>Time</th>
                            <th>Client Name</th>
                            <th>Provider Name</th>
                            <th>Note</th>
                            <th>Payment Type</th>
                            <th>Amount</th>
                            <th>Commission</th>
                            <th>Balance</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $sl = 0;
                        @endphp
                        @foreach ($payments as $payment)
                            <tr>
                                <td>{{ ++$sl }}</td>
                                <td>{{ $payment->created_at }}</td>
                                <td>{{ $payment->client->client_name }}</td>
                                <td>{{ $payment->client->provider->provider_name }}</td>
                                <td>{{ $payment->description }}</td>
                                <td>{{ $payment->type }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>
                                    @if ($payment->type === 'sales')
                                        {{ $payment->commission }}
                                    @endif
                                </td>
                                <td>{{ $payment->updated_balance }}</td>
                                <td>
                                    <style>
                                        @media print {
                                            .no-print {
                                                display: none !important;
                                                font-size: 1px;
                                            }
                                        }
                                    </style>
                                    <div class="no-print">
                                        <form action="{{ route('payment.destroy', $payment->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this provider?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach



                    </tbody>
                    <tfoot>
                        <tr style="color: blue;">
                            <th colspan="4"></th>
                            <th>Total Credit</th>
                            <th>Total Sales</th>
                            <th>Total Commission</th>
                            <th style="color: green;">Total Balance</th>
                            <th colspan=""></th>
                        </tr>
                        <tr style="color: blue;">
                            <td colspan="4"></td>
                            <td>{{ $totalCredit = $payments->where('type', 'credit')->sum('amount') }}</td>

                            <td>{{ $totalPaid = $payments->where('type', 'sales')->sum('amount') }}</td>
                            <td>{{$totalCommission = $payments->where('type', 'sales')->sum('commission');}}</td>
                            <td style="color: green;">
                                @php
                                    // Get the last payment and retrieve its updated balance
                                    $totalBalance = $payments->last()->updated_balance ?? 0;
                                @endphp
                                {{ $totalBalance }}
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

            </div>
        </div>

    @endsection
