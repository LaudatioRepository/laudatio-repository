
<div class="container-fluid archives">
    @if(!empty($projects))
        <div class="row">
            <a href="/admin/corpora/{{$corpus->id}}/{{$previouspath}}" class="adminIcons"><i class="fa fa-level-up fa-3x pull-right" aria-hidden="true"></i></a>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <table class="table table-bordered table-hover vmiddle">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Action</th>
                            <th>Size</th>
                            <th>Last updated</th>
                        </tr>
                        </thead>
                        @foreach($projects as $project)

                            <tbody>
                                @if($project["type"] == "dir")
                                    <tr>
                                        <td class="text-center"><span class="fa fa-folder"></span></td>
                                        <td><a href="{{ route('admin.corpora.show', array('corpus' => $corpus,'path' => $project['path'])) }}">{{$project['basename']}}</a></td>
                                        <td class="text-center">
                                            @if($pathcount == 2 || $pathcount == 1)
                                                <a href="{{route('gitRepo.deleteFile.route', array('path' => $project['path'], 'isdir' => 1)) }}"><span class="btn btn-sm btn-danger fa fa-trash"></span></a>
                                            @endif

                                            @if($project["tracked"] == "false" && $project["foldercount"] > 0 && $pathcount == 3)
                                                <a href="{{route('gitRepo.addFile.route', array('path' => $project['path'],'corpus' => $corpus->id)) }}"><span class="btn btn-sm btn-danger fa fa-code-fork"></span></a>
                                            @endif
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>{{$project['lastupdated']}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="text-center"><span class="fa fa-file"></span></td>
                                        <td><a href="{{ route('gitRepo.readFile.route', array('path' => $project['path'])) }}"> {{$project['basename']}}</a></td>
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
                                            <a href="{{route('gitRepo.deleteFile.route', array('path' => $project['path'], 'isdir' => 0)) }}"><span class=  "btn btn-sm btn-danger fa fa-trash"></span></a>
                                        </td>
                                        <td>{{$project['filesize']}} KB </td>
                                        <td>{{$project['lastupdated']}}</td>
                                    </tr>
                                @endif
                            </tbody>
                        @endforeach
                        </table>
                    </div>
                </div>
            </div>
    @endif
        @if($pathcount == 4)
            <span class="pull-right"><a href="{{route('gitRepo.upload.get',array('dirname' => $path)) }}" ><i class="fa fa-upload fa-3x" aria-hidden="true"></i></a></span>
        @endif
</div>