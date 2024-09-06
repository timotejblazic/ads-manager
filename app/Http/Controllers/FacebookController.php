<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\SocialMediaAccount;

class FacebookController extends Controller
{
    /**
     * Redirect the user to Facebook's OAuth page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->scopes(['ads_management', 'ads_read'])
            ->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback()
    {
        try {
            // Get user info from Facebook
            $facebookUser = Socialite::driver('facebook')->user();

            // Store or update the social media account
            $facebookAccount = SocialMediaAccount::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'platform' => 'facebook',
                    'account_id' => $facebookUser->id,
                ],
                [
                    'access_token' => $facebookUser->token,
                    'token_expires_in' => $facebookUser->expiresIn,
                ]
            );

            // Redirect to the social accounts page with a success message
            return redirect()->route('social-accounts.index')->with('success', 'Facebook account connected successfully.');
        } catch (\Exception $e) {
            // Handle errors and redirect back with an error message
            return redirect()->route('social-accounts.index')->with('error', 'Failed to connect Facebook account.');
        }
    }

    public function fetchAdAccounts()
    {
        $facebookAccount = SocialMediaAccount::where('user_id', Auth::id())->where('platform', 'facebook')->first();

        if (!$facebookAccount) {
            return redirect()->route('social-accounts.index')->with('error', 'No connected Facebook account found.');
        }

        try {
            // Decrypt the access token
            $accessToken = $facebookAccount->access_token;

            $response = Http::withToken($accessToken)->get('https://graph.facebook.com/v20.0/me/adaccounts');

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return redirect()->route('social-accounts.index')->with('error', 'Failed to fetch ad accounts.');
            }
        } catch (\Exception $e) {
            return redirect()->route('social-accounts.index')->with('error', 'An error occurred while fetching ad accounts.');
        }
    }
}
