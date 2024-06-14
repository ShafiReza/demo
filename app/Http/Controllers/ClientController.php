<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Provider;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('client.index', compact('clients'));
    }

    public function create()
    {

        $providers = Provider::all();
        return view('client.create', compact('providers'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'client_name' => 'required|string',
            'provider_id' => 'required|string',
            'commission_rate' => 'required|numeric',
            'type' => 'required|string',
            'opening_balance' => 'required|numeric',
            'note' => 'nullable|string',
            'active' => 'boolean',
        ]);
        $duplicate = Client::where('client_name', $request->client_name)->first();

        if ($duplicate) {
            return redirect()->back()->withErrors(['duplicate' => 'Client with the same name and provider already exists.']);
        }


        //dd($request->all());
        // Create a new client instance
    
        $client = new Client($validatedData);
        //$provider = new Provider();
        $client->client_name = $request->client_name;
        //$provider ->provider_name = $request->provider_name;
        $client->type = $request->type;
        $client->commission_rate = $request->commission_rate;
        $client->opening_balance = $request->opening_balance;
        $client->total_balance = $request->opening_balance;
        $client->note = $request->note;
        $client->active = $request->has('active');
        $client->provider_id = $request->provider_id;
        // Save the client
        $client->save();

        return redirect()->route('client.index')->with('success', 'Client created successfully');
    }

    public function show($id)
    {

        $clients = Client::with('provider')->find($id);
        $payments = [];
        return view('client.show', compact('clients', 'payments'));
    }
    public function receivePaymentform($id)
    {
        $client = Client::find($id);
        return view('client.receive-payment', compact('client'));
    }

    // YourController.php


    public function showReceiveReport(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $query = Payment::where('client_id', $id)->where('type', 'credit');

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        $payments = $query->get();

        return view('client.receive-report', compact('client', 'payments'));
    }

    public function showSalesReport(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $query = Payment::where('client_id', $id)->where('type', 'sales');

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        $payments = $query->get();

        return view('client.sales-report', compact('client', 'payments'));
    }


    public function generateReport($id)
    {
        $client = Client::findOrFail($id);
        $provider = $client->provider;

        $payments = $client->payments()->get();
        $totalReceive = $payments->where('type', 'receive')->sum('amount');
        $totalSales = $payments->where('type', 'sales')->sum('amount');
        $totalBalance = $client->total_balance;

        return view('client.generate-report', compact('client', 'provider', 'payments', 'totalReceive', 'totalSales', 'totalBalance'));
    }


    public function receivePayment(Request $request, $client_id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'desc' => 'nullable|string',
        ]);

        // Find the client
        $client = Client::findOrFail($client_id);
        $commission = $request->amount * $client->commission_rate;
        // Create a new payment
        $payment = new Payment();
        $payment->client_id = $client_id;
        $payment->amount = $request->amount;
        $payment->description = $request->desc;
        $payment->type = 'credit';
        $payment->commission_rate = $client->commission_rate;
        $payment->commission = $commission;
        $payment->updated_balance = $client->total_balance + $request->amount;
        $payment->save();

        // Update client's balance
        $client->receive = $client->receive + $request->amount;
        $client->total_balance = $client->total_balance + $request->amount;
        $client->save();

        // Update provider's balance
        $provider = $client->provider;
        $provider->total_balance -= $request->amount;
        $provider->save();

        // Flash message
        session()->flash('message', 'Payment received successfully!');

        // Redirect to the index page
        return redirect()->route('client.index');
    }
    public function addSalesPage($id)
    {
        $client = Client::find($id);
        return view('client.add-sales', compact('client'));
    }

    public function addSales(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric',
            'desc' => 'nullable|string',
        ]);

        // Find the client
        $client = Client::findOrFail($id);
        $provider = $client->provider;
        // Calculate the commission based on the client's current commission rate
        $commission = $request->amount * $client->commission_rate;

        // Calculate the new total balance
        $newTotalBalance = $client->total_balance + $commission - $request->amount;

        // Create a new payment
        $payment = new Payment();
        $payment->client_id = $id;
        $payment->provider_id = $provider->id;
        $payment->amount = $request->input('amount');
        $payment->description = $request->input('desc');
        $payment->type = 'sales';
        $payment->commission_rate = $client->commission_rate; // Store the current commission rate
        $payment->commission = $commission; // Store the calculated commission
        $payment->updated_balance = $newTotalBalance; // Correctly assign the new total balance
        $payment->save();

        // Update the client's balance
        $client->sales += $request->amount;
        $client->total_balance = $newTotalBalance; // Correctly assign the new total balance
        $client->save();

        // Flash message
        session()->flash('message', 'Sales added successfully!');

        // Redirect to the index page
        return redirect()->route('client.index');
    }




    public function paymentHistory($id)
    {
        $client = Client::find($id);
        return view('client.payment_history', compact('client'));
    }
    public function edit($id)
    {
        $client = Client::find($id);
        $providers = Provider::all();
        if (!$client) {
            return redirect()->back()->with('error', 'Client not found.');
        }
        return view('client.edit', compact('client', 'providers'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return redirect()->back()->with('error', 'Client not found.');
        }

        // Validate the request data
        $validatedData = $request->validate([
            'client_name' => 'required|string|max:255',
            'provider_id' => 'required|exists:providers,id',
            'commission_rate' => 'required|numeric',
            'type' => 'required|string|max:255',
            'note' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        // Update the client with the validated data
        $client->client_name = $validatedData['client_name'];
        $client->provider_id = $validatedData['provider_id'];
        $client->type = $validatedData['type'];
        $client->commission_rate = $validatedData['commission_rate'];
        $client->note = $validatedData['note'];
        $client->active = $validatedData['active'] ?? false;

        $client->save();

        return redirect()->route('client.index')->with('success', 'Client updated successfully.');
    }

    public function toggleStatus($id)
    {
        $client = Client::findOrFail($id);
        $client->active = !$client->active;
        $client->save();

        return redirect()->route('client.index');
    }

    public function filter(Request $request)
    {
        $rows = $request->input('rows', 50);
        $clients = $request->input('client_name');
        $productType = $request->input('type');
        $status = $request->input('status');
        $query = Client::query();

        if ($clients) {
            $query->where('client_name', 'like', '%' . $clients . '%');
        }

        if ($productType) {
            $query->orWhere('type', 'like', '%' . $productType . '%');
        }
        if ($status) {
            $query->where('active', $status === 'active' ? 1 : 0);  // Filter based on status
        }

        // Pagination should use the filtered query result
        $clients = $query->paginate(10);

        return view('client.index', compact('clients'));
    }


    public function Users()
    {
        // Fetch clients from the database
        $clients = Client::all();

        // Pass clients data to the view
        return view('.view', compact('clients'));
    }
}
