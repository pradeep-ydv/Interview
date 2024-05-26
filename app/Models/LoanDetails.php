<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanDetails extends Model
{
    use HasFactory;
    protected $table = 'loan_details';
    protected $primaryKey = 'clientid'; // Setting the primary key

    // Allow mass assignment for these fields
    protected $fillable = ['clientid', 'num_of_payment', 'first_payment_date', 'last_payment_date', 'loan_amount'];
}
