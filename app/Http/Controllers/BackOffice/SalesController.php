<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    // Add Sales
    public function AddSales()
    {
        return view('backoffice.sales.add_sales');
    }
}
