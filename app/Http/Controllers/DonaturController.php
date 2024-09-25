<?php

namespace App\Http\Controllers;

use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DonaturController extends Controller implements HasMiddleware
{
    public static function middleware(): array {
        return [
            new Middleware('permission:view donaturs',['index']),
            new Middleware('permission:edit donaturs',['edit','update']),
            new Middleware('permission:create donaturs',['create','store']),
            new Middleware('permission:destroy donaturs',['destroy']),
            new Middleware('permission:show donaturs',['show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donaturs = Donatur::with('fundraising')->orderByDesc('id')->paginate(5);
        return view('admin.donaturs.index',compact('donaturs'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Donatur $donatur)
    {
        return view('admin.donaturs.show',compact('donatur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donatur $donatur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Donatur $donatur)
    {
        DB::transaction(function () use ($donatur) {
            $donatur->update([
                'is_paid' => true
            ]);
        });

        return redirect()->route('admin.donaturs.show',$donatur);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donatur $donatur)
    {
        //
    }
}
