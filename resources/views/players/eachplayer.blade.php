@extends('layouts/master')
@section('title', $player_name)
@section('main')
    <div class="content container-fluid">
    <div class="flex-center container mt-4">
          <h1 id="player_name">{{$player_name}}</h1>
        </div>
        <div class="container" style="display: flex;justify-content: center;">
           <div class="col-sm-4">
               <br>
               <br>
                <div class="flex-center"><img src="{{$img_src}}" style="width:70%;"></div>
                <div class="flex-center">{{$player_name}}</div>
                <div id="playerId" style="display: none;">{{$player_id}}</div>
                <br>
                <div class="flex-center">
                <table>
                    <tr>
                        <td><b>Born:</b></td>
                        <td>{{$birthday}}</td>
                    </tr>
                    <tr>
                        <td><b>nationality:</b> 
                    </td>
                        <td>&nbsp;&nbsp;{{$nationality}}</td>
                    </tr>
                    <tr>
                        <td><b>height:</b></td>
                        <td>{{$height}}</td>
                    </tr>
                    <tr>
                        <td><b>weight:</b></td>
                        <td>{{$weight}}</td>
                    </tr>
                    <tr>
                        <td><b>position:</b></td>
                        <td>{{$position}}</td>
                    </tr>
                    <tr>
                        <td><b>foot:</b></td>
                        <td>{{$foot}}</td>
                    </tr>
                </table>
                </div>
           </div>
           <div class="col-sm-8">
                <div>
                    <br>
                    <br>
                    <!--<div class="flex-center">
                        <button class="btn-info" style="margin: 0 10px;" onclick="showWholeCarrer()">Whole  club matches</button>
                        <button class="btn-info" style="margin: 0 10px;" onclick="showE_SeasonCarrer()">Career for our Leagues</button>
                       
                    </div><br>-->
                    <div>
                        <div class="flex-center" id="career_status_txt" style="text:bold;"><h3>Whole club matches</h3></div>
                        <table class="table table-bordered table-striped" id="wholeTable">
                            <thead >
                                <th align="center"></th>
                                <th align="center">league</th>
                                <th align="center">Season</th>
                                <th>Team</th>
                                <th align="center" width="5%"><img src="https://s.hs-data.com/bilder/shared/spieleinsatz.gif" alt="Matches" title="Matches" /></th>
                                <th align="center" width="5%"><img src="https://s.hs-data.com/bilder/shared/tor.gif" alt="goals" title="goals" /></th>
                                <th align="center" width="5%"><img src="https://s.hs-data.com/bilder/shared/startelf.gif" alt="Starting line-up" title="Starting line-up" /></th>
                                <th align="center" width="5%"><img src="https://s.hs-data.com/bilder/shared/einwechslung.gif" alt="Substitue in" title="Substitue in" /></th>
                                <th align="center" width="5%"><img src="https://s.hs-data.com/bilder/shared/auswechslung.gif" alt="Substitue out" title="Substitue out" /></th>
                                <th align="center" width="5%"><img src="https://s.hs-data.com/bilder/shared/karten/1.gif" alt="yellow cards" title="yellow cards" /></th>
                                <th align="center" width="5%"><img src="https://s.hs-data.com/bilder/shared/karten/2.gif" alt="second yellow cards" title="second yellow cards" /></th>
                                <th align="center" width="5%"><img src="https://s.hs-data.com/bilder/shared/karten/3.gif" alt="red cards" title="red cards" /></th>
                            </thead>
                            <tbody></tbody>
                        </table>
                        
                        <div class="flex-center" id="div_total_txt" style="display: none;"><h3>Total Career</h3></div>
                            <table class="table table-bordered table-striped" id="Total_Table">
                                <thead class="thead-dark" style="width: 100%;">
                                    <th style="width:35%;">Season</th>    
                                    <th style="width:35%;">Total Games Started</th>
                                    <th style="width:35%;">Total Goals</th>
                                    <th style="width:15%;"> GPGR</th>
                                    <th style="width:15%;"> Score</th>
                                    
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        
                    </div>
                    
                </div>
           </div>
        </div>
    </div>
