@extends('layouts.admin_ux')

@section('content')
<div id="rootContainer">
        <breadcrumb :headerdata="headerdata" :header="header" :user="user" :corpusid="corpusid" :workflowstatus="workflowstatus" :corpusversion="corpusversion" :corpuselasticsearchid="corpuselasticsearchid" :corpuspath="corpuspath" :isloggedin="isloggedin"></breadcrumb>
        <div class="container-fluid {{$isLoggedIn ? 'bg-bluegrey-mid' : 'bg-corpus-light'}} bsh-1">
            <corpusheader :headerdata="headerdata" :header="header" :citedata="citedata" :user="user" :corpusid="corpusid"  :workflowstatus="workflowstatus" :corpusversion="corpusversion"  :corpuselasticsearchid="corpuselasticsearchid"  :corpuspath="corpuspath" :ccbaseuri="ccbaseuri"  :isloggedin="isloggedin" v-show="header == 'corpus'"></corpusheader>
            <documentheader :headerdata="headerdata" :header="header" :citedata="citedata" :user="user" :corpusid="corpusid" :workflowstatus="workflowstatus" :corpusversion="corpusversion"  :corpuselasticsearchid="corpuselasticsearchid"  :corpuspath="corpuspath" :ccbaseuri="ccbaseuri" :isloggedin="isloggedin" v-show="header == 'document'"></documentheader>
            <annotationheader :headerdata="headerdata" :header="header" :citedata="citedata" :user="user" :corpusid="corpusid" :workflowstatus="workflowstatus" :corpusversion="corpusversion"  :corpuselasticsearchid="corpuselasticsearchid"  :corpuspath="corpuspath" :ccbaseuri="ccbaseuri" :isloggedin="isloggedin" v-show="header == 'annotation'"></annotationheader>
        </div>

        <metadata-block-body-corpus :headerdata="headerdata" :headerid="headerid" :header="header" :user="user" :corpusid="corpusid" :workflowstatus="workflowstatus" :corpusversion="corpusversion"  :corpuselasticsearchid="corpuselasticsearchid" :ccbaseuri="ccbaseuri" :isloggedin="isloggedin" v-show="header == 'corpus'"></metadata-block-body-corpus>
        <metadata-block-body-document :headerdata="headerdata" :headerid="headerid" :header="header" :user="user" :corpusid="corpusid" :workflowstatus="workflowstatus" :corpusversion="corpusversion"  :corpuselasticsearchid="corpuselasticsearchid" :ccbaseuri="ccbaseuri" :isloggedin="isloggedin" v-show="header == 'document'"></metadata-block-body-document>
        <metadata-block-body-annotation :headerdata="headerdata" :headerid="headerid" :header="header" :user="user" :corpusid="corpusid" :workflowstatus="workflowstatus" :corpusversion="corpusversion"  :corpuselasticsearchid="corpuselasticsearchid"  :ccbaseuri="ccbaseuri" :isloggedin="isloggedin" v-show="header == 'annotation'"></metadata-block-body-annotation>
        <input type="hidden" id="citations" value="" />
</div>
@stop