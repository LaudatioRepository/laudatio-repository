@extends('layouts.project', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <button type="button" class="btn btn-danger btn-circle btn-xl pull-right">
                            <a href="{{ route('project.corpora.delete', array('corpus' => $corpus->id, 'corpusproject_directory_path' => $corpusproject_directory_path)) }}"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a>
                        </button>

                        <button type="button" class="btn btn-primary btn-circle btn-xl pull-right">
                            <a href="/project/corpora/{{$corpus->id}}/edit"><i class="fa fa-edit fa-2x" aria-hidden="true"></i></a>
                        </button>
                        <h1>{{$corpus->name}}</h1>
                    </div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs">

                            @if($fileData["folderType"] == "")
                                <li class="active"><a href="#description"  data-toggle="tab">Description</a></li>
                            @else
                                <li><a href="#description"  data-toggle="tab">Description</a></li>
                            @endif

                            @if($fileData["folderType"] == "TEI-HEADERS")
                                <li class="active"><a href="#headers" data-toggle="tab" id="metadataheader">Metadata Headers</a></li>
                            @else
                                <li><a href="#headers" data-toggle="tab" id="metadataheader">Metadata Headers</a></li>
                            @endif

                            @if($fileData["folderType"] == "CORPUS-DATA")
                                <li class="active"><a href="#files" data-toggle="tab" id="corpusfiles">Corpus Files</a></li>
                            @else
                                <li><a href="#files" data-toggle="tab" id="corpusfiles">Corpus Files</a></li>
                            @endif


                            <li><a href="#corpusprojects" data-toggle="tab">Corpus projects</a></li>
                            <li><a href="#collaborators" data-toggle="tab">Collaborators</a></li>
                            <li><a href="#publications" data-toggle="tab">Publications</a></li>
                            <li><a href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>

                        <div class="tab-content">
                            @if($fileData["folderType"] == "")
                                <div class="tab-pane in active" id="description">
                            @else
                                <div class="tab-pane fade" id="description">
                            @endif
                                <br />
                                <p>{{$corpus->description}}</p>
                            </div>
                            <div class="tab-pane fade" id="corpusprojects">
                                <br />
                                <div class="panel-group" id="accordion">
                                    @foreach($corpus->corpusprojects as $corpusproject)
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                        <span class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#{{$corpusproject->id}}" aria-expanded="false" class="collapsed">
                                                {{ $corpusproject->name }}
                                            </a>
                                        </span>
                                                </span>
                                            </div>
                                            <div id="{{$corpusproject->id}}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body">
                                                    {{$corpusproject->description}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="collaborators">
                                <h4>Collaborators</h4>
                                <br />
                                <div class="panel-group" id="accordion">
                                    @if(count($corpus->users) > 0)
                                        <ul class="list-group">
                                            @foreach($corpus->users as $user)
                                                <li class="list-group-item">

                                                    {{ $user->name }} {{$user->id}}
                                                    @if(count($user_roles[$user->id]) > 0)
                                                        @foreach($user_roles[$user->id] as $user_role)
                                                            <span class="badge badge-default">{{$user_role}}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="pull-right">
                                                    Add roles <button type="button" class="btn btn-success btn-circle">
                                                        <a href="/project/userroles/{{$corpus->id}}/{{$user->id}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                    </button>
                                                    </span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <span class="pull-right">
                                    <button type="button" class="btn btn-success btn-circle">
                                        <a href="{{ URL::route('project.corpora.assignusers',$corpus->id)}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    </button>
                                    Add collaborators to the corpus project
                                </span>
                            </div>
                            @if($fileData["folderType"] == "TEI-HEADERS")
                                <div class="tab-pane in active" id="headers">
                                    @if($fileData["headerData"])
                                        @if ($fileData["headerData"]["hasdir"] == false && strpos($fileData["headerData"]["path"],"Untitled") !== false)
                                            <a href="{{route('gitRepo.upload.get',array('dirname' => $fileData["headerData"]["path"])) }}" style="display: block; margin-top: 20px"><button type="button" class="btn btn-primary btn-lg center-block">Upload a Corpus Header <i class="fa fa-upload fa-3x" aria-hidden="true"></i></button></a>
                                        @else
                                            <a href="/project/corpora/{{$corpus->id}}/{{$fileData["headerData"]["previouspath"]}}" class="adminIcons"><i class="fa fa-level-up fa-3x pull-right" aria-hidden="true"></i></a>
                                            <h4>Corpus Header: {{$header}}</h4>
                                            <br />
                                            @include('project.corpus.projectList')
                                        @endif
                                    @endif
                                </div>
                            @else
                                <div class="tab-pane fade" id="datafiles">
                                    @if($fileData["headerData"])
                                        @if ($fileData["headerData"]["hasdir"] == false && strpos($fileData["headerData"]["path"],"Untitled") !== false)
                                            <a href="{{route('gitRepo.upload.get',array('dirname' => $fileData["headerData"]["path"])) }}" style="display: block; margin-top: 20px"><button type="button" class="btn btn-primary btn-lg center-block">Upload a Corpus Header <i class="fa fa-upload fa-3x" aria-hidden="true"></i></button></a>
                                        @else
                                            <a href="/project/corpora/{{$corpus->id}}/{{$fileData["headerData"]["previouspath"]}}" class="adminIcons"><i class="fa fa-level-up fa-3x pull-right" aria-hidden="true"></i></a>
                                            <h4>Corpus Header: {{$header}}</h4>
                                            <br />
                                            @include('project.corpus.projectList')
                                        @endif
                                    @endif
                                </div>
                            @endif

                            @if($fileData["folderType"] == "CORPUS-DATA")
                                <div class="tab-pane  in active" id="files">
                            @else
                                <div class="tab-pane fade" id="files">
                            @endif
                                    @if($fileData["corpusData"]["pathcount"] > 3)
                                        <a href="/project/corpora/{{$corpus->id}}/{{$fileData["corpusData"]["previouspath"]}}#files" class="adminIcons"><i class="fa fa-level-up fa-3x pull-right" aria-hidden="true"></i></a>
                                    @endif
                                <h4>Corpus Files</h4>
                                @include('project.corpus.fileList')
                            </div>
                            <div class="tab-pane fade" id="publications">
                                <h4>Publications</h4>
                            </div>
                            <div class="tab-pane fade" id="settings">
                                <h4>Settings</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                        </div>


                    </div>
                    <div class="panel-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script language="JavaScript">
        $("#checkAll").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
        });


        $("#metadataheader").click(function () {
            var url = window.location.pathname;
            var urlArray = url.split("/");
            var cleanedArray = urlArray.filter(urlArray => urlArray);
            var path =  cleanedArray[0]+"/"+cleanedArray[1]+"/"+cleanedArray[2]+"/"+cleanedArray[3]+"/"+cleanedArray[4]+"/TEI-HEADERS"
            console.log(path);
            var newUri = window.location.origin+"/"+path+"#headers";
            history.pushState({}, null, newUri);
            location.reload();
        });

        $("#corpusfiles").click(function () {
            var url = window.location.pathname;
            var urlArray = url.split("/");
            var cleanedArray = urlArray.filter(urlArray => urlArray);
            var path =  cleanedArray[0]+"/"+cleanedArray[1]+"/"+cleanedArray[2]+"/"+cleanedArray[3]+"/"+cleanedArray[4]+"/CORPUS-DATA"
            console.log(cleanedArray);
            var newUri = window.location.origin+"/"+path+"#files";
            history.pushState({}, null, newUri);
        });

        $("#saveFormatButton").click(function() {
            var token = $('#_token').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var url = window.location.pathname;
            var urlArray = url.split("/");
            var cleanedArray = urlArray.filter(urlArray => urlArray);

            var path = cleanedArray[3]+"/"+cleanedArray[4]+"/CORPUS-DATA"
            console.log(window.location.origin);
            var redirectPath =  window.location.origin+"/"+cleanedArray[0]+"/"+cleanedArray[1]+"/"+cleanedArray[2]+"/"+cleanedArray[3]+"/"+cleanedArray[4]+"/CORPUS-DATA"
            var postData = {}
            postData.token = token;
            postData.formatName = $("#format_name").val()
            postData.path = path;


            $.ajax({
                url: '/api/adminapi/createFormat',
                type:"POST",
                data: postData,
                async: true,
                statusCode: {
                    500: function () {
                        alert("server down");
                    }
                },
                success:function(data){
                    var flashMessage = '<div id="flash-message" class="alert alert-success"> '+data.msg+' </div>';
                    $('#page-wrapper').append(flashMessage);
                    $('#myModal').modal('hide');
                    history.pushState({}, null, redirectPath);
                    location.reload();
                    //location.href = redirectPath;
                },error:function(){
                    console.log("error!!!!");
                }
            }); //end of ajax
        });

        function getValidationData(postData) {
            return new Promise(function(resolve, reject) {

                var token = $('#_token').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/api/adminapi/validateHeaders',
                    type:"POST",
                    data: postData,
                    async: true,
                    statusCode: {
                        500: function () {
                            alert("server down");
                        }
                    },
                    success: function(data) {
                        resolve(data) // Resolve promise and go to then()
                    },
                    error: function(err) {
                        reject(err) // Reject the promise and go to catch()
                    }
                })
            });
        }

        function getPublishTestData(postData) {
            return new Promise(function(resolve, reject) {

                var token = $('#_token').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/api/adminapi/preparePublication',
                    type:"POST",
                    data: postData,
                    async: true,
                    statusCode: {
                        500: function () {
                            alert("server down");
                        }
                    },
                    success: function(data) {
                        resolve(data) // Resolve promise and go to then()
                    },
                    error: function(err) {
                        reject(err) // Reject the promise and go to catch()
                    }
                })
            });
        }

        $("#publishCorpusButton").click(function (){
            var postPublishData = {}
            postPublishData.corpusid = $('#corpusid').val();
            postPublishData.corpuspath = $('#corpuspath').val()
            getPublishTestData(postPublishData).then(function(publishData){
                //console.log(JSON.stringify(publishData))
                //var json = JSON.parse(publishData.msg);
                var jsonData = publishData.msg

                $('#publicationModalLabel').html(jsonData.title);

                $('#publicationModal').modal('show');
                var html = '<div id="preparationWrapper">';

                html += '<div id="subtitle">'+jsonData.subtitle+'</div>';
                html += '<div id="waiting">'+jsonData.waiting+'</div>';

                html += '<ul class="list-group">';

                html += '<li class="list-group-item">';
                html += ''+jsonData.corpus_header.title+'';
                if(jsonData.corpus_header.corpusHeaderText != ''){
                    html += '<br /><span class="has-error>'+jsonData.corpus_header.corpusHeaderText+'</span>';
                }
                html += '<i class="material-icons pull-right">'+jsonData.corpus_header.corpusIcon+'</i>';
                html += '</li>';


                html += '<li class="list-group-item">';
                html += ''+jsonData.document_headers.title+'';
                if(jsonData.document_headers.documentHeaderText != ''){
                    html += '<br /><span class="has-error">'+jsonData.document_headers.documentHeaderText+'</span>';
                }
                html += '<i class="material-icons pull-right">'+jsonData.document_headers.documentIcon+'</i>';
                html += '</li>';

                html += '<li class="list-group-item">';
                html += ''+jsonData.annotation_headers.title+'';
                if(jsonData.annotation_headers.annotationHeaderText != ''){
                    html += '<br /><span class="has-error">'+jsonData.annotation_headers.annotationHeaderText+'</span>';
                }
                html += '<i class="material-icons pull-right">'+jsonData.annotation_headers.annotationIcon+'</i>';
                html += '</li>';

                html += '</ul>';

                html += '</div>';
                $('#publicationModal .modal-dialog .modal-content .modal-body').html(html);
            }).catch(function(err) {
                // Run this when promise was rejected via reject()
                console.log(err)
            })
        });

        $("#validateCorpusButton").click(function () {
            var postData = {}
            postData.corpusid = $('#corpusid').val();
            postData.corpuspath = $('#corpuspath').val()

            getValidationData(postData).then(function(data) {
                var json = JSON.parse(data.msg);

                var newModaltitle = "Validation results for corpus/"+json.corpusheader;
                $('#myModalLabelValidation').html(newModaltitle);
                $('#myValidatorModal').modal('show');

                var html = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

                html += '<div class="panel panel-default">';
                html += '<div class="panel-heading" role="tab" id="documentHeading">';
                html += '<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#documentsInCorpus" aria-expanded="false" aria-controls="documentsInCorpus">Documents in corpus</a></h4></div>'
                html += '<div id="documentsInCorpus" class="panel-collapse collapse" role="tabpanel" aria-labelledby="documentHeading"><div class="list-group">';
                html +='<ul class="list-group">';
                for(var i = 0; i < json.found_documents.length; i++){
                    html += '<li class="list-group-item">'+json.found_documents[i].title+' <i class="material-icons pull-right">check_circle</i></li>';
                }

                var not_found_documents = json.not_found_documents_in_corpus.sort()

                for(var j = 0; j < not_found_documents.length; j++){
                    html += '<li class="list-group-item">'+not_found_documents[j]+' <i class="material-icons pull-right">warning</i></li>';
                }
                html += '</ul>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                html += '<div class="panel panel-default">';
                html += '<div class="panel-heading" role="tab" id="annotationHeading">';
                html += '<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#annotationsInCorpus" aria-expanded="false" aria-controls="annotationsInCorpus">Annotations in corpus</a></h4></div>'
                html += '<div id="annotationsInCorpus" class="panel-collapse collapse" role="tabpanel" aria-labelledby="annotationHeading"><div class="list-group">'

                html +='<ul class="list-group">';

                for(var k = 0; k < json.found_annotations_in_corpus.length; k++){
                    html += '<li class="list-group-item">'+json.found_annotations_in_corpus[k]+' <i class="material-icons pull-right">check_circle</i></li>';
                }

                var not_found_annotations = json.not_found_annotations_in_corpus.sort()
                for(var l = 0; l < not_found_annotations.length; l++){
                    html += '<li class="list-group-item">'+not_found_annotations[l]+' <i class="material-icons pull-right">warning</i></li>';
                }


                html += '</ul>';

                html += '</div>';
                html += '</div>';
                html += '</div>';

                html += '</div>';
                $('.modal-body').html(html);
            }).catch(function(err) {
                // Run this when promise was rejected via reject()
                console.log(err)
            })
/*
            $.ajax({
                url: '/api/adminapi/validateHeaders',
                type:"POST",
                data: postData,
                async: true,
                statusCode: {
                    500: function () {
                        alert("server down");
                    }
                },
                success:function(data){
                    return data;
                },
                complete: function() {
                    var json = JSON.parse(data.msg);
                    console.log("DATA: "+json.corpusheader);
                    var modalTitle = $('#myModalLabel').val();
                    $('#myModalLabel').val(modalTitle+" "+json.corpusheader)
                    $('#myValidatorModal').modal('show');
                    var html = "";

                    $('.modal-body').html(html);
                }
                ,error:function(){
                    console.log("error!!!!");
                }
            }); //end of ajax
            */
        });

        $("#deleteCheckedButton").click(function() {

            var token = $('#_token').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var postData = {}
            postData.token = token;
            postData.filesForDeletion = []
            var deletedRows = []

            $('[name="chosen_files"]').each( function (){
                if($(this).prop('checked') == true){
                    deletedRows.push($(this).parent().parent().attr("id"));
                    postData.filesForDeletion.push($(this).val());
                }
            });

            $.ajax({
                url: '/api/adminapi/deletemultiple',
                type:"POST",
                data: postData,
                async: true,
                statusCode: {
                    500: function () {
                        alert("server down");
                    }
                },
                success:function(data){
                    console.log("DATA: "+JSON.stringify(data));

                    for(var i = 0; i< deletedRows.length; i++) {
                        $("#"+deletedRows[i]).remove();
                    }

                    var flashMessage = '<div id="flash-message" class="alert alert-success"> '+data.msg+' </div>';
                    $('#page-wrapper').append(flashMessage);
                },error:function(){
                    console.log("error!!!!");
                }
            }); //end of ajax

        })
    </script>
@endsection