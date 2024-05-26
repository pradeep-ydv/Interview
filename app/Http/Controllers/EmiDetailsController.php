<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class EmiDetailsController extends Controller
{
    public function index()
    {
        return view('backend.EMIDetails.index');
    }

    public function processData()
    {
        // Drop the table if it exists
        DB::statement('DROP TABLE IF EXISTS emi_details');

        // Get range of dates
        $minDate = DB::table('loan_details')->min('first_payment_date');
        $maxDate = DB::table('loan_details')->max('last_payment_date');

        // Prepare months for columns
        $start = Carbon::parse($minDate);
        $end = Carbon::parse($maxDate);
        $months = [];

        while ($start->lte($end)) {
            $months[] = $start->format('Y_M');
            $start->addMonth();
        }

        // Create table with dynamic columns
        $columns = '`clientid` INT, ' . implode(' DECIMAL(10,2) DEFAULT 0, ', $months) . ' DECIMAL(10,2) DEFAULT 0';
        DB::statement("CREATE TABLE emi_details ($columns)");

        // Process each loan to insert into the table
        $loans = DB::table('loan_details')->get();

        foreach ($loans as $loan) {
            $emi = round($loan->loan_amount / $loan->num_of_payment, 2);
            $insertQuery = 'INSERT INTO emi_details (`clientid`, ' . implode(', ', $months) . ') VALUES (?, ';

            $payments = [];
            $current = Carbon::parse($loan->first_payment_date);
            $last = Carbon::parse($loan->last_payment_date);
            foreach ($months as $month) {
                $payments[] = ($current->format('Y_M') === $month && $current->lte($last)) ? $emi : 0;
                $current->addMonth();
            }

            // Adjust the last installment to make sure the sum matches exactly the loan amount
            $totalPaid = array_sum($payments);
            if ($totalPaid != $loan->loan_amount) {
                $payments[count($payments) - 1] += ($loan->loan_amount - $totalPaid);
            }

            $insertQuery .= implode(', ', array_fill(0, count($months), '?')) . ')';
            DB::insert($insertQuery, array_merge([$loan->clientid], $payments));
        }

        return redirect()->route('emi_details.show');
    }

    public function show()
    {
        $emiDetails = DB::select('SELECT * FROM emi_details');
        return view('backend.EMIDetails.show', compact('emiDetails'));
    }
}
