@extends('layouts.app', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <h2>{{$path}}</h2>
    @if(!empty($schema))
        <ul>
            @foreach($schema as $schemafile)
                @if($schemafile["type"] == "dir")
                    <li><a href="{{ route('gitRepo.route.schema', array('path' => $schemafile['path'])) }}"> {{$schemafile['basename']}}</a>
                        @if($pathcount == 2 && in_array("KM",$user['roles']) || $pathcount == 1 && in_array("Admin",$user['groups']))
                            | <a href="{{route('gitRepo.deleteFile.route', array('path' => $schemafile['path'], 'isdir' => 1)) }}">Delete</a>
                        @endif

                        @if($schemafile["tracked"] == "false" && $schemafile["foldercount"] > 0 && $pathcount == 3  && (in_array("Admin",$user['groups'])))
                            | <a href="{{route('gitRepo.addFile.route', array('path' => $schemafile['path'])) }}">Add to GIT</a>
                        @endif
                    </li>
                @else
                    <li><a href="{{ route('gitRepo.readFile.route', array('path' => $schemafile['path'])) }}"> {{$schemafile['basename']}}</a>
                        @if( in_array("KM",$user['roles']) || in_array("Admin",$user['groups']))
                            | <a href="{{route('gitRepo.deleteFile.route', array('path' => $schemafile['path'], 'isdir' => 0)) }}">Delete</a>
                        @endif
                    </li>
                @endif

            @endforeach
        </ul>


        @if($pathcount == 1 && $path == "" && in_array("GKA",$user['roles']))
            <a href="{{route('gitRepo.createproject.get',array('dirname' => $schemafile['dirname'])) }}" >Create project</a>
        @endif


    @else

        @if($pathcount == 1 && in_array("Admin",$user['groups']))
            <a href="{{route('gitRepo.upload.get',array('dirname' => $path)) }}" >Upload files</a>
        @endif
    @endif
    @if($pathcount == 4)
        <a href="{{route('gitRepo.upload.get',array('dirname' => $path)) }}" >Upload files</a>
    @endif
    <a href="{{ route('gitRepo.route', array('path' => $previouspath)) }}"> <i class="fa fa-hand-o-up fa-3x"></i></a>
@stop
