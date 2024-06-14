@extends('layouts.app')

@section('title', 'Provider Payment History')

@section('content')

<div class="col-md-4 main" style="height: 100%;">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td colspan="2">
                    <!-- Display the updated balance here -->
                    <h2 id="updatedBalanceHeader">Payment History » Updated Balance: <span id="updatedBalance">{{$provider->total_balance}}</span></h2>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <!-- Display the payment history here -->
                    <iframe frameborder="0" height="300" src="{{ route('provider.payment-history', $provider->id) }}" style="border: 1px solid rgb(208, 208, 208);" width="900"></iframe>

                </td>
            </tr>
            <tr>
                <td colspan="2">
                    @php
                    $sum = 0;
                    if ($provider->payments) {
                        foreach ($provider->payments as $payment) {
                            if ($payment->type == 'credit') {
                                $sum += $payment->amount;
                            }
                        }
                    }
                    @endphp

                    <!-- Display the total sum here -->
                    <h2 id="totalSumHeader">Add Payment » Total Sum: <span id="totalSum">{{$sum}}</span></h2>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <form action="{{ route('provider.receive-payment', $provider->id) }}" method="post" id="form" name="paymentform" accept-charset="utf-8">
                        @csrf
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Amount</td>
                                    <td>
                                        <input type="text" name="amount" class="form-control" value="" style="width: 850px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>
                                        <input type="text" name="desc" class="form-control">
                                    </td>
                                </tr>
                                <input type="hidden" name="type" value="1">
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

@endsection
