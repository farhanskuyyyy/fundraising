<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Donatur;
use App\Models\Fundraiser;
use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\FundraisingWithdrawal;

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

    public function my_withdrawals_details(FundraisingWithdrawal $fundraisingWithdrawal)
    {
        return view('admin.my_withdrawals.details', compact('fundraisingWithdrawal'));
    }

    public function index()
    {
        $user = Auth::user();
        $fundraisingQuery = Fundraising::query();
        $fundraisingWithdrawalQuery = FundraisingWithdrawal::query();

        if ($user->hasRole('fundraiser')) {
            $fundraiser_id = $user->fundraiser->id;
            $fundraisingQuery->where('fundraiser_id', $fundraiser_id);
            $fundraisingWithdrawalQuery->where('fundraiser_id', $fundraiser_id);

            $fundraisingIds = $fundraisingQuery->pluck('id');
            $donaturs = Donatur::whereIn('fundraising_id', $fundraisingIds)->where('is_paid', true)->count();
        } else {
            $donaturs = Donatur::where('is_paid', true)->count();
        }

        $fundraisings = $fundraisingQuery->count();
        $withdrawals = $fundraisingWithdrawalQuery->count();
        $categories = Category::count();
        $fundraisers = Fundraiser::count();

        return view('dashboard', compact('fundraisingQuery', 'fundraisingWithdrawalQuery', 'donaturs', 'categories', 'fundraisers', 'withdrawals','fundraisings'));
    }
}
