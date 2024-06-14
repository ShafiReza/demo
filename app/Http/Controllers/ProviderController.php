<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;
use App\Models\ProviderPayment;
use App\Models\Transfer;
use App\Models\Payment;
use Carbon\Carbon;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::all();
        $firstProviderId = $providers->isEmpty() ? null : $providers->first()->id;
        return view('provider.index', compact('providers', 'firstProviderId'));
    }

    public function create()
    {
        $provider = Provider::all();

        return view('provider.create', compact('provider'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'provider_name' => 'required|string|unique:providers',
            'provider_type' => 'required|string',
            'opening_balance' => 'required|numeric',
            'note' => 'nullable|string',
            'active' => 'boolean',
        ]);
        // $duplicate = Provider::where('provider_name', $request->provider_name)
        //     ->where('provider_type', $request->provider_type)
        //     ->where('id', '!=', $request->id) // Ignore the current ID if it's an update
        //     ->first();

        // if ($duplicate) {
        //     return redirect()->back()->withErrors(['duplicate' => 'Provider with the same name and type already exists.']);
        // }

        // Create a new provider instance
        $provider = new Provider($validatedData);
        // $provider = $request->id ? Provider::find($request->id) : new Provider();
        $provider->provider_name = $request->provider_name;
        $provider->provider_type = $request->provider_type;
        $provider->opening_balance = $request->opening_balance;
        $provider->total_balance = $request->opening_balance; // Assuming total balance starts with opening balance
        $provider->note = $request->note;
        $provider->active = $request->has('active');

        // Save the provider
        $provider->save();

        return redirect()->route('provider.index')->with('success', 'Provider created successfully');
    }


    public function showReport()
    {

        $providers = Provider::all();




        return view('provider.report', compact('providers'));
    }


    public function showReceiveReport(Request $request, $id)
    {

        $provider = Provider::findOrFail($id);
        $payments = $provider->payments()->where('type', 'received')->get();



        return view('provider.receive-report', compact('provider', 'payments', 'id'));
    }
    public function showTransferReport($id)
    {


        $transfers = Transfer::with(['fromProvider', 'toProvider'])->get();
        return view('provider.transfer-report', compact('transfers'));
    }
    public function toggleStatus($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->active = !$provider->active;
        $provider->save();
        return back();
    }
    public function showPaymentPage($id)
    {
        $provider = Provider::findOrFail($id);
        return view('provider.payment', compact('provider'));
    }

    public function receivePaymentForm($id)
    {
        $provider = Provider::find($id);
        return view('provider.receive-payment', compact('provider'));
    }

    public function receivePayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'desc' => 'nullable|string',
        ]);

        // Find the provider
        $provider = Provider::findOrFail($id);

        // Create a new payment
        $payment = new ProviderPayment();
        $payment->provider_id = $id;
        $payment->amount = $request->amount;
        $payment->description = $request->desc;
        $payment->type = 'received';
        $payment->updated_balance = $provider->total_balance + $request->amount;
        $payment->save();

        $provider->receive = $provider->receive + $request->amount;
        $provider->total_balance = $provider->total_balance + $request->amount;
        $provider->save();

        // Flash message
        session()->flash('message', 'Payment received successfully!');

        // Redirect to the index page or any other appropriate page
        return redirect()->route('provider.index');
    }

    public function showTransferPage()
    {
        $provider = Provider::all();
        return view('provider.transfer', compact('provider'));
    }

    public function paymentHistory($id)
    {
        $provider = Provider::find($id);
        // dd($provider->payments);
        return view('provider.payment_history', compact('provider'));
    }
    public function transferFunds(Request $request)
    {
        // Validate the request
        $request->validate([
            'from_provider' => 'required|exists:providers,id',
            'transfer_amount' => 'required|numeric|min:0',
            'to_provider' => 'required|exists:providers,id',
            'note' => 'nullable|string',
        ]);
        if ($request->from_provider == $request->to_provider) {
            return redirect()->back()->with('error', 'You cannot transfer balance to your own account.');
        }
        Transfer::create([
            'from_provider' => $request->from_provider,
            'transfer_amount' => $request->transfer_amount,
            'to_provider' => $request->to_provider,
            'note' => $request->note,
        ]);

        $from_provider = Provider::findOrFail($request->from_provider);
        $to_provider = Provider::findOrFail($request->to_provider);

        // // Transfer funds
        $transfer_amount = $request->transfer_amount;
        $from_provider->total_balance -= $transfer_amount;
        $to_provider->total_balance += $transfer_amount;
        $from_provider->save();
        $to_provider->save();

        // Optionally, you can create a transaction record for auditing purposes

        // Redirect back with success message
        return redirect()->route('provider.index')->with('success', 'Funds transferred successfully.');
    }
    public function destroy($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();

        return redirect()->route('provider.index')->with('success', 'Provider deleted successfully.');
    }
    public function filter(Request $request)
    {
        $rows = $request->input('rows', 50);
        $providerName = $request->input('provider_name');
        $providerType = $request->input('provider_type');
        $status = $request->input('status');

        $query = Provider::query();

        if ($providerName) {
            $query->where('provider_name', 'like', '%' . $providerName . '%');
        }

        if ($providerType) {
            $query->orWhere('provider_type', 'like', '%' . $providerType . '%');
        }
        if ($status) {
            $query->where('active', $status === 'active' ? 1 : 0);  // Filter based on status
        }

        $providers = $query->paginate($rows);

        // Get the first provider ID if available
        $firstProviderId = $providers->first() ? $providers->first()->id : null;

        return view('provider.index', compact('providers', 'firstProviderId'));
    }
}
