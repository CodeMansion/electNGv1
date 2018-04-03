<div class="row">
    <div class="col-md-6">
        <table class="table table-striped table-hover" id="sample_2">
            <tbody>
                @php($index=0)
                @foreach($pollingStations as $station)
                    <tr>
                        <td>{{$station['name']}}</td>
                        <td></td>
                    </tr>
                @php($index++)
                @endforeach
            </tbody>
        </table>
    </div>
</div>
