<div class="row">
    <div class="col-sm-3">
        <div id="channel_kuang">
            渠道 : <select class="form-control input-sm" id="channel" name="datatable-responsive_channel" aria-controls="datatable-responsive">
                <option value="0">全部</option>
                @foreach($channels as $k => $v)
                    <option value="{{$v}}">{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div id="area_kuang">
            区服 : <select class="form-control input-sm" id="area" name="datatable-responsive_area" aria-controls="datatable-responsive">
                <option value="0">全部</option>
                @foreach($areas as $k => $v)
                    <option value="{{$v}}">{{$v}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>