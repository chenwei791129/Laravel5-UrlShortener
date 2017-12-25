@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white bg-dark">短網址管理</div>
                <div class="card-block">
                    <div class="container">
                        <p>
                            <div id="alert" class="alert alert-warning hide" role="alert">
                                <strong>發生問題！</strong> @{{ error_msg }}！
                            </div>
                        </p>
                        <p>
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="input-group">
                                <input type="text" class="form-control col-sm-6" v-model="orig_url" placeholder="輸入網址...">
                                <input type="text" class="form-control col-sm-2" v-model="remark" placeholder="輸入備註...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" @click="create_short()">建立短網址!</button>
                                </span>
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->
                        </p>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-responsive">
                                    <tr>
                                        <th>建立日期</th>
                                        <th>短網址</th>
                                        <th>原始網址</th>
                                        <th>月點擊</th>
                                        <th>周點擊</th>
                                        <th>日點擊</th>
                                        <th>備註</th>
                                        <th>操作</th>
                                    </tr>
                                    @foreach($shrots as $shrot)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($shrot->created_at)->format('Y/m/d') }}</td>
                                        <td>
                                            <button class="btn btn-link clipboard" data-clipboard-text="{{ url($shrot->short_code) }}" data-toggle="tooltip" data-placement="bottom" title="">/{{ $shrot->short_code }}</button>
                                        </td>
                                        <td><a class="btn btn-link max-witdth-25vw" href="{{ url($shrot->original_url) }}" target="_blank">{{ $shrot->original_url }}</a></td>
                                        <td>{{ $shrot->month_click }}</td>
                                        <td>{{ $shrot->week_click }}</td>
                                        <td>{{ $shrot->day_click }}</td>
                                        <td>{{ $shrot->remark }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ url($shrot->short_code) }}+" target="_blank">查看統計</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                {{ $shrots->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.7.1/clipboard.min.js"></script>
<script>
var clipboard = new Clipboard('.clipboard');
clipboard.on('success', function(e) {
    $(e.trigger).attr('title', '已複製！');
    $(e.trigger).tooltip('show');
    e.clearSelection();
    setTimeout(function (){
        $(e.trigger).tooltip("dispose");
    }, 1000);
    
});
new Vue({
  el: '#app',
  data: {
    axios_headers: {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer {{ $accessToken }}'
        }
    },
    orig_url: null,
    remark: '',
    error_msg: '',
    
  },
  methods: {
        create_short: function() {
            let postdata = { original_url: this.orig_url, remark: this.remark };
            axios.post("{{ url('api/createshort') }}", postdata, this.axios_headers)
            .then(response => {
                if(response.data.Status === 'success') window.location.reload();
                else {
                    this.error_msg = response.data.Error_msg;
                    $("#alert").removeClass('hide');
                }
            });
        }
  }
})
</script>
@endsection