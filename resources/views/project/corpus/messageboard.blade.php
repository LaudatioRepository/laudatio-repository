<div class="container-fluid">
    <div class="container">
        <div class="row mt-5">

            <div class="col">
                <div class="alert alert-dismissible fade show" role="alert" id="alert-laudatio">
                    <span class="alert-laudatio-message"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if (Auth::user()->can('Can create corpus project') || Auth::user()->can('Can create corpus'))
                <div class="card border-0 mt-5">
                    <div class="card-body bg-bluegrey-dark p-5">
                        <form id="sendMessageBoard" class="form-inline">
                            <textarea id="created_boardmessage" name="created_boardmessage" class="form-control py-1 w-80" cols="20" rows="1" placeholder="Write a message to the board"></textarea>
                            <!-- <button type="submit" disabled class="btn btn-primary rounded text-uppercase font-weight-bold w-15 ml-6">Send</button> -->
                            <a href="#" id="sendMessageButton" class="btn btn-primary rounded text-uppercase font-weight-bold w-15 ml-auto">Send</a>
                            <input type="hidden" id="project_id"  name="project_id" value="{{$corpus_data['project_id']}}" />
                            <input type="hidden" id="user_id"  name="project_id" value="{{$user->id}}" />
                        </form>
                    </div>
                </div>
                @endif
                @foreach($corpus_data['boardmessages'] as $boardmessage)
                    <div class="container bg-bluegrey-midlight mt-1 mb-1 p-5">
                        <div class="row">
                            <div class="col-1 pr-0">
                                <img  class="w-100" src="{{ Avatar::create($boardmessage['user_name'])->toBase64() }}" alt="Text Avatar for {{$boardmessage['user_name']}}" />
                            </div>


                            <div class="col">
                                <div class="h6 font-weight-bold">
                                    {{$boardmessage['user_name']}}
                                </div>
                                <p class="mt-2 mb-0 text-14">
                                    {{$boardmessage['message']}}
                                </p>
                            </div>
                            <div class="col-2 text-right">
                                <div class="dropdown">
                                    <button class="btn btn-outline-corpus-dark dropdown-toggle font-weight-bold text-uppercase rounded mb-4 w-100 text-left"
                                            type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Edit
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @can('Can edit corpus')
                                            <a class="dropdown-item text-14" href="#" id="messageAssignButton">Assign to me</a>
                                            <a class="dropdown-item text-14" href="#" id="completeMessageButton">Mark as completed</a>
                                        @endcan
                                        @can('Can create corpus project')
                                            <a class="dropdown-item text-14" href="#" id="deleteMessageButton">Delete Message</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-grey-light text-14">{{$boardmessage['status']}}</div>
                            </div>
                            <div class="col-2 text-right">
                                <span class="text-grey-light text-14">
                                 {{$boardmessage['last_updated']->diffForHumans()}}
                                 </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row">
            @can('Can create corpus project')
                <p>POOPS</p>
            @endcan

        </div>
    </div>
</div>