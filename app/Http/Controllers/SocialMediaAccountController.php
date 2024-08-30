<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaAccount;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SocialMediaAccountController extends Controller
{
    public function index()
    {
        $accounts = auth()->user()->socialMediaAccounts;
        return Inertia::render('SocialAccounts/Index', ['accounts' => $accounts]);
    }

    public function create()
    {
        return Inertia::render('SocialAccounts/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string',
            'account_id' => 'required|string',
            'access_token' => 'required|string',
        ]);

        auth()->user()->socialMediaAccounts()->create($request->all());

        return redirect()->route('social-accounts.index')->with('success', 'Social media account connected successfully.');
    }

    public function destroy(SocialMediaAccount $socialMediaAccount)
    {
        $this->authorize('delete', $socialMediaAccount);
        $socialMediaAccount->delete();

        return redirect()->route('social-accounts.index')->with('success', 'Social media account disconnected successfully.');
    }
}
