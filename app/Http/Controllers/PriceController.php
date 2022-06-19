<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show_MO_price(Request $request)
    {
        if(request() ->ajax())
        {
            $week_number = $request -> week_number;
            $market_type = $request -> market_type;

            $match_result = DB::table('real_mo_price_cl')
                ->where('c_week_number', $week_number)
                ->select('refer', 'total', 'c_week_number', 'H','D','A','H_price','D_price','A_price',
                    DB::raw('ROUND(H/total *100, 2) AS H_pro'),
                    DB::raw('ROUND(D/total *100, 2) AS D_pro'),
                    DB::raw('ROUND(A/total *100, 2) AS A_pro')
                );
             

             return datatables($match_result)
                ->toJson();


        }

    }
    public function show_AH_price(Request $request)
    {
        $week_number = $request -> week_number;
        $market_type = $request -> market_type;

        $match_result = DB::table('real_ah_price_cl')
            -> where('c_week_number', $week_number)
            -> where('market', $market_type)
            -> select('refer', 'c_week_number','win','lose','flat','half_win','half_lose','total_win','total_lose', 'grand_total',
                'home_prob','home_price','away_prob','away_price');

            return datatables($match_result)
                ->toJson();
    }
}
