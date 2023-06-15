<?php

namespace App\Library;

use Cocur\Slugify\Slugify;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client as TwilioClient;

class SendSMS
{
    public static function send($msisdn, $message)
    {
        $msisdn = preg_replace("/[\s-]\-+/", "", $msisdn);

        $slugify = new Slugify([
            'regexp'    => '/[^A-Za-z0-9.,-:+]+/',
            'lowercase' => false,
            'separator' => ' ',
        ]);

        $slugify->activateRuleSet('turkish');

        // $message  = $slugify->slugify($message);
        $isLocal  = substr($msisdn, 0, 4) == '+994';
        $isRussia = substr($msisdn, 0, 2) == '+7';

        if ($isRussia || $isLocal) {
            return self::sendLocal($msisdn, $message);
        }

        return self::sendInt($msisdn, $message);

    }

    private static function sendLocal($msisdn, $message)
    {
        if (strlen($message) > 480) {
            return false;
        }

        if (strlen($msisdn) < 9) {
            return false;
        }

        if (!in_array(substr($msisdn, -9, 2), ['10', '50', '51', '55', '70', '77', '99', '60'])) {
            return false;
        }

        $msisdn = '00994' . substr($msisdn, -9);

        try {

            $client   = new GuzzleClient();
            $response = $client->request('GET', 'http://www.poctgoyercini.com/api_http/sendsms.asp', [
                'query' => [
                    'user'     => config('hemreylik.sms.username'),
                    'password' => config('hemreylik.sms.password'),
                    'gsm'      => $msisdn,
                    'text'     => $message,
                ],
            ]);

            return [
                'code'     => $response->getStatusCode(),
                'response' => $response->getBody()->getContents(),
            ];

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return [
                'error' => $exception->getMessage(),
            ];
        }

    }

    private static function sendInt($msisdn, $message)
    {
        try {

            $sid   = "AC38e534367656b0f2d2078e81b1a5dd81";
            $token = "94b7b0574944bd58165fc2a3e9bc0151";
            $from  = "+18203007714";

            $client = new TwilioClient($sid, $token);

            $client->messages->create($msisdn, [
                'from' => $from,
                'body' => $message,
            ]);

            return [
                'code'     => 200,
                'response' => 'Message has been sent',
            ];

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return [
                'error' => $exception->getMessage(),
            ];
        }

    }

    private static function sendRussia($msisdn, $message)
    {
        try {

            send_sms($msisdn, $message);

            return [
                'code'     => 200,
                'response' => 'Message has been sent',
            ];

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());

            return [
                'error' => $exception->getMessage(),
            ];
        }

    }
}
