<?php

namespace App\Http\Controllers;

use App\Models\Fundraising;
use Illuminate\Http\Request;
use App\Models\FundraisingPhase;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreFundraisingPhaseRequest;
use App\Models\FundraisingWithdrawal;

class FundraisingPhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundraisingPhaseRequest $request, Fundraising $fundraising)
    {
        DB::transaction(function () use ($request, $fundraising) {
            $validated = $request->validated();
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
                $validated['photo'] = $photoPath;
            }
            $validated['fundraising_id'] = $fundraising->id;

            $fundraisingPhase = FundraisingPhase::create($validated);

            $withdrawalToUpdate = FundraisingWithdrawal::where('fundraising_id', $fundraising->id)->latest()->first();
            $withdrawalToUpdate->update([
                'has_received' => true
            ]);

            $fundraising->update([
                'has_finished' => true
            ]);
        });

        return redirect()->route('admin.my_withdrawals');
    }

    /**
     * Display the specified resource.
     */
    public function show(FundraisingPhase $fundraisingPhase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FundraisingPhase $fundraisingPhase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FundraisingPhase $fundraisingPhase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FundraisingPhase $fundraisingPhase)
    {
        //
    }
}
