<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\User;
use App\Http\Controllers\Controller;
Use Image;
use Illuminate\support\Facades\Auth;

class ReportController extends Controller
{
    public function getAccountsReport($id)
    {
        $id = decrypt($id);
        $data = Account::where('user_id',$id)->get();
        $user = User::where('id',$id)->first();
        return view('admin.report.account', compact('data','user','id'));
    }
}
