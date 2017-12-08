<div class="row">
    <div class="col-6">
        <table class="table table-striped table-vcenter table-condensed table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>PASSCODE</th>
                    <th>TOKEN</th>
                    <th>STATUS</th>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @php($count=1)
                @foreach($approvedPasscodes as $code)
                    <tr>
                        <td>{{$count}}</td>
                        <td>
                            @if($code->status == 1)
                                <span class="view-passcode" id="{{$code->id}}">{{$code->passcode}}</span>
                            @else
                                <a href="javascript:void(0);" class="view-passcode" id="{{$code->id}}">{{$code->passcode}}</a>
                            @endif
                        </td>
                        <td>{{str_limit($code->token,20)}}</td>
                        <td>
                            @if($code->status == 1)
                                <span class="badge badge-warning"> Unused</span>
                            @elseif($code->status == 2)
                                <span class="badge badge-success"> Used</span>
                            @else
                                <span class="badge badge-success"> Used</span>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                @php($count++)
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-6"></div>
</div>