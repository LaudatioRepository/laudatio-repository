@extends('layouts.search')

@section('content')
    <div id="searchapp">
        <h1>Search</h1>
        <searchpanel_general v-on:searchedgeneral="askElastic"></searchpanel_general>
        <searchwrapper :results="results"></searchwrapper>
    </div>
@stop