@endsection
@push('scripts')
    
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript">
        var league_id;
        var season_id;
        var wc_object;
        var season_array = [
            '2020/2021' ,
            '2020',
            '2019/2020' ,
            '2019',
            '2018/2019' ,
            '2018',
            '2017/2018' ,
            '2017',
            '2016/2017' ,
            '2016',
            '2015/2016' ,
            '2015',
            '2014/2015' ,
            '2014',
            '2013/2014' ,
            '2013',
            '2012/2013' ,
            '2012',
            '2011/2012' ,
            '2011',
            '2010/2011' ,
            '2010',
            ]
        $(document).ready(function()
        {
          //  var stateObj = { foo: "bar" };
          //  history.pushState(stateObj, "page 2", $("#player_name").html().replace(" ", "-"));
          id = $("#playerId").html();
          showWholeClubMatches();
        });
        function showWholeCarrer(){
            $("#career_status_txt").html("<h3>Whole club matches</h3>");
            $("#wholeTable").css("display", "block");
            $("#Each_Table").css("display", "none");
            $("#Total_Table").css("display", "none");
            $("#div_total_txt").css("display", "none");
            showWholeClubMatches();
        }
        function showE_SeasonCarrer(){
            $("#career_status_txt").html("<h3>Each career per each season</h3>");
            $("#wholeTable").css("display", "none");
            $("#Each_Table").css("display", "block");
            $("#Total_Table").css("display", "block");
            $("#div_total_txt").css("display", "flex");
            showEachMatches();
        }
        
        function showWholeClubMatches(){
            if(!$('#wholeTable tbody tr').length)
            {
                $.ajax({
                    url: 'showWholeCareer/'+id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response)
                    {
                    
                        var len = 0;
                        if(response['data'] != null){
                            len = response['data'].length;
                       
                            career_array = [... response['data']];
                            career_array = career_array.reverse();
                            
                        }
                        
                        if(len > 0)
                        {
                            for(var i=0; i<len; i++)
                            {
                                var flag = response['data'][i].flag;
                                var tr_flag = "<img src='"+ flag + "'>";
                                var tr_str = "<tr>" +
                                "<td align='center'>" + tr_flag + "</td>" +
                                "<td align='center'>" + response['data'][i].league + "</td>" +
                                "<td align='center'>" + response['data'][i].season + "</td>" +
                                "<td align='center'>" + response['data'][i].team + "</td>" +
                                "<td align='center'>" + response['data'][i].matches + "</td>" +
                                "<td align='center'>" + response['data'][i].goals + "</td>" +
                                "<td align='center'>" + response['data'][i].started + "</td>" +
                                "<td align='center'>" + response['data'][i].s_in + "</td>" +
                                "<td align='center'>" + response['data'][i].s_out + "</td>" +
                                "<td align='center'>" + response['data'][i].yellow + "</td>" +
                                "<td align='center'>" + response['data'][i].s_yellow + "</td>" +
                                "<td align='center'>" + response['data'][i].red + "</td>" +
                                "</tr>";
                                $("#wholeTable tbody").append(tr_str);
                            }
                           

                            for(var i = 0; i< season_array.length; i++)
                            {
                                var season_score = get_player_score_season(career_array, season_array[i])
                                if (season_score.length == 4)
                                {
                                    var tr_str = "<tr>" +
                                        "<td align='center'>" + season_array[i] + "</td>" +
                                        "<td align='center'>" +  season_score[0].toString()+ "</td>" +
                                        "<td align='center'>" +  season_score[1].toString()+ "</td>" +
                                        "<td align='center'>" +  season_score[2].toString()+ "</td>" +
                                        "<td align='center'>" +  season_score[3].toString()+ "</td>" + 
                                        "</tr>";

                                    $("#Total_Table tbody").append(tr_str);
                                }
                                
                            }
                            
                        }
                        else
                        {
                            var tr_str = "<tr>" +
                                "<td align='center' colspan='4'>No record found.</td>" +
                            "</tr>";

                            $("#wholeTable tbody").append(tr_str);
                            $("#Total_Table tbody").append(tr_str);
                        }

                    }
                });
            }
        }
       

        function get_player_score_season(career_array, season_title){
            
            //console.log("career_array", career_array);
            result = [];
            player_TGPR = 0
            total_goals = 0
            total_started = 0
            var arrayLength = career_array.length;
           
            var count = 0;
            for( key in career_array)
            {   
                //console.log(key)
                career = career_array[key]
                //console.log(" - Career", career)
                if (career.season ===  season_title)
                {
                    //console.log(season_title)
                    break;
                }   
                else{
                    
                    total_goals += career.goals;
                    total_started += career.started;
                }
                count ++;
            }
            
            if (count == arrayLength)     // no season_title in array
            {
                return [];
            }
            else{

            
                if (total_started != 0)
                {
                    player_TGPR = total_goals / total_started
                    player_TGPR = player_TGPR.toFixed(2)
                    result.push(total_started)
                    result.push(total_goals)
                    result.push(player_TGPR)
                }
                else{
                    return result;
                }
                if (total_started >= 20 ){
                    if (player_TGPR < 0.13)
                        result.push(0);
                    if ((player_TGPR >= 0.13) & (player_TGPR < 0.3))
                        result.push(100)
                    if ((player_TGPR >= 0.3) & (player_TGPR < 0.76))
                        result.push(1000)
                    if (player_TGPR >= 0.76)
                        result.push(10000)
                }
                    
                else {
                    if  (player_TGPR < 0.13)
                        result.push(0)
                    else
                        result.push(100)
                }
            }
            return result;
        }
            
                
      
     </script>
    
@endpush