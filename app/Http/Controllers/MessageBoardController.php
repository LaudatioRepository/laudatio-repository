<?php

namespace App\Http\Controllers;

use App\BoardMessage;
use App\MessageBoard;
use App\CorpusProject;
use Response;
use Illuminate\Http\Request;
use Log;

class MessageBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $status = "success";

        $result = array();

        try{
            $corpusproject = CorpusProject::findOrFail($request->input('project_id'));
            $messageboard = MessageBoard::where(['corpus_project_id' => $corpusproject->id])->get();

            if(count($messageboard) == 0){
                $messageboard = new MessageBoard();
                $messageboard->corpus_project_id = $corpusproject->id;
                $messageboard->save();

                $boardmessage = new BoardMessage();
                $boardmessage->message_board_id = $messageboard->id;
                $boardmessage->corpus_id = $request->input('corpus_id');
                $boardmessage->user_id = $request->input('user_id');
                $boardmessage->message = $request->input('message');
                $boardmessage->status = 1;

                $boardmessage->save();

                $messageboard->boardmessages()->save($boardmessage);
            }
            else {
                $boardmessage = new BoardMessage();
                $boardmessage->message_board_id = $messageboard[0]->id;
                $boardmessage->corpus_id = $request->input('corpus_id');
                $boardmessage->user_id = $request->input('user_id');
                $boardmessage->message = $request->input('message');
                $boardmessage->status = 1;

                $boardmessage->save();

                $messageboard[0]->boardmessages()->save($boardmessage);
            }



            $result['messageboard_response']  = "Message was successfully registered";
            $status = "success";
        }
        catch (\Exception $e) {
            $status = "error";
            $result['messageboard_response']  = "There was a problem creating the Board message. A message has been sent to the site administrator. Please try again later";
            //$e->getMessage();

        }


        $response = array(
            'status' => $status,
            'message' => $result,
        );

        return Response::json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MessageBoard  $messageBoard
     * @return \Illuminate\Http\Response
     */
    public function show(MessageBoardController $messageBoard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MessageBoard  $messageBoard
     * @return \Illuminate\Http\Response
     */
    public function edit(MessageBoardController $messageBoard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MessageBoard  $messageBoard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MessageBoardController $messageBoard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MessageBoard  $messageBoard
     * @return \Illuminate\Http\Response
     */
    public function destroy(MessageBoardController $messageBoard)
    {
        //
    }
}
