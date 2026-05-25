<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function plans(): View
    {
        $plans = Plan::active()->orderBy('sort_order')->get();
        return view('subscription.plans', compact('plans'));
    }

    public function checkout(Plan $plan): View
    {
        return view('subscription.checkout', compact('plan'));
    }

    public function pay()
    {
        // Zarinpal integration placeholder
        return redirect()->route('home');
    }

    public function verify()
    {
        // Zarinpal verify placeholder
        return redirect()->route('home');
    }
}
