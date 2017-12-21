<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shorturl;
use App\Click;
use Carbon\Carbon;
use DB;
use Auth;

class ApiController extends Controller
{
    public function clicks_of_days($shortcode)
    {
        $data = new \stdClass;
        $clicks_of_days = Click::where('short_code', $shortcode)->select(DB::raw('date(created_at) as \'date\', count(isRobot) as \'click\''))->groupBy(DB::raw('date(created_at)'))->get();
        $dates = ['x'];
        $clicks = ['日點擊數'];

        foreach ($clicks_of_days as $item) {
            $dates[] = $item->date;
            $clicks[] = $item->click;
        }

        $data->dates = $dates;
        $data->clicks = $clicks;

        return json_encode($data);
    }

    public function report_device_pie($shortcode)
    {
        $data = new \stdClass;
        $data->desktop_count = Click::where('short_code', $shortcode)->where('isDesktop', true)->where('isRobot', false)->count();
        $data->mobile_count = Click::where('short_code', $shortcode)->where('isDesktop', false)->where('isRobot', false)->count();
        $data->robot_count = Click::where('short_code', $shortcode)->where('isRobot', true)->count();
        return json_encode($data);
    }

    public function report_browser_pie($shortcode)
    {
        $data = new \stdClass;
        $items = Click::where('short_code', $shortcode)
               ->select(DB::raw('browser, count(short_code) as \'count\''))
               ->groupBy('browser')->get();
        $result = [];
        foreach ($items as $item) {
            $result[] = [$item->browser, $item->count];
        }

        $data->result = $result;
            
        return json_encode($data);
    }

    public function report_rferrers_pie($shortcode)
    {
        $data = new \stdClass;
        $items = Click::where('short_code', $shortcode)
               ->select(DB::raw('referer_domain, count(short_code) as \'count\''))
               ->groupBy('referer_domain')->get();
        $result = [];
        foreach ($items as $item) {
            $result[] = [$item->referer_domain, $item->count];
        }

        $data->result = $result;

        return json_encode($data);
    }

    public function report_map()
    {
        $data = new \stdClass;
        return json_encode($data);
    }

    public function createshort(Request $req)
    {
        $response = new \stdClass;
        if(filter_var($req->original_url, FILTER_VALIDATE_URL))
        {
            $short_code = $this->_get_unique_short($req->original_url);            
            $result = Shorturl::create([
                'original_url' => $req->original_url,
                'short_code' => $short_code,
                'remark' => $req->remark,
                'created_by' => Auth::user()->id,
            ]);
            $response->Status = 'success';
            $response->Original_url = $req->original_url;
            $response->Short_code = $short_code;
            $response->result = $result;
            $response->user = Auth::user();
        } else {
            $response->Status = 'failure';
            $response->Error_msg = '網址格式錯誤';
        }
        return json_encode($response);
    }
    
    private function _get_unique_short($url)
    {
        $short_code = dwz($url);
        if(Shorturl::where('short_code', $short_code)->count() > 0) return $this->_get_unique_short($url.str_random(40));
        return $short_code;
    }
}
