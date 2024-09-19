<?php

namespace App\Http\Controllers;

use App\Models\Fundraiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function apply_fundraiser()
    {
        $user = Auth::user();
        DB::transaction(function() use($user){
            $validate['user_id'] = $user->id;
            $validate['is_active'] = false;

            Fundraiser::create($validate);
        });

        return redirect()->route('admin.fundraisers.index');
    }
}
