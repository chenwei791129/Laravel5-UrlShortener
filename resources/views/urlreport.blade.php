@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="row">
        <div class="col-lg-8 word-break-all">
            <h1><a href="{{ url($shrot->short_code) }}" class="card-link" target="_blank">/{{ $shrot->short_code }}</a></h1>
            <h4>原始網址：<a href="{{ $shrot->original_url }}" class="card-link" target="_blank">{{ $shrot->original_url }}</a></h4>
            <h4>備註：{{ $shrot->remark }}</h4>
            <h4>建立日期：{{ $shrot->created_at }}</h4>
        </div>
        <div class="col-lg-4">
            <h4>總點擊數：{{ $shrot->total_click }}</h4>
            <h4>月點擊數：{{ $shrot->month_click }}</h4>
            <h4>周點擊數：{{ $shrot->week_click }}</h4>
            <h4>日點擊數：{{ $shrot->day_click }}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">每日流量</div>
                <div class="card-block">
                    <div class="container">
                        <div id="month_clicks">
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="card">
                <div class="card-header">瀏覽地區*</div>
                <div class="card-block">
                    <div class="container">
                        <div id="map">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">瀏覽器比例</div>
                <div class="card-block">
                    <div class="container">
                        <div id="browser">
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="card">
                <div class="card-header">裝置比例</div>
                <div class="card-block">
                    <div class="container">
                        <div id="device">
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="card">
                <div class="card-header">來源</div>
                <div class="card-block">
                    <div class="container">
                        <div id="rferrers">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
new Vue({
  el: '#app',
  data: {
    axios_headers: {
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer {{ $accessToken }}'
        }
    }    
  },
  methods: {
        draw_click_chart: function() {
            axios.get("{{ url('api/click_chart/'.$shrot->short_code) }}", this.axios_headers)
            .then(response => {
                let chart_data = {
                    x: 'x',
                    columns: []
                }
                chart_data.columns.push(response.data.dates);
                chart_data.columns.push(response.data.clicks);
                window.c3.generate({
                    bindto: '#month_clicks',
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
        },
        draw_device_pie: function() {
            axios.get("{{ url('api/device_chart/'.$shrot->short_code) }}", this.axios_headers)
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
        },
        draw_browser_pie: function() {
            axios.get("{{ url('api/browser_chart/'.$shrot->short_code) }}", this.axios_headers)
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
        },
        draw_rferrers_pie: function() {
            axios.get("{{ url('api/rferrers_chart/'.$shrot->short_code) }}", this.axios_headers)
            .then(response => {
                let chart_data = {
                    type : 'donut',
                    columns: []
                }
                chart_data.columns = response.data.result;
                c3.generate({
                    bindto: '#rferrers',
                    data: chart_data,
                    donut: {
                        title: "點擊來源"
                    }
                });
            });
            console.log('call draw_rferrers_pie finish!');
        },
        draw_click_map: function() {
            console.log('call draw_click_map finish!');
        }
  },
  mounted: function() {
      console.log('mounted!');
      this.draw_click_chart();
      this.draw_device_pie();
      this.draw_browser_pie();
      this.draw_rferrers_pie();
      //this.draw_click_map();
  }
})

Plotly.d3.csv("{{ url('api/map_chart/'.$shrot->short_code) }}").header("Authorization", 'Bearer {{ $accessToken }}').get(function(err, rows) {
    function unpack(rows, key) {
        return rows.map(function(row) { return row[key]; });
    }
    
    var data = [{
        type: 'choropleth',
        locations: unpack(rows, 'CODE'),
        z: unpack(rows, 'click'),
        text: unpack(rows, 'COUNTRY'),
        colorscale: [[0,'rgb(5, 10, 172)'],[0.35,'rgb(40, 60, 190)'],[0.5,'rgb(70, 100, 245)'], [0.6,'rgb(90, 120, 245)'],[0.7,'rgb(106, 137, 247)'],[1,'rgb(220, 220, 220)']],
        autocolorscale: false,
        reversescale: true,
        marker: {
            line: {
            color: 'rgb(180,180,180)',
            width: 0.5
            }
        },
        tick0: 0,
        zmin: 0,
        dtick: 1000,
        colorbar: {
            autotic: false,
            tickprefix: '',
            title: '點擊數'
        }
    }];
    var layout = {
        title: '',
        geo:{
        showframe: false,
        showcoastlines: false,
        projection:{
            type: 'mercator'
        }
        }
    };
    Plotly.plot(map, data, layout, {showLink: false});
});
</script>
@endsection
