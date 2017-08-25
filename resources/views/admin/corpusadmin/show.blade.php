@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div id="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <button type="button" class="btn btn-danger btn-circle btn-xl pull-right">
                            <a href="/admin/corpora/{{$corpus->id}}/delete"><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></a>
                        </button>

                        <button type="button" class="btn btn-primary btn-circle btn-xl pull-right">
                            <a href="/admin/corpora/{{$corpus->id}}/edit"><i class="fa fa-edit fa-2x" aria-hidden="true"></i></a>
                        </button>
                        <h1>{{$corpus->name}}</h1>
                    </div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#headers" data-toggle="tab">Metadata Headers</a></li>
                            <li><a href="#description" data-toggle="tab">Description</a></li>
                            <li><a href="#corpusprojects" data-toggle="tab">Corpus projects</a></li>
                            <li><a href="#publications" data-toggle="tab">Publications</a></li>
                            <li><a href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade" id="description">
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
                            <div class="tab-pane  in active" id="headers">
                                <a href="/admin/corpora/{{$corpus->id}}/{{$previouspath}}" class="adminIcons"><i class="fa fa-level-up fa-3x pull-right" aria-hidden="true"></i></a>
                                <h4>{{$folderName}}</h4>
                                <br />
                                @include('admin.corpusadmin.projectList')
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

        $("#deleteCheckedButton").click(function() {
            console.log("HALOO: ");

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



            console.log(postData.filesForDeletion);
            console.log(deletedRows);
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