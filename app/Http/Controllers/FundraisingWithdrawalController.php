<?php

namespace App\Http\Controllers;

use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\FundraisingWithdrawal;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreFundraisingWithdrawalRequest;
use App\Http\Requests\UpdateFundraisingWithdrawalRequest;

class FundraisingWithdrawalController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view fundraising_withdrawals', ['index']),
            new Middleware('permission:edit fundraising_withdrawals', ['edit', 'update']),
            new Middleware('permission:create fundraising_withdrawals', ['create', 'store']),
            new Middleware('permission:delete fundraising_withdrawals', ['destroy']),
            new Middleware('permission:show fundraising_withdrawals', ['show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->can('approve fundraising_withdrawals')) {
            $withdrawals = FundraisingWithdrawal::with('fundraising')->orderByDesc('id')->get();
        } else {
            $withdrawals = FundraisingWithdrawal::with('fundraising')->where('fundraiser_id', $user->fundraiser->id)->orderByDesc('id')->get();
        }
        return view('admin.fundraising_withdrawals.index', compact('withdrawals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->can('approve fundraising_withdrawals')) {
            $fundraisings = Fundraising::where('is_active', 1)
                ->where('has_finished', 0)
                ->orderByDesc('id')
                ->get();
        } else {
            $fundraisings = Fundraising::where('fundraiser_id', $user->fundraiser->id)
                ->where('is_active', 1)
                ->where('has_finished', 0)
                ->orderByDesc('id')
                ->get();
        }
        return view('admin.fundraising_withdrawals.create', compact('fundraisings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundraisingWithdrawalRequest $request)
    {
        $fundraising = Fundraising::find($request->fundraising_id);
        if ($fundraising == null) {
            return redirect()->back()->with('error', 'Fundraising Not Found');
        }

        if ($fundraising->withdrawals()->exists()) {
            return redirect()->back()->with('error', 'Fundraising Already Request');
        }

        if ($fundraising->totalReachedAmount() < $fundraising->target_amount) {
            return redirect()->back()->with('error', 'Fundraising not reached');
        }

        DB::transaction(function () use ($request, $fundraising) {
            $validated = $request->validated();

            $validated['fundraiser_id'] = Auth::user()->fundraiser->id;
            $validated['has_received'] = false;
            $validated['has_sent'] = false;
            $validated['amount_requested'] = $fundraising->totalReachedAmount();
            $validated['amount_received'] = 0;
            $validated['proof'] = '';

            $fundraising->withdrawals()->create($validated);
        });

        return redirect()->route('admin.fundraising_withdrawals.index')->with('success', 'Success Created');;
    }

    /**
     * Display the specified resource.
     */
    public function show(FundraisingWithdrawal $fundraisingWithdrawal)
    {
        return view('admin.fundraising_withdrawals.show', compact('fundraisingWithdrawal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FundraisingWithdrawal $fundraisingWithdrawal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundraisingWithdrawalRequest $request, FundraisingWithdrawal $fundraisingWithdrawal)
    {
        DB::transaction(function () use ($request, $fundraisingWithdrawal) {
            $validated = $request->validated();
            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }

            $validated['has_sent'] = 1;

            $fundraisingWithdrawal->update($validated);
        });

        return redirect()->route('admin.fundraising_withdrawals.show', ['fundraising_withdrawal' => $fundraisingWithdrawal])->with('success', 'Success Updated');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FundraisingWithdrawal $fundraisingWithdrawal)
    {
        //
    }
}
