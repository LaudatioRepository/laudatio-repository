

<div class="container-fluid archives">
    @if(!empty($projects))
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <form id="fileform">
                        <table class="table table-bordered table-hover vmiddle">
                            <thead>
                            <tr>
                                <th colspan="2"><label>
                                        <input type="checkbox" class="check" id="checkAll"> Check All
                                    </label></th>
                                <th>Name</th>
                                @if(!$hasdir)
                                    <th>Version</th>
                                @endif
                                <th>Action</th>
                                @if(!$hasdir)
                                    <th>Size</th>
                                @endif
                                <th>Last updated</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($projects as $project)
                                @if($project["type"] == "dir")
                                    <tr>
                                        <td>
                                        </td>
                                        <td class="text-center"><span class="fa fa-folder"></span></td>
                                        <td><a href="{{ route('admin.corpora.show', array('corpus' => $corpus,'path' => $project['path'])) }}">{{$project['basename']}}</a></td>
                                        <td class="text-center">
                                            @if($pathcount == 3 || $pathcount == 1 || $pathcount == 4)
                                                @if($project["tracked"] != "false")
                                                    <a href="{{route('gitRepo.deleteFile.route', array('path' => $project['path'])) }}"><span class="btn btn-sm btn-danger fa fa-trash"></span></a>
                                                @else
                                                    <a href="{{route('gitRepo.deleteUntrackedFile.route', array('path' => $project['path'])) }}"><span class="btn btn-sm btn-danger fa fa-trash"></span></a>
                                                @endif

                                            @endif

                                            @if($project["tracked"] == "false" && $project["foldercount"] > 0 && $pathcount == 3)
                                                <a href="{{route('gitRepo.addFile.route', array('path' => $project['path'],'corpus' => $corpus->id)) }}"><span class="btn btn-sm btn-danger fa fa-code-fork"></span></a>
                                            @endif
                                        </td>
                                        <td>{{$project['lastupdated']}}</td>
                                    </tr>
                                @else
                                    <tr id="cell_{{$loop->index}}">
                                        <td>
                                            <input type="checkbox" name="chosen_files" value="{{$project['path']}}" class="check" />
                                        </td>
                                        <td class="text-center"><span class="fa fa-file"></span></td>
                                        <td><a href="{{ route('gitRepo.readFile.route', array('path' => $project['path'])) }}"> {{$project['basename']}}</a></td>
                                        @if(!empty($project["headerObject"]) > 0)
                                            <td>{{$project["headerObject"]->vid}}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td class="text-center">
                                            @if($project["tracked"] == "false" && $pathcount == 4)
                                                <a href="{{route('gitRepo.addFile.route', array('path' => $project['path'],'corpus' => $corpus->id)) }}"><span class="btn btn-sm btn-danger fa fa-code-fork"></span></a>
                                            @endif
                                            @if (isset($project['diffFiles']) && count($project['diffFiles']) > 0 )
                                                @foreach($project['diffFiles'] as $diffFile)
                                                    @if(strpos($diffFile,$project['basename']) !== false)
                                                        | <a href="{{route('gitRepo.updateFile.route', array('path' => $project['path'])) }}">Update file version</a>
                                                    @endif
                                                @endforeach
                                            @endif


                                                @if($project["tracked"] != "false")
                                                    <a href="{{route('gitRepo.deleteFile.route', array('path' => $project['path'])) }}"><span class=  "btn btn-sm btn-danger fa fa-trash"></span></a>
                                                @else
                                                    <a href="{{route('gitRepo.deleteUntrackedFile.route', array('path' => $project['path'])) }}"><span class="btn btn-sm btn-danger fa fa-trash"></span></a>
                                                @endif

                                        </td>
                                        @if ($project['filesize'])
                                            <td>{{$project['filesize']}}</td>
                                        @endif
                                        <td>{{$project['lastupdated']}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tr>
                                <td><a href="#" id="deleteCheckedButton"><span class="btn btn-sm btn-danger fa fa-trash"></span></a></td>
                                <td colspan="6"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    @endif
        @if($folderName == "CORPUS-DATA")
            <span class="btn btn-sm btn-primary fa fa-file-code-o" data-toggle="modal" data-target="#myModal"> Add new format</span>
        @endif
        <span class="pull-right"><a href="{{route('gitRepo.uploadFiles.get',array('dirname' => $path)) }}" ><i class="fa fa-upload fa-3x" aria-hidden="true"></i></a></span>

</div>