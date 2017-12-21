@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header">儀表板</div>

                <div class="card-block">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
var chart = c3.generate({
    data: {
        columns: [
            ['行動裝置', 30],
            ['桌上型裝置', 120],
        ],
        type : 'donut',
        onclick: function (d, i) { console.log("onclick", d, i); },
        onmouseover: function (d, i) { console.log("onmouseover", d, i); },
        onmouseout: function (d, i) { console.log("onmouseout", d, i); }
    },
    donut: {
        title: "裝置比例"
    }
});
</script>
@endsection
