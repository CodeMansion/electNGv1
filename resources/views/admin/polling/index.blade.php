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
                                <i class="si si-users"></i> pollings 
                                <button data-toggle="modal" data-target="#new-polling" class="btn btn-sm btn-primary create-hover" type="button">Add New</button>
                            </h3><hr/>
                            <p><a href="{{URL::route('Dashboard')}}"><i class="si si-arrow-left"></i> Return To Dashboard</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="block block-content content-hold">
                        @if(count($pollings) < 1)
                            <div class="danger-well">
                                <em>There are no polling on this system. User to button above to create a new polling.</em>
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
                                        <th>Ward</th>
                                    </td>
                                </thead>
                                <tbody>
                                    @foreach($pollings as $polling)
                                        <tr>
                                            <td><input type="checkbox" name="" value=""></td>
                                            <td><img src="{{ asset('images/default.png') }}" width="26" height="26" /></td>
                                            <td class="user-edit">
                                                <a href="">{{$polling['name']}}</a><br/>
                                                <span id="polling-view" style="display:none;color:grey;" style="font-size: 12px;"><a href="#" data-toggle="modal" data-target="#edit-user{{$polling['id']}}" ><i class="fa fa-edit"></i> Edit</a> | <a href="#" class="danger" id="delete" data-id="{{$polling->id}}"><i class="fa fa-times"></i> delete</a></span>
                                            </td>
                                            <td>{{$polling->state->name}}</td>
                                            <td>{{$polling->lga->name}}</td>
                                            <td>{{$polling->ward->name}}</td>
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
            $('#polling-view').show();
        });
        $('table.table-condensed tbody tr').on('mouseout',function() {
            $('#polling-view').hide();
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
            $('#local').on("change",function(){
                var state =$('#state').val();
              var value=$(this).val();      
                  $.ajax({
                    type: 'get',
                    url: "{{URL::route('polling.ward')}}",
                    data: {'state_id':state,'local_id':value},
                    success:function(data){
                        console.log(data);
                        $('#ward').html('');
                        $('#ward').append(data);
                        /*$.each(data,function(index,sublocalObj){
                            $('#local').append('<option value="'+sublocalObj.id+'">'+sublocalObj.name+'</option>');
                        });*/
                    }
                });
              
            });
            $('#submit').on("click",function() {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('polling.store')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'name' : $('input[name=name]').val(),
                        'state' : $('select[name=state]').val(),
                        'lga' : $('select[name=local]').val(),
                        'ward': $('select[name=ward]').val(),
                        'req' : "newpolling"
                    },
                    success: function(rst,type,title){
                        $.LoadingOverlay("hide");
                        //swal(title, rst, type);
                        swal("polling Created Successfully", "Mail sent successfully in minutes.", "success");
                        location.reload();
                    },
                    error: function(rst){
                        $.LoadingOverlay("hide");
                        swal("Oops! Error","An Error Occured!", "error");
                    }
                });
            });
        $("#modal .modal").each(function(i) {
            $('#updatepolling'+i).on("click",function() {
                var id=$('#id'+i).val();
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{URL::route('polling.update')}}",
                    method: "POST",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'id':id,
                        'name' : $('#name'+i).val(),
                        'state' : $('#state'+i).val(),
                        'lga' : $('#local'+i).val(),
                        'ward' : $('#ward'+i).val(),
                        'req' : "Updatepolling"
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("polling Updated Successfully", "Mail sent successfully in minutes.", "success");
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
                    url: "{{URL::route('Delete.polling')}}",
                    method: "DELETE",
                    data:{
                        '_token': "{{csrf_token()}}",
                        'id': $(this).data('id'),
                    },
                    success: function(rst){
                        $.LoadingOverlay("hide");
                        swal("polling Deleted Successfully", "Mail sent successfully in minutes.", "success");
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
    @include('admin.polling.modals._new_polling')
    <div id="modal">
    @php($index=0)        
        @foreach($pollings as $polling)
            @include('admin.polling.modals._new_edit')
        @php($index++)
        @endforeach
    </div>
@endsection