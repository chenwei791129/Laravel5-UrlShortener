<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shorturl;
use App\Click;
use Carbon\Carbon;
use DB;
use Auth;
use stdClass;

class ApiController extends Controller
{
    public function get_clicks($shortcode)
    {
        $data = new stdClass;

        $shrot = Shorturl::where('short_code', $shortcode)->first();

        $data->link_created = $shrot->created_at;
        $data->all_count = $shrot->clicks()->count();
        $data->month_count = $shrot->clicks()->whereDate('created_at', '>', Carbon::today()->submonth(1))->count();
        $data->week_count = $shrot->clicks()->whereDate('created_at', '>', Carbon::today()->subday(7))->count();
        $data->day_count = $shrot->clicks()->whereDate('created_at', '>', Carbon::today()->subday(1))->count();

        return json_encode($data);
    }

    public function clicks_of_days($shortcode = null)
    {
        $data = new stdClass;
        $select_str = (current_db_driver() == 'sqlsrv') ? 'CAST(created_at AS DATE) as \'cdate\', count(isRobot) as \'click\''
                                                        : 'date(created_at) as \'cdate\', count(isRobot) as \'click\'';
        $groupby_str = (current_db_driver() == 'sqlsrv') ? 'CAST(created_at AS DATE)'
                                                         : 'date(created_at)';
        $clicks_of_days = (empty($shortcode)) ? Click::select(DB::raw($select_str))->groupBy(DB::raw($groupby_str))->get()
                                              : Click::where('short_code', $shortcode)->select(DB::raw($select_str))->groupBy(DB::raw($groupby_str))->get();        
        $data->dates = ['x'];
        $data->clicks = ['日點擊數'];

        foreach ($clicks_of_days as $item) {
            $data->dates[] = $item->cdate;
            $data->clicks[] = $item->click;
        }

        return json_encode($data);
    }

    public function report_device_pie($shortcode = null)
    {
        $data = new stdClass;
        $data->desktop_count = (empty($shortcode)) ? Click::where('isDesktop', true)->where('isRobot', false)->count()
                                                   : Click::where('short_code', $shortcode)->where('isDesktop', true)->where('isRobot', false)->count();
        $data->mobile_count = (empty($shortcode)) ? Click::where('isDesktop', false)->where('isRobot', false)->count()
                                                  : Click::where('short_code', $shortcode)->where('isDesktop', false)->where('isRobot', false)->count();
        $data->robot_count = (empty($shortcode)) ? Click::where('isRobot', true)->count()
                                                 : Click::where('short_code', $shortcode)->where('isRobot', true)->count();
        return json_encode($data);
    }

    public function report_browser_pie($shortcode = null)
    {
        $data = new stdClass;
        $items = (empty($shortcode)) ? Click::select(DB::raw('browser, count(short_code) as \'count\''))
                                       ->groupBy('browser')->get()
                                     : Click::where('short_code', $shortcode)
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
        $data = new stdClass;
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

    public function report_map($shortcode)
    {
        $results = Click::where('short_code', $shortcode)->select(DB::raw('country_from, country_code, count(short_code) as \'count\''))->groupBy('country_from', 'country_code')->get();
      
        $csv = "COUNTRY,click,CODE";
        foreach ($results as $result) {
            $csv .= "\n$result->country_from,$result->count,$result->country_code";
        }
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="'.$shortcode.'.csv"');

        echo $csv;
    }

    public function createshort(Request $req)
    {
        $response = new stdClass;
        if(filter_var($req->original_url, FILTER_VALIDATE_URL) && !empty($req->remark))
        {
            $short_code = $this->_get_unique_short($req->original_url);
            $result = Shorturl::create([
                'original_url' => $req->original_url,
                'short_code' => $short_code,
                'remark' => (empty($req->remark))?'':$req->remark,
                'created_by' => Auth::user()->id,
            ]);
            $response->Status = 'success';
            $response->Original_url = $req->original_url;
            $response->Short_code = $short_code;
            $response->result = $result;
            $response->user = Auth::user();
        } elseif(empty($req->remark)) {
            $response->Status = 'failure';
            $response->Error_msg = '請輸入備註';
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
