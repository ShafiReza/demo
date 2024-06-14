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
     background-color: #f0f0f0; /* Light gray background for header */
 }

 .custom-table tbody tr:nth-child(even) {
     background-color: #f9f9f9; /* Alternate row background color */
 }

 .custom-table tbody tr:hover {
     background-color: #e0e0e0; /* Hover background color */
 }

 /* Adjust styles as needed */

 </style>
 <div class="row">
     <div class="col-12">
         <h2>Payment History » {{ $provider->id }}</h2>
     </div>
 </div>

 <div class="row">
     <div class="container">
         <table class="table table-striped custom-table">
             <tbody>
                 <tr>
                     <th>Money</th>
                     <th>Date</th>
                     <th>Type</th>
                     <th>Balance</th>
                     <th>Description</th>
                 </tr>
                 @if($provider->payments)
                 @foreach ($provider->payments as $payment)
                     <tr>
                         <td>{{ $payment->amount }}</td>
                         <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                         <td>{{ ucfirst($payment->type) }}</td>
                         <td>{{ $payment->updated_balance }}</td>
                         <td>{{ $payment->description }}</td>
                     </tr>
                 @endforeach

                @endif

             </tbody>
         </table>
     </div>
 </div>
