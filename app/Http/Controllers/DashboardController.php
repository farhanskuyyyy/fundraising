<?php

namespace App\Http\Controllers;

use App\Models\Fundraiser;
use App\Models\FundraisingWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function apply_fundraiser()
    {
        $user = Auth::user();
        DB::transaction(function () use ($user) {
            $validate['user_id'] = $user->id;
            $validate['is_active'] = false;

            Fundraiser::create($validate);
        });

        return redirect()->route('admin.fundraisers.index');
    }

    public function my_withdrawals()
    {
        $user = Auth::user();
        $withdrawals = FundraisingWithdrawal::with('fundraising')->where('fundraiser_id', $user->fundraiser->id)->get();
        return view('admin.my_withdrawals.index', compact('withdrawals'));
    }

    public function my_withdrawals_details(FundraisingWithdrawal $withdrawal)
    {
        return view('admin.my_withdrawals.details', compact('withdrawal'));
    }
}
