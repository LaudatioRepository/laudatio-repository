<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Response;
use Log;

class ScraperController extends Controller
{
    public function scrapeLicenseDeed(Request $request) {
        $status = "success";
        $baseUri = "https://creativecommons.org";

        $result = array();

        try{
            $client = new Client();
           // Log::info("URI: ".print_r($request->input('uri'),1));
            $crawler = $client->request('GET', $request->input('uri'));


            $licenseHeader =  '<div id="deed-head" class="deedrow">'.$crawler->filter('#deed-license')->html().'</div>';
            $licenseHeader = str_replace("/images", $baseUri.'/images',$licenseHeader);

            //Log::info("licenseHEADER: ".print_r($licenseHeader,1));
            $licenseBody = '<div id="deed-main-content" class="deedrow">'.$crawler->filter('#deed-main-content')->html().'</div>';
            $licenseBody = str_replace("/images", $baseUri.'/images',$licenseBody);

            //Log::info("licenseBody: ".print_r($licenseBody,1));
            $status = "success";

            $result['deedheader'] = $licenseHeader;
            $result['deedbody'] = $licenseBody;


        }
        catch (\Exception $e) {
            $status = "error";
            $result['message_assign_response']  = "There was a problem assigning the Board message. A message has been sent to the site administrator. Please try again later";
            //$e->getMessage();

        }


        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return Response::json($response);
    }
}
