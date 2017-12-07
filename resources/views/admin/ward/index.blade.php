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
                                <i class="si si-users"></i> Wards 
                                <button data-toggle="modal" data-target="#new-ward" class="btn btn-sm btn-primary create-hover" type="button">Add New</button>
                            </h3><hr/>
                            <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="block block-content content-hold">
                        @if(count($wards) < 1)
                            <div class="danger-well">
                                <em>There are no ward on this system. User to button above to create a new ward.</em>
                            </div>
                        @else
                            <table class="table table-condensed table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="50"><input type="checkbox" name="" value=""></th>
                                        <th width="50"></th>
                                        <th>Name</th>
                                        <th>State</th>
                                        <th>Lga</th>
                                    </td>
                                </thead>
                                <tbody>
                                    @foreach($wards as $ward)
                                        <tr>
                                            <td><input type="checkbox" name="" value=""></td>
                                            <td><img src="{{ asset('images/default.png') }}" width="26" height="26" /></td>
                                            <td class="user-edit">
                                                <a href="">{{$ward['name']}}</a><br/>
                                                <span id="ward-view" style="display:none;color:grey;" style="font-size: 12px;"><a href="#" data-toggle="modal" data-target="#edit-user{{$ward['id']}}" ><i class="fa fa-edit"></i> Edit</a> | <a href="#" class="danger" id="delete" data-id="{{$ward->id}}"><i class="fa fa-times"></i> delete</a></span>
                                            </td>
                                            <td>{{$ward->state->name}}</td>
                                            <td>{{$ward->lga->name}}</td>
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

@section('extra_script')
<script type="text/javascript">
    $(document).ready(function() {
        $('table.table-condensed tbody tr').on('mouseover',function() {
            $('#ward-view').show();
        });
        $('table.table-condensed tbody tr').on('mouseout',function() {
            $('#ward-view').hide();
        });
        $('#state').on("change",function(){
              var value=$(this).val();      
                  $.ajax({
                    type: 'get',
                    url: "{{URL::route('ward.lga')}}",
                    data: {'state_id':value},
                    success:function(data){
                        console.log(data);
                        $('#local').html('');
                        $('#local').append(data);
                        /*$.each(data,function(index,sublocalObj){
                            $('#local').append('<option value="'+sublocalObj.id+'">'+sublocalObj.name+'</option>');
                        });*/
                    }
                });
              
            });
            $('#submit').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('ward.store')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'name' : $('input[name=name]').val(),
                        'state' : $('select[name=state]').val(),
                        'lga' : $('select[name=local]').val(),
                        'req' : "newWard"
                    },
                    success: function(rst,type,title){
                        $.LoadingOverlay("hide");
                        //swal(title, rst, type);
                        swal("Ward Created Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });
        $("#modal .modal").each(function(i) {
            $('#updateWard'+i).on("click",function() {
                var id=$('#id'+i).val();
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('ward.update')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'id':id,
                        'name' : $('#name'+i).val(),
                        'state' : $('#state'+i).val(),
                        'lga' : $('#local'+i).val(),
                        'req' : "UpdateWard"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Ward Updated Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();

                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });   
        });
        $('#delete').on("click",function(){
            //alert($(this).data('id'));
            $.ajax({
                    url: "{{URL::route('Delete.ward')}}",
                    method: "DELETE",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'id': $(this).data('id'),
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Ward Deleted Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();

                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
        });
    });   
</script>
@endsection
@section('modals')
    @include('admin.ward.modals._new_ward')
    <div id="modal">
    @php($index=0)        
        @foreach($wards as $ward)
            @include('admin.ward.modals._new_edit')
        @php($index++)
        @endforeach
    </div>
@endsection