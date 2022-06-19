<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricDataController extends Controller
{
    //
    private $stake_val;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getStake( $actual_odd, $real_odd)
    {
        $stake_val = $this -> stake_val;
        $percent =  (1 / $real_odd);
   
        //percent = percent.toFixed
        $stake = (($actual_odd -1) * $percent - (1 - $percent)) / ($actual_odd - 1) * $stake_val;
        
        
        return round($stake, 2);
    }
    
    public function showFullRankingTable_MO(Request $request)        // show all dynamc ranking values for selected all games
    {
    
        if(request()->ajax()) 
        {
            $season_id_array = $request -> season_id_array;
            $season_id_array = explode(",", $season_id_array);

            $league_id_array = $request -> league_id_array;
            $league_id_array = explode(",", $league_id_array);
            
            $weeknumber_array = $request -> weeknumber_array;
            if ($weeknumber_array){
                $weeknumber_array = explode(",", $weeknumber_array);
                foreach ($weeknumber_array as $weeknumber)
                {
                    $weeknumber = trim($weeknumber);
    
                }
            }
            
            
            
            $this -> stake_val = $request -> stake_val;
           
            $match_result = DB::table('season_match_plan as a')
                ->join('team_list as b', 'b.team_id', '=', 'a.home_team_id')
                ->join('team_list as c', 'c.team_id', '=', 'a.away_team_id')
                ->join('season as d', 'd.season_id', '=', 'a.season_id')
                ->join('league as e', 'e.league_id', '=', 'a.league_id')
                ->join('season_league_team_info as f', 
                    function($join) 
                    {
                        $join->on('a.season_id', '=','f.season_id');
                        $join->on('a.home_team_id', '=', 'f.team_id');
                    })
                ->join('season_league_team_info as g', 
                    function($join) 
                    {
                        $join->on('a.season_id', '=','g.season_id');
                        $join->on('a.away_team_id', '=', 'g.team_id');
                    })
               
                
                ->leftJoin('odds as h2',
                    function($join) 
                    {
                        $join->on('a.match_id', '=','h2.match_id');
                        $join->on('h2.bookmaker_id', '=', DB::raw('(SELECT id FROM bookmakers WHERE bookmaker_name = "highest")'));
                    }
                )
                ->leftjoin('real_mo_price_cl as r', 'a.CL_mo_refer_id', '=', 'r.id')
                -> where(
                    'a.status', '=', 'END'
                )
                
                -> where(function($q) use($season_id_array)
                {
                   
                    $q -> orwhereIn('a.season_id', $season_id_array);
                    
                })
           
                -> where(function($q) use($league_id_array){
                    
                    $q -> orwhereIn('a.league_id', $league_id_array);
                })
                ->when($weeknumber_array, function($query, $weeknumber_array) {
                    $query -> where(function($q) use($weeknumber_array){
                    
                        $q -> orwhereIn('a.c_WN', $weeknumber_array);
                    });
                })
               
                // ->when($weeknumber_date, function($query, $weeknumber_date) {
                //     $query -> where( 'c_WN', '=' ,function ($q)use($weeknumber_date){
                //         $q -> select('week') ->from('date_week_map') ->where('date','=', $weeknumber_date);
                //     });
                // })

                -> select(
                    'e.league_title' , 
                    'd.season_title' , 
                    'a.date' , 
                    'a.c_WN' , 
                    DB::raw(" CONCAT(b.`team_name` , ' : ', c.`team_name` ) AS Game"),

                    DB::raw("CONCAT ( (SELECT IF ((SELECT cream_status FROM cream_team_list  WHERE team_id = a.home_team_id and season_id = a.season_id) != 'Non-Cream',(SELECT cream_status FROM cream_team_list WHERE team_id = a.home_team_id and season_id = a.season_id) ,'Non-Cream' )), 
                    ' v ' , 
                    (SELECT IF ((SELECT cream_status FROM cream_team_list WHERE team_id = a.away_team_id and season_id = a.season_id) != 'Non-Cream',(SELECT cream_status FROM cream_team_list WHERE team_id = a.away_team_id and season_id = a.season_id ) ,'Non-Cream' ))) AS cream_status") , 

                    DB::raw("CONCAT('<a href=\"eachMatch/', TO_BASE64(a.`match_id`), '\" target=\"_blank\">', CONCAT(a.`total_home_score` , ' : ', a.`total_away_score`), '</a>') AS Score"),
                     'a.total_home_score',
                     'a.total_away_score',
                    DB::raw('b.`team_name` AS Home_team_name'),
                 
                    'a.home_team_strength',
                    DB::raw(' c.`team_name` AS Away_team_name'),
                 
                    'a.Away_team_strength',
                    DB::raw('CONCAT(f.`S_H_ranking`, " v " , g.`S_A_ranking`) AS staticRank'),
                    DB::raw('CONCAT(a.`D_Home_ranking_8`, " v ", a.`D_Away_ranking_8`) AS DynamicRank_8'),
                    DB::raw('CONCAT(a.`D_Home_ranking_6`, " v ", a.`D_Away_ranking_6`) AS DynamicRank_6'),
                    'h2.Home',
                    'h2.Draw',
                    'h2.Away',
                    'r.H_price',
                    'r.D_price',
                    'r.A_price'

                );

        
            return datatables($match_result)
                ->editColumn('Score', function($match_result) {
                    return html_entity_decode($match_result->Score);
                })
                ->addColumn('home_bet', function($match_result){
                    if($match_result -> H_price){
                        if($match_result -> Home > $match_result -> H_price)
                        {
                            return "Bet";
                        }
                        else{
                            return "No Bet";
                        }
                    }
                   
                })
                ->addColumn('draw_bet', function($match_result){
                    if($match_result -> D_price){
                        if($match_result -> Draw > $match_result -> D_price)
                        {
                            return "Bet";
                        }
                        else{
                            return "No Bet";
                        }
                    }
                   
                })
                ->addColumn('away_bet', function($match_result){
                    if($match_result -> A_price){
                        if($match_result -> Away > $match_result -> A_price)
                        {
                            return "Bet";
                        }
                        else{
                            return "No Bet";
                        }
                    }
                   
                })
                ->addColumn('home_stake', function($match_result){
                    if($match_result -> H_price)
                    {
                        if($match_result -> Home > $match_result -> H_price)
                        {
                            return $this->getStake( $match_result -> Home,  $match_result -> H_price);
                        }
                        else{
                            return "0";
                        }
                    }
                   
                })
                ->addColumn('draw_stake', function($match_result){
                    if($match_result -> D_price)
                    {
                        if($match_result -> Draw > $match_result -> D_price)
                        {
                            return $this->getStake(  $match_result -> Draw , $match_result -> D_price);  // getstake(actual_price, real_price)
                        }
                        else{
                            return "0";
                        }
                    }
                   
                })
                ->addColumn('away_stake', function($match_result){
                    if($match_result -> A_price)
                    {
                        if($match_result -> Away > $match_result -> A_price)
                        {
                            return $this->getStake( $match_result -> Away , $match_result -> A_price);
                        }
                        else{
                            return "0";
                        }
                    }
                   
                })
                ->addColumn('home_pnl', function($match_result)
                {
                    if($match_result -> H_price)
                    {
                        if($match_result -> Home > $match_result -> H_price)
                        {
                            $home_Stake =  $this->getStake( $match_result -> Home , $match_result -> H_price);
                            $home_pnl = ($match_result -> total_home_score > $match_result -> total_away_score) ? $home_Stake * ($match_result -> Home- 1): (0 - $home_Stake);
                            return round($home_pnl, 2);
                        }
                        else{
                            return "0";
                        }
                    }
                   
                })
                ->addColumn('draw_pnl', function($match_result)
                {
                    if($match_result -> D_price)
                    {
                        if($match_result -> Draw > $match_result -> D_price)
                        {
                            $Draw_Stake =  $this->getStake( $match_result -> Draw,  $match_result -> D_price);
                            $draw_pnl = ($match_result -> total_home_score == $match_result -> total_away_score) ? $Draw_Stake * ($match_result -> Draw - 1): (0 - $Draw_Stake);
                            return round($draw_pnl, 2);
                        }
                        else{
                            return "0";
                        }
                    }
                   
                })
                ->addColumn('away_pnl', function($match_result)
                {
                    if($match_result -> A_price)
                    {
                        if($match_result -> Away > $match_result -> A_price)
                        {
                            $Away_Stake =  $this->getStake( $match_result -> Away,  $match_result -> A_price);
                            $away_pnl = ($match_result -> total_home_score < $match_result -> total_away_score) ? $Away_Stake * ($match_result -> Away - 1): (0 - $Away_Stake);
                            return round($away_pnl, 2);
                        }
                        else{
                            return "0";
                        }
                    }
                   
                })
                ->rawColumns(['Score'])
           
                ->toJson();
        }
    }

    public function showFullRankingTable_OU(Request $request)        // show all dynamc ranking values for selected all games
    {
    
        if(request()->ajax()) 
        {
            $season_id_array = $request -> season_id_array;
            $season_id_array = explode(",", $season_id_array);
            $league_id_array = $request -> league_id_array;
            $league_id_array = explode(",", $league_id_array);
            $weeknumber_array = $request -> weeknumber_array;
            if ($weeknumber_array){
                $weeknumber_array = explode(",", $weeknumber_array);
                foreach ($weeknumber_array as $weeknumber)
                {
                    $weeknumber = trim($weeknumber);
    
                }
            }

           
            $match_result = DB::table('season_match_plan as a')
            ->join('team_list as b', 'b.team_id', '=', 'a.home_team_id')
            ->join('team_list as c', 'c.team_id', '=', 'a.away_team_id')
            ->join('season as d', 'd.season_id', '=', 'a.season_id')
            ->join('league as e', 'e.league_id', '=', 'a.league_id')
            ->join('season_league_team_info as f', 
                function($join) 
                {
                    $join->on('a.season_id', '=','f.season_id');
                    $join->on('a.home_team_id', '=', 'f.team_id');
                })
            ->join('season_league_team_info as g', 
                function($join) 
                {
                    $join->on('a.season_id', '=','g.season_id');
                    $join->on('a.away_team_id', '=', 'g.team_id');
                })
            
            
            ->leftJoin('odds as h2',
                function($join) 
                {
                    $join->on('a.match_id', '=','h2.match_id');
                    $join->on('h2.bookmaker_id', '=', DB::raw('(SELECT id FROM bookmakers WHERE bookmaker_name = "highest")'));
                }
            )
            ->leftjoin('real_price_dcl as r', 'a.DCL_refer_id', '=', 'r.id')
            -> where(
                'a.status', '=', 'END'
            )
            
            -> where(function($q) use($season_id_array){
                for($i = 0; $i < sizeof($season_id_array); $i++)
                {
                    $q -> orwhere('a.season_id', '=', $season_id_array[$i]);
                }
                
            })
            -> where(function($q) use($league_id_array){
                for($i = 0; $i < sizeof($league_id_array); $i++)
                {
                    $q -> orwhere('a.league_id', '=', $league_id_array[$i]);
                }
                
            })
            ->when($weeknumber_array, function($query, $weeknumber_array) {
                $query -> where(function($q) use($weeknumber_array){
                
                    $q -> orwhereIn('a.c_WN', $weeknumber_array);
                });
            })
            -> select(
                'e.league_title' , 
                'd.season_title' , 
                'a.date' , 
                'a.c_WN' , 
                DB::raw(" CONCAT(b.`team_name` , ' : ', c.`team_name` ) AS Game"),
                DB::raw("CONCAT ( (SELECT IF ((SELECT cream_status FROM cream_team_list  WHERE team_id = a.home_team_id and season_id = a.season_id) != 'Non-Cream',(SELECT cream_status FROM cream_team_list WHERE team_id = a.home_team_id and season_id = a.season_id) ,'Non-Cream' )), 
                ' v ' , 
                (SELECT IF ((SELECT cream_status FROM cream_team_list WHERE team_id = a.away_team_id and season_id = a.season_id) != 'Non-Cream',(SELECT cream_status FROM cream_team_list WHERE team_id = a.away_team_id and season_id = a.season_id ) ,'Non-Cream' ))) AS cream_status") , 
                DB::raw("CONCAT('<a href=\"eachMatch/', TO_BASE64(a.`match_id`), '\" target=\"_blank\">', CONCAT(a.`total_home_score` , ' : ', a.`total_away_score`), '</a>') AS Score"),
                 'a.total_home_score',
                 'a.total_away_score',
                DB::raw('b.`team_name` AS Home_team_name'),
                // 'a.Home_TGPR',
                // 'f.S_H_ranking',
                // 'a.D_Home_RS_8',
                // 'a.D_Home_ranking_8',
                // 'a.D_Home_RS_6',
                // 'a.D_Home_ranking_6',
                // 'a.home_team_score',
                'a.home_team_strength',
                DB::raw(' c.`team_name` AS Away_team_name'),
                // 'a.Away_TGPR',
                // 'g.S_A_ranking',
                // 'a.D_Away_RS_8',
                // 'a.D_Away_ranking_8',
                // 'a.D_Away_RS_6',
                // 'a.D_Away_ranking_6',
                // 'a.Away_team_score',
                'a.Away_team_strength',
                DB::raw('CONCAT(f.`S_H_ranking`, " v " , g.`S_A_ranking`) AS staticRank'),
                DB::raw('CONCAT(a.`D_Home_ranking_8`, " v ", a.`D_Away_ranking_8`) AS DynamicRank_8'),
                DB::raw('CONCAT(a.`D_Home_ranking_6`, " v ", a.`D_Away_ranking_6`) AS DynamicRank_6'),
                DB::raw('h2.Over2d5 AS highest_Over'),
                DB::raw('h2.Under2d5 AS highest_Under')

                //DB::raw('r.H_price AS Real_Home'),
                //DB::raw('r.D_price AS Real_Draw'),
                

                
            );
  
          
           
       
            
            return DataTables()::of($match_result)
                ->editColumn('Score', function($match_result) {
                    return html_entity_decode($match_result->Score);
                })
               
                ->rawColumns(['Score'])
                
                ->make(true);
                
        }
    }

    public function showFullRankingTable_AH(Request $request)        // show all dynamc ranking values for selected all games
    {
    
        if(request()->ajax()) 
        {
            $season_id_array = $request -> season_id_array;
            $season_id_array = explode(",", $season_id_array);
            $league_id_array = $request -> league_id_array;
            $league_id_array = explode(",", $league_id_array);
            $weeknumber_array = $request -> weeknumber_array;
            if ($weeknumber_array){
                $weeknumber_array = explode(",", $weeknumber_array);
                foreach ($weeknumber_array as $weeknumber)
                {
                    $weeknumber = trim($weeknumber);
    
                }
            }
          
            $match_result = DB::table('season_match_plan as a')
            ->join('team_list as b', 'b.team_id', '=', 'a.home_team_id')
            ->join('team_list as c', 'c.team_id', '=', 'a.away_team_id')
            ->join('season as d', 'd.season_id', '=', 'a.season_id')
            ->join('league as e', 'e.league_id', '=', 'a.league_id')
            ->join('season_league_team_info as f', 
                function($join) 
                {
                    $join->on('a.season_id', '=','f.season_id');
                    $join->on('a.home_team_id', '=', 'f.team_id');
                })
            ->join('season_league_team_info as g', 
                function($join) 
                {
                    $join->on('a.season_id', '=','g.season_id');
                    $join->on('a.away_team_id', '=', 'g.team_id');
                })
            
            
            ->leftJoin('odds as h2',
                function($join) 
                {
                    $join->on('a.match_id', '=','h2.match_id');
                    $join->on('h2.bookmaker_id', '=', DB::raw('(SELECT id FROM bookmakers WHERE bookmaker_name = "highest")'));
                }
            )
            
            -> where(
                'a.status', '=', 'END'
            )
            
            -> where(function($q) use($season_id_array){
                for($i = 0; $i < sizeof($season_id_array); $i++)
                {
                    $q -> orwhere('a.season_id', '=', $season_id_array[$i]);
                }
                
            })
            -> where(function($q) use($league_id_array){
                for($i = 0; $i < sizeof($league_id_array); $i++)
                {
                    $q -> orwhere('a.league_id', '=', $league_id_array[$i]);
                }
                
            })
            ->when($weeknumber_array, function($query, $weeknumber_array) {
                $query -> where(function($q) use($weeknumber_array){
                
                    $q -> orwhereIn('a.c_WN', $weeknumber_array);
                });
            })
            -> select(
                'e.league_title' , 
                'd.season_title' , 
                'a.date' , 
                'a.c_WN' , 
                DB::raw(" CONCAT(b.`team_name` , ' : ', c.`team_name` ) AS Game"),
                DB::raw("CONCAT ( (SELECT IF ((SELECT cream_status FROM cream_team_list  WHERE team_id = a.home_team_id and season_id = a.season_id) != 'Non-Cream',(SELECT cream_status FROM cream_team_list WHERE team_id = a.home_team_id and season_id = a.season_id) ,'Non-Cream' )), 
                ' v ' , 
                (SELECT IF ((SELECT cream_status FROM cream_team_list WHERE team_id = a.away_team_id and season_id = a.season_id) != 'Non-Cream',(SELECT cream_status FROM cream_team_list WHERE team_id = a.away_team_id and season_id = a.season_id ) ,'Non-Cream' ))) AS cream_status") , 
                
                DB::raw("CONCAT('<a href=\"eachMatch/', TO_BASE64(a.`match_id`), '\" target=\"_blank\">', CONCAT(a.`total_home_score` , ' : ', a.`total_away_score`), '</a>') AS Score"),
                 'a.total_home_score',
                 'a.total_away_score',
                DB::raw('b.`team_name` AS Home_team_name'),
                // 'a.Home_TGPR',
                // 'f.S_H_ranking',
                // 'a.D_Home_RS_8',
                // 'a.D_Home_ranking_8',
                // 'a.D_Home_RS_6',
                // 'a.D_Home_ranking_6',
                // 'a.home_team_score',
                'a.home_team_strength',
                DB::raw(' c.`team_name` AS Away_team_name'),
                // 'a.Away_TGPR',
                // 'g.S_A_ranking',
                // 'a.D_Away_RS_8',
                // 'a.D_Away_ranking_8',
                // 'a.D_Away_RS_6',
                // 'a.D_Away_ranking_6',
                // 'a.Away_team_score',
                'a.Away_team_strength',
                DB::raw('CONCAT(f.`S_H_ranking`, " v " , g.`S_A_ranking`) AS staticRank'),
                DB::raw('CONCAT(a.`D_Home_ranking_8`, " v ", a.`D_Away_ranking_8`) AS DynamicRank_8'),
                DB::raw('CONCAT(a.`D_Home_ranking_6`, " v ", a.`D_Away_ranking_6`) AS DynamicRank_6'),

                DB::raw('h2.AH2_1 AS AH2_1'),
                DB::raw('h2.AH2_2 AS AH2_2'),

                DB::raw('h2.AH1d75_1 AS AH1d75_1'),
                DB::raw('h2.AH1d75_2 AS AH1d75_2'),

                DB::raw('h2.AH1d5_1 AS AH1d5_1'),
                DB::raw('h2.AH1d5_2 AS AH1d5_2'),

                DB::raw('h2.AH1d25_1 AS AH1d25_1'),
                DB::raw('h2.AH1d25_2 AS AH1d25_2'),

                DB::raw('h2.AH1_1 AS AH1_1'),
                DB::raw('h2.AH1_2 AS AH1_2'),

                DB::raw('h2.AH0d75_1 AS AH0d75_1'),
                DB::raw('h2.AH0d75_2 AS AH0d75_2'),

                DB::raw('h2.AH0d5_1 AS AH0d5_1'),
                DB::raw('h2.AH0d5_2 AS AH0d5_2'),

                DB::raw('h2.AH0d25_1 AS AH0d25_1'),
                DB::raw('h2.AH0d25_2 AS AH0d25_2'),

                DB::raw('h2.AH0_1 AS AH0_1'),
                DB::raw('h2.AH0_2 AS AH0_2'),

                DB::raw('h2.AH_p0d25_1 AS AH_p0d25_1'),
                DB::raw('h2.AH_p0d25_2 AS AH_p0d25_2'),

                DB::raw('h2.AH_p0d5_1 AS AH_p0d5_1'),
                DB::raw('h2.AH_p0d5_2 AS AH_p0d5_2'),

                DB::raw('h2.AH_p0d75_1 AS AH_p0d75_1'),
                DB::raw('h2.AH_p0d75_2 AS AH_p0d75_2'),

                DB::raw('h2.AH_p1_1 AS AH_p1_1'),
                DB::raw('h2.AH_p1_2 AS AH_p1_2'),

                DB::raw('h2.AH_p1d25_1 AS AH_p1d25_1'),
                DB::raw('h2.AH_p1d25_2 AS AH_p1d25_2'),

                DB::raw('h2.AH_p1d5_1 AS AH_p1d5_1'),
                DB::raw('h2.AH_p1d5_2 AS AH_p1d5_2'),

                DB::raw('h2.AH_p1d75_1 AS AH_p1d75_1'),
                DB::raw('h2.AH_p1d75_2 AS AH_p1d75_2'),

                DB::raw('h2.AH_p2_1 AS AH_p2_1'),
                DB::raw('h2.AH_p2_2 AS AH_p2_2')
                
            );

         
       
            
            return DataTables()::of($match_result)
                ->editColumn('Score', function($match_result) {
                    return html_entity_decode($match_result->Score);
                })
                
                ->rawColumns(['Score'])
                
                ->make(true);
                
        }
    }
    
}
