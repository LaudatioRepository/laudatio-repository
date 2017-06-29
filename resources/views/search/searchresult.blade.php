@extends('layouts.search')

@section('content')

    <div id="searchapp">
        <h1>Search results</h1>
        <ul>
        @foreach($results as $result)

            <li>{{ $result['_source']['corpus_title'][0]}}</li>
        @endforeach
        </ul>
    </div>
@stop