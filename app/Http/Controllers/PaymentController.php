<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
class PaymentController extends Controller
{
    public function paymentReceive()
    {
        // Fetch clients
        //$clients = Client::all();
        $payments = Payment::all();
        $clients = Client::all();
        $payments = Payment::orderBy('created_at', 'desc')->get();

        // Generate report generation time
        $reportGenerationTime = Carbon::now();

        // Pass data to view
        return view('payment.payment_receive', compact('payments','clients', 'reportGenerationTime'));
    }

    public function report()
    {
    // Fetch payments

    $payments = Payment::all();

    // Generate report generation time
    $reportGenerationTime = Carbon::now();

    // Pass data to view
    return view('payment.report', compact('payments','reportGenerationTime'));
    }

    public function destroy($id)
    {
        // Find the payment record
        $payment = Payment::findOrFail($id);

        // Get the client associated with the payment
        $client = $payment->client;
        $provider = $client->provider;

        // If the payment type is 'credit' (receive), add the amount back to the provider's total balance
        if ($payment->type === 'credit') {
            $provider->total_balance += $payment->amount;
            $provider->save();
        }

        // Get the previous payment record
        $previousPayment = $client->payments()->where('id', '<', $payment->id)->latest()->first();

        // Delete the payment record
        $payment->delete();

        // Update receive and sales based on the previous record or set to 0 if no previous record
        $client->receive = $previousPayment ? $client->payments()->where('type', 'credit')->sum('amount') : 0;
        $client->sales = $previousPayment ? $client->payments()->where('type', 'sales')->sum('amount') : 0;

        // Calculate total balance based on the previous record or set to opening balance if no previous record
        $client->total_balance = $previousPayment ? $previousPayment->updated_balance : $client->opening_balance;

        // Save the updated client record
        $client->save();

        // Redirect back or return response
        return redirect()->back()->with('success', 'Payment deleted successfully.');
    }


public function filterPayments(Request $request)
{
    $from = $request->input('from');
    $to = $request->input('to');
    $clientName = $request->input('client_name');
    $providerName = $request->input('provider_name');
    $type = $request->input('type');

    $query  = Payment::query();

    // Filter by date range
    if ($from) {
        $query->whereDate('created_at', '>=', $from);
    }

    if ($to) {
        $query->whereDate('created_at', '<=', $to);
    }

    // Join and filter by client name
    if ($clientName) {
        $query->whereHas('client', function($q) use ($clientName) {
            $q->where('client_name', 'like', "%{$clientName}%");
        });
    }

    // Join and filter by provider name
    if ($providerName) {
        $query->whereHas('provider', function($q) use ($providerName) {
            $q->where('provider_name', 'like', "%{$providerName}%");
        });
    }

    // Filter by payment type
    if ($type) {
        $query->where('type', $type);
    }

    $payments = $query->paginate(10);

    return view('payment.payment_receive', compact('payments'));
}


}
