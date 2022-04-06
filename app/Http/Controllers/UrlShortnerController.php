<?php

namespace App\Http\Controllers;

use App\Models\UrlShortner;
use Illuminate\Http\Request;

class UrlShortnerController extends Controller
{
        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
                //generating alphanumeric 6 symbols

                $hash = substr(md5(microtime()), 0, 6);

                $url = $request->url;

                //check url to google safebrowsing api
                UrlShortner::CheckURL($url);

                //check the request url already exist in db

                $searchURL = UrlShortner::where("url", $url)->first();

                if ($searchURL) {
                        //if already exist then return the short link
                        return response()->json(["short_url" => url($searchURL->shortlink)]);
                } else {
                        //if not found save it into db and returl the shortlinl 
                        $urlShortner = new UrlShortner();
                        $urlShortner->url = $url;
                        $urlShortner->shortlink = $hash;
                        $urlShortner->save();
                        return response()->json(["short_url" => url($urlShortner->shortlink)]);
                }
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\Models\UrlShortner  $urlShortner
         * @return \Illuminate\Http\Response
         */
        public function show(UrlShortner $urlShortner)
        {
               
                return response()->json(["original_url" => $urlShortner->url]);
        }
}
