<?php

namespace App\Http\Controllers;

use App\Models\Fundraising;
use Illuminate\Http\Request;
use App\Models\FundraisingPhase;
use Illuminate\Support\Facades\DB;
use App\Models\FundraisingWithdrawal;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreFundraisingPhaseRequest;

class FundraisingPhaseController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            new Middleware('permission:view fundraising_phases',['index']),
            new Middleware('permission:edit fundraising_phases',['edit','update']),
            new Middleware('permission:create fundraising_phases',['create','store']),
            new Middleware('permission:delete fundraising_phases',['destroy']),
            new Middleware('permission:show fundraising_phases',['show']),
        ];
    }

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

        return redirect()->route('admin.fundraising_withdrawals.index')->with('success','Success Created');;
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
