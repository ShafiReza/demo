<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Provider;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function getTotalServerSales()
    {
        $query = "SELECT SUM(server_sales) as total_server_sales FROM sale_tracking";
        $result = DB::select($query);
        return collect($result)->first();
    }
    public function getTotalSimSales()
    {
        $query = "SELECT SUM(totalUserSales) as total_sim_sales FROM sales";
        $result = DB::select($query);
        return collect($result)->first();
    }
    public function getLastMonthTotalUserSales()
    {
        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth = now()->subMonth()->endOfMonth();
        $query = "SELECT SUM(totalUserSales) as total_user_sales FROM sales WHERE created_at BETWEEN ? AND ?";
        $result = DB::select($query, [$startOfLastMonth, $endOfLastMonth]);
        return collect($result)->first();
    }

public function getThisMonthTotalServerSales()
{
    $startOfThisMonth = now()->startOfMonth();
    $endOfThisMonth = now()->endOfMonth();
    $query = "SELECT SUM(server_sales) as total_server_sales FROM sale_tracking WHERE day_start BETWEEN ? AND ?";
    $result = DB::select($query, [$startOfThisMonth, $endOfThisMonth]);
    return collect($result)->first();
}
    public function index()
    {
        $payments=Payment::all();
        $clients = Client::all();
        $totalPaymentReceived = Provider::sum('receive');
        $totalServerSales = $this->getTotalServerSales();
        $totalSimSales = $this->getTotalSimSales();
        $totalServerSales = $this->getTotalServerSales()->total_server_sales;
        $differenceReceiveVsServerSales = $totalPaymentReceived - $totalServerSales;
        $totalSimSales = $this->getTotalSimSales()->total_sim_sales;
        $totalServerSales = $this->getTotalServerSales()->total_server_sales;
        $totalSimSales = $this->getTotalSimSales()->total_sim_sales;

        $differenceServerVsSimSales = $totalServerSales - $totalSimSales;



        $thisMonthPaymentReceive = Provider::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('receive');
        $thisMonthTotalServerSales = $this->getThisMonthTotalServerSales();
        $lastMonthForwardingPayment = Payment::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->sum('amount');
        $lastMonthTotalUserSales = $this->getLastMonthTotalUserSales();

        return view('dashboard', compact(
            'payments',
            'clients',
            'totalPaymentReceived',
            'totalServerSales',
            'totalSimSales',
            'differenceReceiveVsServerSales',
            'differenceServerVsSimSales',
            'thisMonthPaymentReceive',
            'thisMonthTotalServerSales',
            'lastMonthForwardingPayment',
            'lastMonthTotalUserSales'
        ));
    }
    public function second()
    {
        // Fetch data for the second table
        $thisMonthPaymentReceive = Provider::sum('receive');
        $thisMonthTotalServerSales = Sale::whereMonth('created_at', now()->month)->where('type', 'server')->sum('amount');
        $lastMonthForwardingPayment = Provider::sum('total_payment');
        $lastMonthTotalUserSales = Sale::whereMonth('created_at', now()->subMonth()->month)->sum('amount');

        // Pass data to the view
        return view('dashboard', compact('thisMonthPaymentReceive', 'thisMonthTotalServerSales', 'lastMonthForwardingPayment', 'lastMonthTotalUserSales'));
    }
    public function getSales()
    {
        $sales = Client::with('type')->get(['type', 'sales', 'commission_rate']);
        return response()->json($sales);
    }
}
