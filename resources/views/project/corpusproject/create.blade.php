@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="content">
        <h1>Create a new Corpus project</h1>
        <form action="/project/corpusprojects" method="post">
            {{ csrf_field() }}
            <div class="form-group>">
                <label for="corpusproject_name">Corpus Project Name</label>
                <input type="text" name="corpusproject_name" id="corpusproject_name" class="form-control" />
            </div>
            <br /><br />
            <div class="form-group>">
                <label for="corpusproject_description">Corpus Project Description</label>
                <textarea name="corpusproject_description" id="corpusproject_description" placeholder="Write a description for your Corpus Project"  class="form-control"></textarea>
            </div>

            <div class="form-group>">
                <button type="submit" value="Create" class="btn btn-primary ">Create Corpus Project</button>
            </div>

            @include('layouts.errors')
        </form>

    </div>
@endsection