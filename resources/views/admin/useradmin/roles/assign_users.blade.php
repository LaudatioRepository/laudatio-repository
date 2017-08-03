@extends('layouts.admin', ['isLoggedIn' => $isLoggedIn])

@section('content')
    <div class="role-user-container col-lg-10">
        <div class="row">
            <div class="col-lg-12 bhoechie-tab-container">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 bhoechie-tab-menu">
                    <div class="list-group">
                        @foreach($roles as $role)
                            @if($loop->index == 0)
                                <a href="#" class="list-group-item active text-center">
                                    <h4 class="fa fa-users"></h4><br/>{{$role->name}}
                                </a>
                            @else
                                <a href="#" class="list-group-item text-center">
                                    <h4 class="fa fa-users"></h4><br/>{{$role->name}}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="bhoechie-tab">
                    @foreach($roles as $role)
                        @if($loop->index == 0)
                            <div class="bhoechie-tab-content active">
                                @else
                                    <div class="bhoechie-tab-content">
                                        @endif
                                        <div class="container">
                                            <div class="dual-list list-left col-md-3">
                                                <div class="well text-left">
                                                    <div class="row">
                                                        Assign users to {{$role->name}}
                                                    </div>
                                                    @if($loop->index == 0)
                                                        <ul class="list-group active" data-roleid="{{$role->id}}" id="ul_{{$loop->index}}">
                                                            @else
                                                                <ul class="list-group" data-roleid="{{$role->id}}" id="ul_{{$loop->index}}">
                                                                    @endif

                                                                </ul>
                                                </div>
                                            </div>


                                            <div class="list-arrows col-md-1 text-center">
                                                <button class="btn btn-default btn-sm move-left">
                                                    <span class="fa fa-chevron-left"></span>
                                                </button>
                                            </div>
                                            <div class="list-arrows col-md-1 text-center">
                                                <button class="btn btn-default btn-sm move-right">
                                                    <span class="fa fa-chevron-right"></span>
                                                </button>
                                            </div>

                                            <div class="dual-list list-right col-md-3">
                                                <div class="well">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="btn-group">
                                                                <a class="btn btn-default selector" title="select all"><i class="fa fa-unchecked"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="input-group">
                                                                <input type="text" name="SearchDualList" class="form-control" placeholder="search" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($loop->index == 0)
                                                        <ul class="list-group active" id="ul_{{$loop->index}}">
                                                            @else
                                                                <ul class="list-group" id="ul_{{$loop->index}}">
                                                                    @endif
                                                                    @foreach($users as $user)
                                                                        <li class="list-group-item"  data-userid="{{$user->id}}" ><i class="fa fa-user fa-fw"></i> {{$user->name}}</li>
                                                                    @endforeach
                                                                </ul>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    @endforeach
                            </div>
                </div>
            </div>
            <br />
            <button type="submit" value="Create" id="assignButton" class="btn btn-primary pull-right">Assign users</button>
        </div>
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
    </div>
    <div class="col-lg-12">
        @include('layouts.errors')
    </div>
    <script>
        $(function () {

            $('div.bhoechie-tab>div.bhoechie-tab-content>div.container>div.dual-list.list-left>div.well').on('click', '.list-group .list-group-item', function () {
                $(this).toggleClass('active');
            });

            $('div.bhoechie-tab>div.bhoechie-tab-content>div.container>div.dual-list.list-right>div.well').on('click', '.list-group .list-group-item', function () {
                $(this).toggleClass('active');
            });


            $('.list-arrows button').click(function () {
                var $button = $(this), actives = '';
                if ($button.hasClass('move-left')) {
                    actives = $('.list-right ul.active li.active');
                    actives.clone().appendTo('.list-left ul.active');
                    actives.remove();
                } else if ($button.hasClass('move-right')) {
                    actives = $('.list-left ul.active li.active');
                    actives.clone().appendTo('.list-right ul.active');
                    actives.remove();
                }
            });
            $('.dual-list .selector').click(function () {
                var $checkBox = $(this);
                if (!$checkBox.hasClass('selected')) {
                    $checkBox.addClass('selected').closest('.well').find('ul li:not(.active)').addClass('active');
                    $checkBox.children('i').removeClass('fa-unchecked').addClass('fa-check');
                } else {
                    $checkBox.removeClass('selected').closest('.well').find('ul li.active').removeClass('active');
                    $checkBox.children('i').removeClass('fa-check').addClass('fa-unchecked');
                }
            });
            $('[name="SearchDualList"]').keyup(function (e) {
                var code = e.keyCode || e.which;
                if (code == '9') return;
                if (code == '27') $(this).val(null);
                var $rows = $(this).closest('.dual-list').find('.list-group li');
                var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
                $rows.show().filter(function () {
                    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                    return !~text.indexOf(val);
                }).hide();
            });



            $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();

                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content>div.container>div.dual-list.list-left>div.well>ul.list-group").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content>div.container>div.dual-list.list-right>div.well>ul.list-group").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content>div.container>div.dual-list.list-left>div.well>ul.list-group").eq(index).addClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content>div.container>div.dual-list.list-right>div.well>ul.list-group").eq(index).addClass("active");

            });
        });

        $('#assignButton').on('click', function(){
            var token = $('#_token').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var postData = {}
            postData.token = token;
            postData.role_users = {}
            var list_lefts = $('.list-left ul');
            $(list_lefts).each(function () {
                var roleid = $(this).data('roleid');
                $(this).children('li.list-group-item.active').each(function () {
                    if(typeof postData.role_users[roleid] == 'undefined'){
                        postData.role_users[roleid] = []
                    }
                    postData.role_users[roleid].push($(this).data('userid'));
                });

            })
            //console.log(role_users);


            $.ajax({
                url: "/api/adminapi/userroles",
                type:"POST",
                data: postData,
                async: true,
                statusCode: {
                    500: function () {
                        alert("server down");
                    }
                },
                success:function(data){
                    console.log(data);
                    var flashMessage = '<div id="flash-message" class="alert alert-success"> '+data.msg+' </div>';
                    $('#page-wrapper').append(flashMessage);
                },error:function(){
                    console.log("error!!!!");
                }
            }); //end of ajax


        });
    </script>
@endsection