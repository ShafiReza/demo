<!-- Payment History Section -->
<style>
    /* Custom CSS to style the table */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th,
    .custom-table td {
        padding: 8px;
        text-align: left;
    }

    .custom-table th {
        background-color: #f0f0f0;
        /* Light gray background for header */
    }

    .custom-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
        /* Alternate row background color */
    }

    .custom-table tbody tr:hover {
        background-color: #e0e0e0;
        /* Hover background color */
    }

    /* Adjust styles as needed */
</style>
<div class="row">
    <div class="col-12">
        <h2>Payment History » {{ $client->id }}</h2>
    </div>
</div>

<div class="row">
    <div class="container">
        <table class="table table-striped custom-table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Money</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Balance</th>
                    <th>Description</th>
                    <th>Commission</th>
                    <th>Action</th> <!-- Add Action column for delete button -->
                </tr>
            </thead>
            <tbody>
                @if ($client->payments->isEmpty())
                    <tr>
                        <td colspan="6">No payments available.</td>
                    </tr>
                @else
                    @foreach ($client->payments as $payment)
                        @php
                            $sl = 0;
                        @endphp
                        <tr>
                            <td>{{ ++$sl }}</td>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->created_at->format('Y-m-d H:i:s') }}</td> <!-- Include date and time -->
                            <td>{{ ucfirst($payment->type) }}</td>
                            <td>{{ $payment->updated_balance }}</td>
                            <td>{{ $payment->description }}</td>
                            <td>
                                @if ($payment->type === 'sales')
                                    {{ $payment->commission }}
                                @endif
                            </td>
                            <td>
                                @if ($loop->last)
                                <form action="{{ route('payment.destroy', $payment->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
