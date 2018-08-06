<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Response;
use Illuminate\Support\Facades\Cache;
use Log;

class ScraperController extends Controller
{
    public function scrapeLicenseDeed(Request $request) {
        $status = "success";
        $result = array();
        $cacheString = $request->input('uri');
        $baseUri = "https://creativecommons.org";

        if (Cache::has($cacheString)) {
            $result = json_decode(Cache::get($cacheString));
        }
        else {
            try{
                $client = new Client();
                $crawler = $client->request('GET', $request->input('uri'));

                $licenseHeader =  '<div id="deed-head" class="deedrow">'.$crawler->filter('#deed-license')->html().'</div>';
                $licenseHeader = str_replace("/images", $baseUri.'/images',$licenseHeader);

                $licenseBody = '<div id="deed-main-content" class="deedrow">'.$crawler->filter('#deed-main-content')->html().'</div>';
                $licenseBody = str_replace("/images", $baseUri.'/images',$licenseBody);

                $helpPanels = '<div id="help-panels" style="display: none">'.$crawler->filter('#help-panels')->html().'</div>';

                $status = "success";

                $result['deedheader'] = $licenseHeader;
                $result['deedbody'] = $licenseBody;
                $result['helppanels'] = $helpPanels;

                Cache::forever($cacheString, json_encode($result));

            }
            catch (\Exception $e) {
                $status = "error";
                $result['message_assign_response']  = "There was a problem assigning the Board message. A message has been sent to the site administrator. Please try again later";
                Log::info("ERROR: ".$e->getMessage());

            }
        }




        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return Response::json($response);
    }
}
