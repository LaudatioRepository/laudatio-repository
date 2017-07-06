<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrowseController extends Controller
{

    public function __construct()
    {

    }

    public function index($header,$id){
        $isLoggedIn = \Auth::check();

        $data = null;

        switch ($header){
            case "corpus":
                break;
            case "document":
                break;
            case "annotation":
                break;

        }

        return view('browse.showHeaders',["header" => $header, "header_id" => $id, "header_data" => $data])
                ->with('isLoggedIn', $isLoggedIn);
    }

}
