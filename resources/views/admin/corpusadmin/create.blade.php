@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="content">
        <h1>Create a new Corpus</h1>
        <form action="/admin/corpora" method="post">
            {{ csrf_field() }}
            <div class="form-group>">
                <label for="corpus_name">Corpus Name</label>
                <input type="text" name="corpus_name" id="corpus_name" class="form-control" />
            </div>
            <br /><br />
            <div class="form-group>">
                <label for="corpus_description">Corpus Description</label>
                <textarea name="corpus_description" id="corpus_description" placeholder="Write a description for your Corpus"  class="form-control"></textarea>
            </div>

            <div class="form-group>">
                <button type="submit" value="Create" class="btn btn-primary ">Create Corpus</button>
            </div>

            @include('layouts.errors')
        </form>

    </div>
@endsection