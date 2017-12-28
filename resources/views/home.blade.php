@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div id="browser"></div>
        </div>
        <div class="col-md-6">
            <div id="device"></div>
        </div>
        <div class="col-md-12">
                <div id="clicks"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
var axios_headers = {
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer {{ $accessToken }}'
    }
}
// 點擊折線圖
axios.get("{{ url('api/click_chart') }}", axios_headers)
.then(response => {
    let chart_data = {
        x: 'x',
        columns: []
    }
    chart_data.columns.push(response.data.dates);
    chart_data.columns.push(response.data.clicks);
    c3.generate({
        bindto: '#clicks',
        data: chart_data,
        axis: {
            x: {
                type: 'timeseries',
                tick: { format: '%Y-%m-%d' }
            }
        }
    });
});
console.log('call draw_click_chart finish!');
// 裝置比例
axios.get("{{ url('api/device_chart') }}", axios_headers)
.then(response => {
    let chart_data = {
        type: 'donut',
        columns: []
    }
    chart_data.columns.push(['桌上型裝置', response.data.desktop_count]);
    chart_data.columns.push(['行動裝置', response.data.mobile_count]);
    chart_data.columns.push(['爬蟲', response.data.robot_count]);
    c3.generate({
        bindto: '#device',
        data: chart_data,
        donut: {
            title: "裝置比例"
        }
    });
});
console.log('call draw_device_pie finish!');
// 瀏覽器比例
axios.get("{{ url('api/browser_chart') }}", axios_headers)
.then(response => {
    let chart_data = {
        type : 'donut',
        columns: []
    }
    chart_data.columns = response.data.result;
    c3.generate({
        bindto: '#browser',
        data: chart_data,
        donut: {
            title: "瀏覽器比例"
        }
    });
});
console.log('call draw_browser_pie finish!');
</script>
@endsection
