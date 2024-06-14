<?php

namespace App\Http\Controllers;

use Carbon\Traits\ToStringFormat;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function calculateTotalUserSales($date)
    {
        $end = Carbon::now()->toDateTimeString();

        $day = DB::table("sale_tracking")->where('day_start', $date)->first();

        if ($day->day_end) {
            $end = $day->day_end;
        }

        $sales = DB::table('payments')
            ->whereBetween('created_at', [$day->day_start, $end])
            ->where('type', 'sales')
            ->get();
      
        $sum = 0;
        foreach ($sales as $sale) {
            $sum += $sale->amount;

        }


        return array(['id' => $day->id, 'day_start' => $day->day_start, 'sale' => $sum, 'server_sales' => $day->server_sales, 'day_end' => $day->day_end]);
    }
    public function generate()
    {
        $data = DB::table('sale_tracking')->orderBy('day_start', 'desc')->get();
        $salesData = [];
        foreach ($data as $date) {
            $salesData[] = $this->calculateTotalUserSales($date->day_start);
        }

        // Check if any sales data has not been ended for the day
        $generateVisible = !$data->contains('day_end', null);

        return view('sales', compact('salesData', 'generateVisible'));
    }



    public function generateSales(Request $request)
    {
        $date = now()->toDateTimeString();
        DB::table('sales')->insert(['date' => $date, 'totalUserSales' => 0]);
        DB::table('sale_tracking')->insert(['day_start' => $date, 'server_sales' => 0]); // Initialize sale tracking for today
        return redirect()->back();
    }

    public function dayEnd(Request $request)
    {

        $dayStart = DB::table('sale_tracking')
        ->where('id', $request->id)
        ->value('day_start');
        $salesData = $this->calculateTotalUserSales($dayStart);

            $totalUserSales = $salesData[0]['sale'];


        DB::table('sale_tracking')
            ->where('id', $request->id)
            ->update([
                'server_sales' => $request->server_sale,
                'day_end' => now(),
            ]);


        DB::table('sales')
            ->where('id', $request->id)
            ->update([
                 'totalUserSales' => $totalUserSales,
            ]);



        return redirect()->route('sales');
    }
    public function filterPayments(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = Sale::query();

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        $payments = $query->paginate(10);

        $date = DB::table('sale_tracking')->select('day_start')->orderBy('day_start', 'desc')->first();

        $salesData = array();
        if ($date) {
            $date = $date->day_start;
            $sales = DB::table('payments')
                ->whereBetween('created_at', [$date, now()])
                ->get();

            $sum = 0;
            foreach ($sales as $sale) {
                $sum += $sale->amount;
            }

            $serverSales = DB::table('sale_tracking')
                ->where('day_start', $date)
                ->value('server_sales');

            $salesData[] = ['date' => $date, 'sale' => $sum, 'server_sales' => $serverSales];
        }

        return view('payment.report', compact('payments', 'salesData'));
    }

}
