<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Google;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class mailserver extends Controller
{

    private $email;
    private $name;
    private $client_id;
    private $client_secret;
    private $token;
    private $provider;

    public function __construct()
    {
        $this->email            = 'ratipriyakundu5@gmail.com'; // ex. example@gmail.com
        $this->email_name       = 'Rati';     // ex. Abidhusain
        $this->client_id        = env('GMAIL_API_CLIENT_ID');
        $this->client_secret    = env('GMAIL_API_CLIENT_SECRET');
        $this->provider         = new Google(
            [
                'clientId'      => '377386792027-atomhrr37j7dv7mhp24cpljj64fflmuq.apps.googleusercontent.com',
                'clientSecret'  => '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',
            ]
        );

    }

    public function sendMail(Request $request) {
        $this->token = $request->mailToken;

        $mail = new PHPMailer(true);
        
        try {
            
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => '377386792027-atomhrr37j7dv7mhp24cpljj64fflmuq.apps.googleusercontent.com',
                        'clientSecret'      => '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',
                        'refreshToken'      => 'ya29.A0ARrdaM9OLATZ3Z0iR4SL071fsUP4k1DDYEtzrhIZvtZ-b8Ma37E_F3bYwwyVC4uGiafZ45Wl4f1GdJdHykZwNvXo0U5B5nrhl1wMB6jpitl93H2CbKCSFwOndoI1ns7n2kb36JsnPK_O6n0eWvJo-L0MJamyYUNnWUtBVEFTQVRBU0ZRRl91NjFWZE1qNkZ3M3VjZXZzV0FVOU1TTkhoUQ0163',
                        'userName'          => 'fileurtax22@gmail.com'
                    ]
                )
            );

            $mail->setFrom('fileurtax22@gmail.com', 'fileurtax');
            
            $mail->addAddress('rathouryogesh40@gmail.com', 'Ranjan');
            $mail->Subject = 'Laravel PHPMailer OAuth2 Integration';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = 'Hello <b>Everyone</b>,<br><br>We successfully completed our PHPMailer Integration in Laravel Project with Gmail OAuth2.<br><br>Thank you,<br><b>Abidhusain Chidi</b>';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if( $mail->send() ) {
                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['status'=>'no']);
            }
            
        } catch(Exception $e) {
            return response()->json(['status'=>'no']);
            //return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }
}
