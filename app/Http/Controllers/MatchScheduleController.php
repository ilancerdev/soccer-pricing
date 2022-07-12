<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MatchScheduleController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show_MatchSchedule()
    {
        return view('MatchSchedule');
    }
    public function showMatchTable()       // show match schedule for following season and league
    {
        
        if(request()->ajax()) 
        {
            $season_id = (!empty($_GET["season_id"])) ? ($_GET["season_id"]) : ('');
            $league_id = (!empty($_GET["league_id"])) ? ($_GET["league_id"]) : ('');
     
            
            if($season_id && $league_id)
            {
                $match_result = DB::select("SELECT (@cnt := @cnt + 1) AS No, a.`date` AS Date ,a.WN,a.time as Time , b.`team_name` AS Home ,
                    if (a.status = 'END', CONCAT('<a href=\"eachMatch/', TO_BASE64(a.`match_id`), '\" target=\"_blank\">', CONCAT(a.`total_home_score` , ' : ', a.`total_away_score`), '</a>'), ' - : -') AS Score , 
                    c.`team_name` AS Away , if(a.status = 'END',CONCAT(a.`half_home_score`,' : ', a.`half_away_score`) , ' - : - ')AS Half ,
                    if (a.status = 'LIVE', CONCAT('<a href=\"teamnews/',TO_BASE64( a.`match_id` ), '\" target=\"_blank\">','LIVE', '</a>'), a.status) AS match_Status,
                    if (a.status = 'END', CONCAT('<a href=\"odd/', TO_BASE64(a.`match_id`), '\" target=\"_blank\">','View', '</a>'), '') AS odds
                    
                    FROM season_match_plan AS a
                    CROSS JOIN (SELECT @cnt := 0) AS dummy
                    INNER JOIN team_list AS b ON a.`home_team_id` = b.`team_id`
                    INNER JOIN team_list AS c ON a.`away_team_id` = c.`team_id`
                    INNER JOIN season AS d ON a.`season_id` = d.`season_id`
                    INNER JOIN league AS e ON a.`league_id` = e.`league_id`
                    
                WHERE a.`season_id` = ".$season_id." AND a.`league_id` = ".$league_id." 
                ORDER BY a.`date`");
            }

            return datatables()->of($match_result)
            ->editColumn('Score', function($match_result) {
                return html_entity_decode($match_result->Score);
            })
            ->editColumn('match_Status', function($match_result) {
                return html_entity_decode($match_result->match_Status);
            })
            ->editColumn('odds', function($match_result) {
                return html_entity_decode($match_result->odds);
            })
                ->rawColumns(['Score','odds', 'match_Status'])
            ->make(true);
                
        }
        
    }
    public function eachMatch($id)
    {
        $id = base64_decode($id);
        $match_result = DB::select("SELECT a.`date` as Date, b.`team_name`AS team_name, b.`img_src` AS img_src , CONCAT(a.`total_home_score` , ' : ', a.`total_away_score`) AS score
            FROM season_match_plan AS a 
            INNER JOIN team_list AS b ON a.`home_team_id` = b.`team_id`  
            WHERE a.`match_id` = {$id}
            UNION
            SELECT  a.`date` as Date, b.`team_name`AS team_name, b.`img_src` AS img_src , CONCAT(a.`half_home_score` , ' : ', a.`half_away_score`) AS score
            FROM season_match_plan AS a 
            INNER JOIN team_list AS b ON a.`away_team_id` = b.`team_id`  
            WHERE a.`match_id` = {$id}");

        $data['home_team'] =  $match_result[0]->team_name;
        $data['Date'] = $match_result[0]->Date;
        $data['home_img'] =  str_replace("mini",'mittel',$match_result[0]->img_src);
        $data['total_score'] = $match_result[0]->score;
        $data['away_team'] =  $match_result[1]->team_name;
        $data['away_img'] =  str_replace("mini",'mittel',$match_result[1]->img_src);
        $data['half_score'] = $match_result[1]->score;

        $playerlist = DB::select("SELECT a.`player_id` AS id, c.`player_name` AS NAME, a.`goals` as goals, a.`assists` as assists
            FROM match_team_player_info AS a 
            INNER JOIN playerlist AS c ON a.`player_id` = c.`player_id`
            WHERE a.`match_id` = {$id}");
       
        $data['tbody'] =$playerlist;

        return view("matchschedule.eachmatch", $data);
    }
    public function showTeamPage($id){                // scrape and show team news for each match
        $id = base64_decode($id);
        $match_result = DB::select( "SELECT b.season_title, a. league_id, a.date, a.time, a.home_team_id, a.away_team_id FROM season_match_plan AS a 
        INNER JOIN season AS b ON a.season_id = b.season_id WHERE a.match_id   = {$id}");
        $season = $match_result[0] -> season_title;
        $season = str_replace('/','-', $season);
        $command = "get_team_news.exe ".$season." ".$match_result[0] -> league_id." ".$match_result[0] -> date." ".$match_result[0] -> time." ".$match_result[0] -> home_team_id." ".$match_result[0] -> away_team_id;
        
        //$command = "get_team_news.exe 2020-2021 1 2021-01-22 18:00 165 169";

        $team_name_results = DB::select( "SELECT a.date, a.time, b.`team_name` as Home, c.`team_name` as Away FROM season_match_plan AS a 
        INNER JOIN team_list AS b ON a.home_team_id = b.team_id
        INNER JOIN team_list AS c ON a.away_team_id = c.team_id
        WHERE a.match_id   = {$id}");

        $home_team_name = $team_name_results[0] -> Home;
        $away_team_name = $team_name_results[0] -> Away;
        $date  = $team_name_results[0] -> date;
        $time  = $team_name_results[0] -> time;

        $data['command'] = $command;
        $data['home_team_name'] = $home_team_name;
        $data['away_team_name'] = $away_team_name;
        $data['date'] = $date;
        $data['time'] = $time;
        return view('matchschedule.teamnews', $data);
    }
    public function showTeamNewsDataonPage(Request $request)  //
    {
        $command = $request -> data;
        
        //exec(getcwd()."/public/".$command, $data);
        exec(getcwd()."/".$command, $data);
        //var_dump($data);
        //$data = substr($data, 2, strlen($data) - 3);
        
        //$data = system(getcwd()."/public/auto.bat > ".getcwd()."/public/a.txt 2>&1",$ret);
        //$data = system(getcwd()."/public/get_team_news.exe 2020-2021 7 17/09/2020 20:00 122 111 2>&1",$ret);
        //var_dump($data, $ret);
        //return $err;
        if ($data)      
        {
            $data = $data[0];
            $data = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
                return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UTF-16BE');
            }, $data);
            
            $data = str_replace("\\","",$data); 
            $data = substr($data, 2, strlen($data) - 3);
            return $data;
        }
        else 
        {
            return "None";
        }
        
    }
    public function showOddEachMatch($id)
    {
        $id = base64_decode($id);
        $match_result = DB::select("SELECT a.`date` as Date, b.`team_name`AS team_name, b.`img_src` AS img_src , CONCAT(a.`total_home_score` , ' : ', a.`total_away_score`) AS score
        FROM season_match_plan AS a 
        INNER JOIN team_list AS b ON a.`home_team_id` = b.`team_id`  
        WHERE a.`match_id` = {$id}
        UNION
        SELECT  a.`date` as Date, b.`team_name`AS team_name, b.`img_src` AS img_src , CONCAT(a.`half_home_score` , ' : ', a.`half_away_score`) AS score
        FROM season_match_plan AS a 
        INNER JOIN team_list AS b ON a.`away_team_id` = b.`team_id`  
        WHERE a.`match_id` = {$id}");

        $data['home_team'] =  $match_result[0]->team_name;
        $data['Date'] = $match_result[0]->Date;
        $data['home_img'] =  str_replace("mini",'mittel',$match_result[0]->img_src);
        $data['total_score'] = $match_result[0]->score;
        $data['away_team'] =  $match_result[1]->team_name;
        $data['away_img'] =  str_replace("mini",'mittel',$match_result[1]->img_src);
        $data['half_score'] = $match_result[1]->score;

        $static_ranking_result = DB::select("(SELECT S_H_ranking FROM season_league_team_info WHERE team_id IN (
            SELECT home_team_id FROM season_match_plan WHERE match_id = {$id}) ORDER BY info_id DESC LIMIT 1)
            UNION ALL
            (SELECT S_A_ranking FROM season_league_team_info WHERE team_id IN (
            SELECT away_team_id FROM season_match_plan WHERE match_id = {$id}) ORDER BY info_id DESC LIMIT 1)");
        $data['static_home_ranking'] = $static_ranking_result[0] -> S_H_ranking;
        $data['static_away_ranking'] = $static_ranking_result[1] -> S_H_ranking;

        
        $odd = DB::select("SELECT * FROM season_match_plan WHERE match_id = {$id}");
        
        $data['info'] = $odd;
        
        $bookmaker = ['bet365', 'Betfair', 'Dafabet', 'Pncl', 'Sbo', 'Unibet', 'Average', 'Highest'];
        foreach ($bookmaker as $value)
          {
            $odd = DB::table('odds as a')
            -> join('bookmakers as b','a.bookmaker_id', '=','b.id')
            
            -> where([['a.match_id', $id],['b.bookmaker_name',$value]])
            -> select(
                DB::raw('b.bookmaker_name as Bookmaker'),
                'a.Home', 'a.Draw', 'a.Away',
                 DB::raw('a.Over2d5 as Over2d5'),
                  DB::raw('a.Under2d5 as Under2d5'))
            
            ->get();        
            $data[$value] = $odd;

          }  

        $data['bookmaker_list'] = $bookmaker;

        return view('matchschedule.oddpage', $data);
    }
}
