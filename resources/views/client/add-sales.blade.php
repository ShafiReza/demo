@extends('layouts.app')

@section('title', 'client-list')

@section('content')

    <div class="col-md-4 main" style="height: 100%;">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td colspan="2">
                        <h2 id="updatedBalanceHeader">Payment History » Updated Balance: <span id="updatedBalance">{{$client->total_balance}}</span></h2>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <!-- Display the payment history here -->
                        <iframe frameborder="0" height="300"
                            src="{{ route('payment_history', $client->id) }}" style="border: 1px solid rgb(208, 208, 208);"
                            width="900"></iframe>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        @php
                        $sum = 0;
                        foreach ($client->payments as $payments) {
                            if ($payments->type == 'sales') {
                                $sum += $payments->amount;
                            }
                        }
                        @endphp
                        <!-- Display the total sum here -->
                        <h2 id="totalSumHeader">Add Payment » Total Sum: <span id="totalSum">{{$sum}}</span></h2>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <form action="{{ route('client.add-sales', $client->id) }}" method="post" id="form"
                            name="paymentform" accept-charset="utf-8">
                            @csrf
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Amount</td>
                                        <td>
                                            <input type="text" name="amount" class="form-control" value=""
                                                style="width: 850px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>
                                            <input type="text" name="desc" class="form-control">
                                        </td>
                                    </tr>
                                    <input type="hidden" name="type" value="1">
                                    <input type="hidden" name="updated_balance" id="hiddenUpdatedBalance" value="{{ $client->total_balance }}">
                                    <tr>
                                        <td colspan="2" style="border-bottom: 1px solid rgb(221, 221, 221);"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: right;">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        document.getElementById('form').addEventListener('submit', function(event) {
            event.preventDefault();

            var amount = parseFloat(document.querySelector('input[name="amount"]').value);
            var currentBalance = parseFloat(document.getElementById('hiddenUpdatedBalance').value);
            var commissionRate = {{ $client->commission_rate }};

            if (isNaN(amount) || amount <= 0) {
                alert("Please enter a valid amount.");
                return;
            }

            var updatedBalance = currentBalance + (amount * commissionRate) - amount;
            var confirmation = confirm("You want to add sales " + amount + " and your total balance will be " + updatedBalance.toFixed(2) + ". Do you want to add this sales into your record?");

            if (confirmation) {
                document.getElementById('hiddenUpdatedBalance').value = updatedBalance.toFixed(2);
                document.getElementById('form').submit(); // submit the form
            }
        });
    </script>

@endsection
