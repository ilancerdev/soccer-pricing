<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showplayerScoreTable()  // show whole players table for leagues and seasons
    {

        if(request()->ajax()) 
        {
            $season_id = (!empty($_GET["season_id"])) ? ($_GET["season_id"]) : ('');
            $league_id = (!empty($_GET["league_id"])) ? ($_GET["league_id"]) : ('');
          
            if($season_id && $league_id)
            {
                $match_result = DB::select("SELECT CONCAT('<a href=\"eachPlayer/', TO_BASE64(a.`player_id`), '\" target=\"_blank\">', a.`player_name` , '</a>') AS Player , b.`team_name` AS Team ,a.`birthday` AS Born , a.`height` AS Height , a.`position` AS Pos 
                    FROM playerlist AS a 
                    INNER JOIN team_list AS b 
                    INNER JOIN match_team_player_info AS c ON c.`team_id`=b.`team_id` AND a.`player_id` = c.`player_id`
                    INNER JOIN season_match_plan AS d ON c.`match_id` = d.`match_id` 
                    WHERE d.`season_id`='".$season_id."' AND d.`league_id`='".$league_id."' 
                    GROUP BY a.`player_id` ORDER BY b.`team_name`");
            }
            else
            {
                $match_result[0]['Player'] = "";
                $match_result[0]['Team'] = "";
                $match_result[0]['Born'] = "";
                $match_result[0]['Height'] = "";
                $match_result[0]['Pos'] = "";
             }
            return datatables()->of($match_result)
                    
            
                 ->editColumn('Player', function($match_result) {
                     return html_entity_decode($match_result->Player);
                 })
                 ->rawColumns(['Player'])
                ->make(true);
                
        }
        return view('players.playerlist');
    }

    public function showEachPlayer($id)
    {
        $id = base64_decode($id);
        $result = DB::select("select * from playerlist where player_id = {$id}");

        $data['player_id'] =  $result[0]->player_id;
        $data['birthday'] =  $result[0]->birthday;
        $data['player_name'] =  $result[0]->player_name;
        $data['nationality'] =  $result[0]->nationality;
        $data['img_src'] = html_entity_decode($result[0]->img_src);
        $data['height'] =  $result[0]->height;
        $data['weight'] =  $result[0]->weight;
        $data['foot'] =  $result[0]->foot;
        $data['position'] =  $result[0]->position; 
        
        //$result = DB::select("SELECT c.season_title AS Season , COUNT(*) AS number , SUM(a.goals) AS Goals , SUM(a.goals)/COUNT(*) AS GPGR, SUM(a.assists) AS Assists, SUM(a.assists)/ COUNT(*) AS APGR
        //        FROM match_team_player_info AS a
        //       INNER JOIN season_match_plan AS b ON a.match_id = b.match_id
       //         INNER JOIN season AS c ON b.season_id = c.season_id
        //        WHERE a.player_id = {$id} GROUP BY b.season_id");
       // $data['tbody'] = $result;
        
        return view('players.eachplayer', $data);
    }
    public function showWholeCareer($id)
    {
        $result = DB::select("SELECT  a.flag, b.league_dname AS league, c.season_title AS season , d.team_name AS team , a.matches, a.goals, a.started, a.s_in, a.s_out, a.yellow, a.s_yellow, a.red
            FROM player_career AS a
            INNER JOIN league AS b ON a.league_id = b.league_id
            INNER JOIN season AS c ON a.season_id = c.season_id
            INNER JOIN team_list AS d ON a.team_id = d.team_id
            WHERE player_id  = {$id} ORDER BY c.season_title DESC");
        
         $data['data'] = $result;
    
         echo json_encode($data);
         exit;
    }
    public function showEachCareer($id)  # show each season's career of every player
    {
        $result = DB::select("SELECT b.`season_title` AS season,  c.`team_name` AS teamname, a.`started` AS started, a.`goals` AS goals , goals/started AS GPGR FROM player_career AS a
        INNER JOIN season AS b ON a.`season_id` = b.`season_id`
        INNER JOIN team_list AS c ON a.`team_id` = c.`team_id`
        WHERE a.player_id = {$id} AND a.`league_id` IN (SELECT c.league_id FROM season_match_plan AS c
            INNER JOIN match_team_player_info AS b ON b.match_id = c.match_id
            WHERE b.`player_id` = {$id} GROUP BY c.season_id)
            AND a.`season_id` IN (SELECT c.season_id FROM season_match_plan AS c
            INNER JOIN match_team_player_info AS b ON b.match_id = c.match_id
            WHERE b.`player_id` = {$id} GROUP BY c.season_id) 
            ORDER BY b.`season_title` DESC");
         
         $data['data'] = $result;
         echo json_encode($data);
         exit;
    }
}
