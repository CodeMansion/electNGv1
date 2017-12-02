@extends('partials.app')

@section('content')
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <div class="row" style="">
                <div class="col-12 col-xl-12">
                    <div class="block block-content title-hold">
                        <div class="col-md-12">
                            <h3 style="margin-bottom:5px;">
                                <i class="si si-users"></i> Users 
                                <button data-toggle="modal" data-target="#new-user" class="btn btn-sm btn-primary create-hover" type="button">Add New</button>
                            </h3><hr/>
                            <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                            @include('partials.notifications')
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="block block-content content-hold">
                        @if(count($users) < 1)
                            <div class="danger-well">
                                <em>There are no users on this system. User to button above to create a new user.</em>
                            </div>
                        @else
                            <table class="table table-condensed table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="50"><input type="checkbox" name="" value=""></th>
                                        <th width="50"></th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                    </td>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td><input type="checkbox" name="" value=""></td>
                                            <td><img src="{{ asset('images/default.png') }}" width="26" height="26" /></td>
                                            <td class="user-edit">
                                                <a href="">{{$user['username']}}</a><br/>
                                                <span id="user-view" style="display:none;color:grey;" style="font-size: 12px;"><a href="#"><i class="fa fa-edit"></i> Edit</a> | <a href="#"><i class="fa fa-eye"></i> View</a></span>
                                            </td>
                                            <td>{{$user->profile->first_name.' '.$user->profile->last_name}}</td>
                                            <td>{{$user['email']}}</td>
                                            <td>{{$user->roles()->pluck('name')->implode('|')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('modals')
    @include('admin.users.modals._new_user')
@endsection