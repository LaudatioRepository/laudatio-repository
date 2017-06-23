<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 24.03.17
 * Time: 16:22
 */

namespace App\Http\Controllers;
use App\Events\ElasticEvent;
use App\Laudatio\Search\ElasticResult;
use App\Http\Requests\SearchRequest;

class SearchController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $isLoggedIn = \Auth::check();
        return view('search.search')
            ->with('isLoggedIn', $isLoggedIn);
    }

}