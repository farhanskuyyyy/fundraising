<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Donatur;
use App\Models\Category;
use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\StoreDonationRequest;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $fundraisings = Fundraising::with(['category', 'fundraiser'])
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->get();
        return view('front.views.index', compact('fundraisings', 'categories'));
    }

    public function category(Category $category)
    {
        return view('front.views.category', compact('category'));
    }

    public function details(Fundraising $fundraising)
    {
        $goalReached = $fundraising->totalReachedAmount() >= $fundraising->target_amount;
        return view('front.views.details', compact('fundraising', 'goalReached'));
    }

    public function support(Fundraising $fundraising)
    {
        return view('front.views.support', compact('fundraising'));
    }

    public function checkout(Fundraising $fundraising, $totalAmountDonation)
    {
        return view('front.views.checkout', compact('fundraising', 'totalAmountDonation'));
    }

    public function store(StoreDonationRequest $request, Fundraising $fundraising, $totalAmountDonation)
    {
        try {
            try {
                DB::beginTransaction();
                $validated = $request->validated();
                if ($request->hasFile('proof')) {
                    $proofPath = $request->file('proof')->store('proofs', 'public');
                    $validated['proof'] = $proofPath;
                }

                $validated['fundraising_id'] = $fundraising->id;
                $validated['total_amount'] = $totalAmountDonation;
                $validated['is_paid'] = false;

                $donatur = Donatur::create($validated);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                throw new Exception("Failed");
            }
            return redirect()->route('front.success', ['donatur_id' => Crypt::encryptString($donatur->id)]);
        } catch (\Throwable $th) {
            return view('front.views.checkout', compact('fundraising', 'totalAmountDonation'));
        }
    }

    public function success($encrypt_donatur_id)
    {
        $donatur_id = Crypt::decryptString($encrypt_donatur_id);
        $donatur = Donatur::with('fundraising')->where('id', $donatur_id)->firstOrFail();
        return view('front.views.success', compact('donatur'));
    }
}
