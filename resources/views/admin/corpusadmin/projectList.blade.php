
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
                            <th>Action</th>
                            <th>Size</th>
                            <th>Last updated</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)

                                @if($project["type"] == "dir")
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                        <td class="text-center"><span class="fa fa-folder"></span></td>
                                        <td><a href="{{ route('admin.corpora.show', array('corpus' => $corpus,'path' => $project['path'])) }}">{{$project['basename']}}</a></td>
                                        <td class="text-center">
                                            @if($pathcount == 3 || $pathcount == 1)
                                                <a href="{{route('gitRepo.deleteFile.route', array('path' => $project['path'])) }}"><span class="btn btn-sm btn-danger fa fa-trash"></span></a>
                                            @endif

                                            @if($project["tracked"] == "false" && $project["foldercount"] > 0 && $pathcount == 3)
                                                <a href="{{route('gitRepo.addFile.route', array('path' => $project['path'],'corpus' => $corpus->id)) }}"><span class="btn btn-sm btn-danger fa fa-code-fork"></span></a>
                                            @endif
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>{{$project['lastupdated']}}</td>
                                    </tr>
                                @else
                                    <tr id="cell_{{$loop->index}}">
                                        <td>
                                            <input type="checkbox" name="chosen_files" value="{{$project['path']}}" class="check" />
                                        </td>
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
                                            <a href="{{route('gitRepo.deleteFile.route', array('path' => $project['path'])) }}"><span class=  "btn btn-sm btn-danger fa fa-trash"></span></a>
                                        </td>
                                        <td>{{$project['filesize']}} KB </td>
                                        <td>{{$project['lastupdated']}}</td>
                                    </tr>
                                @endif
                        @endforeach
                        </tbody>
                        <tr>
                            <td><a href="#" id="deleteCheckedButton"><span class="btn btn-sm btn-danger fa fa-trash"></span></a>
                            <td colspan="5">&nbsp;</td>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
    @endif
        @if($pathcount == 4)
            <span class="pull-right"><a href="{{route('gitRepo.upload.get',array('dirname' => $path)) }}" ><i class="fa fa-upload fa-3x" aria-hidden="true"></i></a></span>
        @endif
</div>