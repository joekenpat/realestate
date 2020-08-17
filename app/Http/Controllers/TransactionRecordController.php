<?php

namespace App\Http\Controllers;

use App\TransactionRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionRecordController extends Controller
{
  public function user_index(Request $request)
  {
    return view('transaction.index');
  }
}
