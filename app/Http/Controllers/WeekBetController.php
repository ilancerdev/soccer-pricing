<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeekBetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showMatchOddsSelctionPage()             // initial week MO bet page
    {
        $last_date = strtotime("Sunday");

        $first_date = strtotime("- 6 days",$last_date);

        $startDate  = date('Y/m/d',$first_date);

        $endDate = date('Y/m/d',$last_date);

        $data['startDate'] = $startDate;
        
        $data['endDate'] = $endDate;

        return view("weekbet.matchodds", $data);
    }
    public function showAHoddSelectionPage()             // initial week AH bet page
    {
        $last_date = strtotime("Sunday");

        $first_date = strtotime("- 6 days",$last_date);

        $startDate  = date('Y/m/d',$first_date);

        $endDate = date('Y/m/d',$last_date);

        $data['startDate'] = $startDate;
        
        $data['endDate'] = $endDate;

        return view("weekbet.ahodds", $data);
    }

    public function weekMOBet()            // show MO odds of this week bet
    {
        $last_date = strtotime("Sunday");
        $first_date = strtotime("- 6 days",$last_date);
        

        $match_result = DB::table("season_match_plan as a")
            ->join('team_list as b', 'b.team_id', '=', 'a.home_team_id')
            ->join('team_list as c', 'c.team_id', '=', 'a.away_team_id')
            ->join('season as d', 'd.season_id', '=', 'a.season_id')
            ->join('league as e', 'e.league_id', '=', 'a.league_id')
            ->leftJoin('season_league_team_info as f', 
                function($join) 
                {
                    $join->on('a.season_id', '=','f.season_id');
                    $join->on('a.home_team_id', '=', 'f.team_id');
                })
            ->leftJoin('season_league_team_info as g', 
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
           
            
            ->leftJoin('odds as h4',
                function($join) 
                {
                    $join->on('a.match_id', '=','h4.match_id');
                    $join->on('h4.bookmaker_id', '=', DB::raw('(SELECT id FROM bookmakers WHERE bookmaker_name = "live_highest")'));
                }
            )
            
            -> where(function($q){
                $q -> orwhere('a.status', '=', 'END')
                   ->orwhere('a.status', '=', 'LIVE');
                
                }
                
            ) 

            ->leftjoin('real_mo_price_cl as r', 'a.CL_mo_refer_id', '=', 'r.id')
            -> where(function($q) use ($first_date){
                for($i = 0; $i < 7; $i++)
                {
                    $every_date = strtotime("+ ".$i." days",$first_date);
                    $everyDate  = date('Y-m-d',$every_date);
                    $q -> orwhere('a.date', '=', $everyDate);
                } 
            })
            ->select(
                DB::raw('e.`league_title` AS League') , 
                DB::raw('d.`season_title` AS Season') , 
                DB::raw('a.`date` AS Date') , 
                DB::raw('a.c_WN AS wn') ,
                DB::raw(" CONCAT(b.`team_name` , ' : ', c.`team_name` ) AS Game"),
                DB::raw("CONCAT ( (SELECT IF ((SELECT cream_status FROM cream_team_list  WHERE team_id = a.home_team_id and season_id = a.season_id) != 'Non-Cream',(SELECT cream_status FROM cream_team_list WHERE team_id = a.home_team_id and season_id = a.season_id) ,'Non-Cream' )), 
                ' v ' , 
                (SELECT IF ((SELECT cream_status FROM cream_team_list WHERE team_id = a.away_team_id and season_id = a.season_id) != 'Non-Cream',(SELECT cream_status FROM cream_team_list WHERE team_id = a.away_team_id and season_id = a.season_id ) ,'Non-Cream' ))) AS cream_status") , 

                DB::raw("IF(a.status = 'END', CONCAT(a.`total_home_score` , ' : ', a.`total_away_score` ), '- : -' ) AS Score"),
                DB::raw('IF(a.status = "END", IF( a.total_home_score > a.total_away_score, "H" , IF(a.total_home_score = a.total_away_score ,"D" ,"A") )  , "-") AS Result'),
                DB::raw("b.team_name as Home_team_name") ,
                DB::raw('f.S_H_ranking AS Static_HRank') , 
                DB::raw("a.D_Home_ranking_6 AS Dynamic_HRank_6"),
                DB::raw("a.D_Home_ranking_8 AS Dynamic_HRank_8") , 
                DB::raw("a.home_team_strength AS home_team_strength") , 
                DB::raw("a.away_team_strength AS away_team_strength") , 
                DB::raw("c.team_name as Away_team_name") ,
                DB::raw("g.S_A_ranking AS Static_ARank") ,
                DB::raw("a.D_Away_ranking_6 AS Dynamic_ARank_6"),
                DB::raw("a.D_Away_ranking_8 AS Dynamic_ARank_8"), 
                DB::raw("CONCAT(f.`S_H_ranking`, ' v ' , g.`S_A_ranking`) AS staticRank") , 

                DB::raw('IF (a.status = "END" , h2.Home , h4.Home) AS highest_Home'),
                DB::raw('IF (a.status = "END" , h2.Draw , h4.Draw) AS highest_Draw'),
                DB::raw('IF (a.status = "END" , h2.Away , h4.Away) AS highest_Away'),

                DB::raw('r.H_price AS Real_Home'),
                DB::raw('r.D_price AS Real_Draw'),
                DB::raw('r.A_price AS Real_Away'),

                //DB::raw('IF (a.status = "END" , h2.Over2d5  , h4.Over2d5) AS highest_Over'),
                //DB::raw('IF (a.status = "END" , h2.Under2d5 , h4.Under2d5) AS highest_Under')
            )
            ->orderby("a.date")
            ->get();

        $data['tbody'] =$match_result;
        echo json_encode($data);
        exit;
        
    }

    public function weekAHBet()            // show AH odds of this week bet
    {
        $last_date = strtotime("Sunday");
        $first_date = strtotime("- 6 days",$last_date);
        

        $match_result = DB::table("season_match_plan as a")
            ->join('team_list as b', 'b.team_id', '=', 'a.home_team_id')
            ->join('team_list as c', 'c.team_id', '=', 'a.away_team_id')
            ->join('season as d', 'd.season_id', '=', 'a.season_id')
            ->join('league as e', 'e.league_id', '=', 'a.league_id')
            ->leftJoin('season_league_team_info as f', 
                function($join) 
                {
                    $join->on('a.season_id', '=','f.season_id');
                    $join->on('a.home_team_id', '=', 'f.team_id');
                })
            ->leftJoin('season_league_team_info as g', 
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
           
            
            ->leftJoin('odds as h4',
                function($join) 
                {
                    $join->on('a.match_id', '=','h4.match_id');
                    $join->on('h4.bookmaker_id', '=', DB::raw('(SELECT id FROM bookmakers WHERE bookmaker_name = "live_highest")'));
                }
            )
            
            -> where(function($q){
                $q -> orwhere('a.status', '=', 'END')
                   ->orwhere('a.status', '=', 'LIVE');
                
                }
                
            )   
            -> where(function($q) use ($first_date){
                for($i = 0; $i < 7; $i++)
                {
                    $every_date = strtotime("+ ".$i." days",$first_date);
                    $everyDate  = date('Y-m-d',$every_date);
                    $q -> orwhere('a.date', '=', $everyDate);
                } 
            })
            ->select(
                DB::raw('e.`league_title` AS League') , 
                DB::raw('d.`season_title` AS Season') , 
                DB::raw('a.`date` AS Date') , 
                DB::raw('a.WN') , 
                DB::raw(" CONCAT(b.`team_name` , ' : ', c.`team_name` ) AS Game"),
                DB::raw("CONCAT ( (SELECT IF ((SELECT cream_status FROM cream_team_list  WHERE team_id = a.home_team_id and season_id = a.season_id) != 'Non-Cream',(SELECT cream_status FROM cream_team_list WHERE team_id = a.home_team_id and season_id = a.season_id) ,'Non-Cream' )), 
                ' v ' , 
                (SELECT IF ((SELECT cream_status FROM cream_team_list WHERE team_id = a.away_team_id and season_id = a.season_id) != 'Non-Cream',(SELECT cream_status FROM cream_team_list WHERE team_id = a.away_team_id and season_id = a.season_id ) ,'Non-Cream' ))) AS cream_status") , 

                DB::raw("IF(a.status = 'END', CONCAT(a.`total_home_score` , ' : ', a.`total_away_score` ), '- : -' ) AS Score"),
                DB::raw('IF(a.status = "END", IF( a.total_home_score > a.total_away_score, "H" , IF(a.total_home_score = a.total_away_score ,"D" ,"A") )  , "-") AS Result'),
                
                DB::raw("b.team_name as Home_team_name") ,
                DB::raw('f.S_H_ranking AS Static_HRank') , 
                DB::raw("a.D_Home_ranking_6 AS Dynamic_HRank_6"),
                DB::raw("a.D_Home_ranking_8 AS Dynamic_HRank_8") , 
                DB::raw("c.team_name as Away_team_name") ,
                DB::raw("g.S_A_ranking AS Static_ARank") ,
                DB::raw("a.D_Away_ranking_6 AS Dynamic_ARank_6"),
                DB::raw("a.D_Away_ranking_8 AS Dynamic_ARank_8"), 
                DB::raw("CONCAT(f.`S_H_ranking`, ' v ' , g.`S_A_ranking`) AS staticRank") , 

                DB::raw('IF (a.status = "END" ,h2.AH_p1_1 , h4.AH_p1_1) AS AH_p1_1'),
                DB::raw('IF (a.status = "END" ,h2.AH_p1_2 , h4.AH_p1_2) AS AH_p1_2'),
                DB::raw('IF (a.status = "END" ,h2.AH_p1d25_1 , h4.AH_p1d25_1) AS AH_p1d25_1'),
                DB::raw('IF (a.status = "END" ,h2.AH_p1d25_2 , h4.AH_p1d25_2) AS AH_p1d25_2'),
                DB::raw('IF (a.status = "END" ,h2.AH_p1d5_1 , h4.AH_p1d5_1) AS AH_p1d5_1'),
                DB::raw('IF (a.status = "END" ,h2.AH_p1d5_2 , h4.AH_p1d5_2) AS AH_p1d5_2'),
                DB::raw('IF (a.status = "END" ,h2.AH_p1d75_1 , h4.AH_p1d75_1) AS AH_p1d75_1'),
                DB::raw('IF (a.status = "END" ,h2.AH_p1d75_2 , h4.AH_p1d75_2) AS AH_p1d75_2'),
                DB::raw('IF (a.status = "END" ,h2.AH_p2_1 , h4.AH_p2_1) AS AH_p2_1'),
                DB::raw('IF (a.status = "END" ,h2.AH_p2_2 , h4.AH_p2_2) AS AH_p2_2') , 
                DB::raw('(SELECT home_price FROM real_ah_price_cl WHERE refer= CONCAT(e.league_title , cream_status) and c_week_number=a.c_WN and market=1) AS real_p1_1')
            )
            ->orderby("a.date")
            ->get();

        $data['tbody'] =$match_result;
        echo json_encode($data);
        exit;
        
    }
}
