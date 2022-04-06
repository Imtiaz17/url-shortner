<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlShortner extends Model
{
    use HasFactory;

    // Article model
    public function getRouteKeyName()
    {
        return 'shortlink';
    }

    public static function CheckURL($url)
    {
        $checkMalware = self::send_response($url);

        $checkMalware = json_decode($checkMalware, true);

        $malwareStatus = $checkMalware;

        return $malwareStatus;
    }

    /**
     * Function for sending a HTTP GET Request
     * to the Google Safe Browsing Lookup API
     */
    public static function get_data($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);


        $data = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return array(
            'status' => $httpStatus,
            'data' => $data
        );
    }

    public static function send_response($input)
    {
        define('API_KEY', "AIzaSyAUdnoS55sYAKhO6f1eM8WujXant2sZ3qA");
        define('PROTOCOL_VER', '3.0');
        define('CLIENT', 'checkURLapp');
        define('APP_VER', '1.0');
        if (!empty($input)) {
            $urlToCheck = urlencode($input);

            $url = 'https://sb-ssl.google.com/safebrowsing/api/lookup?client=' . CLIENT . '&apikey=' . API_KEY . '&appver=' . APP_VER . '&pver=' . PROTOCOL_VER . '&url=' . $urlToCheck;

            $response = self::get_data($url);

            if ($response['status'] == 204) {
                return json_encode(array(
                    'status' => 204,
                    'checkedUrl' => $urlToCheck,
                    'message' => 'The site is not on Googles black list                                        .'
                ));
            } elseif ($response['status'] == 200) {
                return json_encode(array(
                    'status' => 200,
                    'checkedUrl' => $urlToCheck,
                    'message' => 'The site is blacklisted as ' . $response['data'] . '.'
                ));
            } else {
                return json_encode(array(
                    'status' => 501,
                    'checkedUrl' => $urlToCheck,
                    'message' => 'Server Error'
                ));
            }
        } else {
            return json_encode(array(
                'status' => 401,
                'checkedUrl' => '',
                'message' => 'Per Favore inserisci Url.'
            ));
        };
    }
}
