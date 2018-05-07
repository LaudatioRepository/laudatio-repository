<div class="container-fluid">
    <div class="container">
        <div class="row mt-5">

            <div class="col">
                <div class="d-flex justify-content-between mt-2 ">
                    <h3 class="h3 font-weight-normal">Corpus Message Board</h3>
                </div>

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
                                          <span class="text-grey-light text-14">
                                           {{$boardmessage['last_updated']->diffForHumans()}}
                                          </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 text-right">
                                <div class="text-grey-light text-14">{{$boardmessage['status']}}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>