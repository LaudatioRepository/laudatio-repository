@extends('layouts.app', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <h2>{{$path}}</h2>
    @if(!empty($projects))
    <ul>
        @foreach($projects as $project)
            @if($project["type"] == "dir")
                    <li><a href="{{ route('gitRepo.route', array('path' => $project['path'])) }}"> {{$project['basename']}}</a>
                        @if($pathcount == 2 || $pathcount == 1)
                            | <a href="{{route('gitRepo.deleteFile.route', array('path' => $project['path'], 'isdir' => 1)) }}">Delete</a>
                        @endif

                        @if($project["tracked"] == "false" && $project["foldercount"] > 0 && $pathcount == 3)
                            | <a href="{{route('gitRepo.addFile.route', array('path' => $project['path'])) }}">Add to GIT</a>
                        @endif
                    </li>
            @else
                <li><a href="{{ route('gitRepo.readFile.route', array('path' => $project['path'])) }}"> {{$project['basename']}}</a>
                    @if (count($project['diffFiles']) > 0 )
                        @foreach($project['diffFiles'] as $diffFile)
                            @if(strpos($diffFile,$project['basename']) !== false)
                            | <a href="{{route('gitRepo.updateFile.route', array('path' => $project['path'])) }}">Update file version</a>
                            @endif
                        @endforeach
                    @endif


                        | <a href="{{route('gitRepo.deleteFile.route', array('path' => $project['path'], 'isdir' => 0)) }}">Delete</a>

                </li>
            @endif

    @endforeach
    </ul>


    @if($pathcount == 1 && $path == "")
        <a href="{{route('gitRepo.createproject.get',array('dirname' => $project['dirname'])) }}" >Create project</a>
    @endif


    @else

        @if($pathcount == 1)
            <a href="{{route('gitRepo.createcorpus.get',array('dirname' => $path)) }}" >Initiate corpus</a>
        @endif
   @endif
    @if($pathcount == 4)
        <a href="{{route('gitRepo.upload.get',array('dirname' => $path)) }}" >Upload files</a>
    @endif
    <a href="{{ route('gitRepo.route', array('path' => $previouspath)) }}"> <i class="fa fa-hand-o-up fa-3x"></i></a>
@stop
