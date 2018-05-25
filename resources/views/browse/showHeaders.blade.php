@extends('layouts.admin_ux')

@section('content')
<div id="browseapp">
        <breadcrumb :headerdata="headerdata" :header="header" :user="user" :isloggedin="isloggedin"></breadcrumb>
        <div class="container-fluid {{$isLoggedIn ? 'bg-bluegrey-mid' : 'bg-corpus-light'}} bsh-1">

            <corpusheader :headerdata="headerdata" :header="header" :user="user" :isloggedin="isloggedin" v-show="header == 'corpus'"></corpusheader>
            <documentheader :headerdata="headerdata" :header="header" :user="user" :isloggedin="isloggedin" v-show="header == 'document'"></documentheader>
            <annotationheader :headerdata="headerdata" :header="header" :user="user" :isloggedin="isloggedin" v-show="header == 'annotation'"></annotationheader>


            <metadata-block-header-annotation :headerdata="headerdata" :headerid="headerid" :header="header" :user="user" :isloggedin="isloggedin" v-show="header == 'annotation'"></metadata-block-header-annotation>
        </div>

            <metadata-block-body-corpus :headerdata="headerdata" :headerid="headerid" :header="header" :user="user" :isloggedin="isloggedin" v-show="header == 'corpus'"></metadata-block-body-corpus>
            <metadata-block-body-document :headerdata="headerdata" :headerid="headerid" :header="header" :user="user" :isloggedin="isloggedin" v-show="header == 'document'"></metadata-block-body-document>

</div>
@stop