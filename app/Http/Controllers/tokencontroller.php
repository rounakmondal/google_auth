<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class tokencontroller extends Controller
{
    
    private $client_id;
    private $client_secret;
    private $redirect_uri;

    private $provider;
    private $google_options;

    public function __construct()
    {
        $this->client_id = env('GMAIL_API_CLIENT_ID');
        $this->client_secret = env('GMAIL_API_CLIENT_SECRET');
        $this->redirect_uri = route('getToken');
        $this->google_options = [
            'scope' => [
                'https://mail.google.com/'
            ]
        ];
        $params = [
            'clientId'      => $this->client_id,
            'clientSecret'  => $this->client_secret,
            'redirectUri'   => $this->redirect_uri,
            'accessType'    => 'offline'
        ];

        // Create Google Provider
        $this->provider = new Google([
            'clientId'      => '377386792027-atomhrr37j7dv7mhp24cpljj64fflmuq.apps.googleusercontent.com',
            'clientSecret'  => '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',
            'redirectUri'   => route('getToken'),
            'accessType'    => 'offline'
        ]);
    }

    public function generateToken(Request $request) {
        $redirect_uri = $this->provider->getAuthorizationUrl($this->google_options);
        return redirect($redirect_uri);
    }

    public function getToken(Request $request)
    {
        $code = $request->get('code');

        try {
            // Generate Token From Code 
            $tokenObj = $this->provider->getAccessToken(
                'authorization_code',
                [
                    'code' => $code
                ]
                );
                $token = $tokenObj->getToken();
                $refresh_token = $tokenObj->getRefreshToken();
                session()->put('token',$token);
                if( $refresh_token != null && !empty($refresh_token) ) {
                    return redirect()->back()->with('token', $refresh_token);
                } elseif ( $token != null && !empty($token) ) {
                    return redirect()->back()->with('token', $token);
                } else {
                    return redirect()->back()->with('error', 'Unable to retreive token.');
                }
        } catch(IdentityProviderException $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        } catch(Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }
    public function home(){
        return view('home');
    }
}
