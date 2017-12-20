@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white bg-dark">短網址管理</div>
                <div class="card-block">
                    <div class="container">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <p>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group">
                                <input type="text" class="form-control" v-model="orig_url" placeholder="輸入網址...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" @click="create_short()">建立短網址!</button>
                                </span>
                                </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->
                        <br />
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
                                        <td><a href="/{{ $shrot->short_code }}" target="_blank">/{{ $shrot->short_code }}</a></td>
                                        <td><a href="{{ $shrot->original_url }}" target="_blank">{{ $shrot->original_url }}</a></td>
                                        <td>386</td>
                                        <td>126</td>
                                        <td>43</td>
                                        <td>{{ $shrot->remark }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="/{{ $shrot->short_code }}+" target="_blank">查看統計</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
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
<script>
/*
var postdata = {
    'data1': 'ok!!',
}

axios.post('/api/createshort', postdata, headers)
.then(response => {
    console.log(response.data);
});

*/

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
  },
  methods: {
        create_short: function() {
            let postdata = { original_url: this.orig_url };
            axios.post('/api/createshort', postdata, this.axios_headers)
            .then(response => {
                console.log(response.data);
            });
        }
  },
  mounted: function() {
      console.log('mounted');
  }
})
</script>
@endsection