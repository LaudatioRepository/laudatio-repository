<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Custom\ValidatorInterface;
use GrahamCampbell\Flysystem\FlysystemManager;
use Log;

class ValidateTEIController extends Controller
{
    protected $flySystem;
    protected $basePath;
    protected $validationService;


    public function __construct(FlysystemManager $flySystem, ValidatorInterface $validationService) {
        $this->flySystem = $flySystem;
        $this->basePath = config('laudatio.basePath');
        $this->validationService = $validationService;
    }


    public function validateXmlFile(Request $request) {
        try{
            $dirPath = $request->directorypath;
            $xmlfile = $request->fileName;

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
}

