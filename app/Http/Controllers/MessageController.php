<?php

namespace App\Http\Controllers;

use App\BoardMessage;
use App\MessageBoard;
use App\CorpusProject;
use Response;
use Illuminate\Http\Request;
use Log;

class MessageController extends Controller
{

    public function assignMessage(Request $request) {
        $status = "success";

        $result = array();

        try{
            Log::info("request->input('user_id'): ".print_r($request->input('user_id'),1));
            $boardmessage = BoardMessage::findOrFail($request->input('message_id'));
            $boardmessage->user_id = $request->input('user_id');
            $boardmessage->status = 2;

            $boardmessage->save();
            $result['message_assign_response']  = "Message was successfully assigned";
            $status = "success";
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

    public function completeMessage(Request $request) {
        $status = "success";

        $result = array();

        try{
            $boardmessage = BoardMessage::findOrFail($request->input('message_id'));
            $boardmessage->status = 3;

            $boardmessage->save();
            $result['message_complete_response']  = "Message was successfully completed";
            $status = "success";
        }
        catch (\Exception $e) {
            $status = "error";
            $result['message_complete_response']  = "There was a problem setting the Board message to completed. A message has been sent to the site administrator. Please try again later";
        }


        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return Response::json($response);
    }

    public function destroyMessage(Request $request) {
        $status = "success";

        $result = array();

        try{
            $boardmessage = BoardMessage::findOrFail($request->input('message_id'));
            $boardmessage->delete();

            $result['message_delete_response']  = "The Boardmessage was successfully deleted";
            $status = "success";
        }
        catch (\Exception $e) {
            $status = "error";
            $result['message_delete_response']  = "There was a problem deleting the Board message. A message has been sent to the site administrator. Please try again later";
        }


        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return Response::json($response);
    }
}
