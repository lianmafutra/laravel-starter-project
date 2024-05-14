<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpgradeAccountController extends Controller
{
    public function index(){
      return view('app.account.upgrade-account-index');
    }
}
