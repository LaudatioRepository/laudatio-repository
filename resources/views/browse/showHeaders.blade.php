@extends('layouts.admin_ux')

@section('content')
<div id="browseapp">
        <breadcrumb :headerdata="headerdata" :header="header" :user="user" :corpusid="corpusid" :corpuselasticsearchid="corpuselasticsearchid" :isloggedin="isloggedin"></breadcrumb>
        <div class="container-fluid {{$isLoggedIn ? 'bg-bluegrey-mid' : 'bg-corpus-light'}} bsh-1">

            <corpusheader :headerdata="headerdata" :header="header" :user="user" :corpusid="corpusid" :corpuselasticsearchid="corpuselasticsearchid"   :isloggedin="isloggedin" v-show="header == 'corpus'"></corpusheader>
            <documentheader :headerdata="headerdata" :header="header" :user="user" :corpusid="corpusid" :corpuselasticsearchid="corpuselasticsearchid"   :isloggedin="isloggedin" v-show="header == 'document'"></documentheader>
            <annotationheader :headerdata="headerdata" :header="header" :user="user" :corpusid="corpusid" :corpuselasticsearchid="corpuselasticsearchid"   :isloggedin="isloggedin" v-show="header == 'annotation'"></annotationheader>
        </div>

            <metadata-block-body-corpus :headerdata="headerdata" :headerid="headerid" :header="header" :user="user" :corpusid="corpusid" :corpuselasticsearchid="corpuselasticsearchid"   :isloggedin="isloggedin" v-show="header == 'corpus'"></metadata-block-body-corpus>
            <metadata-block-body-document :headerdata="headerdata" :headerid="headerid" :header="header" :user="user" :corpusid="corpusid" :corpuselasticsearchid="corpuselasticsearchid"   :isloggedin="isloggedin" v-show="header == 'document'"></metadata-block-body-document>
            <metadata-block-body-annotation :headerdata="headerdata" :headerid="headerid" :header="header" :user="user" :corpusid="corpusid" :corpuselasticsearchid="corpuselasticsearchid"  :isloggedin="isloggedin" v-show="header == 'annotation'"></metadata-block-body-annotation>

</div>
@stop