<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanDetails;


class LoanDetailsController extends Controller
{
    public function index()
    {
        $loanDetails = LoanDetails::all();
        return view('backend.EMIDetails.loan', compact('loanDetails'));
    }
}
