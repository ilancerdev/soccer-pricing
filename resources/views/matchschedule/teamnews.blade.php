@extends('layouts/master')
@php 
   $title ='News: '.$home_team_name.' - '.$away_team_name
@endphp
@section('title', $title)
@section('main')
    <div class="content container-fluid">
        <div class="flex-center container mt-4">
            <div>
                <div  class="flex-center"><h1>{{$home_team_name}} : {{$away_team_name}}</h1></div>
                
                <div  class="flex-center"><h2>{{$date}} - {{$time}}</h2></div>
            </div>
        </div>
        
        <div class="flex-center">
           
            <table class="table table-bordered table-striped" id="matchTable" style="width:1000px;">
               <thead class="table-dark">
                <tr>
                    <th colspan="3" > {{$home_team_name}}  </th>
                    <th colspan="3" > {{$away_team_name}}  </th>
                </tr>
                <tr>
                     <th >Nubmer</th>
                     <th >PlayerName</th>
                     <th >Score</th>
                     <th >Nubmer</th>
                     <th >PlayerName</th>
                     <th >Score</th>
                    
                     
                  </tr>
               </thead>
               <tbody id = "tbody">
                   
               </tbody>
               
            </table>
            <div class="wrap">
               <div id="loader"></div>  
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
    <script>

            $(document).ready(function(){
                calc_func();
                $("#loader").fadeIn("slow");
                function calc_func(){
                    $.ajax({
                        url: " {{ url('showTeamNewsDataonPage') }} ",
                        type : 'POST',
                        data: {
                            _token   : '{!! csrf_token() !!}',
                            data: "{{$command}}"   //$command = "get_team_news.exe 2020-2021 1 2021-01-22 18:00 165 169"
                        },
                        dataType: 'text',
                        success:function(response){                     
                            
                            console.log(response);

                            $("#loader").fadeOut("slow");
                            if(response == "None" || response == "{}")
                            {
                                $('#tbody').append("<tr><td  colspan = '6'>No availabe data yet!</td></tr>");
                            }
                            else
                            {
                                JsonObj = JSON.parse(response)
                                
                                content  = "";
                                
                                for(var i = 0; i< 11; i++)
                                {
                                    content +=( "<tr>"+
                                      "<td>"+JsonObj.home_team_players[i][0]+"</td>"+
                                      "<td><a href = '/eachPlayer/"+btoa(JsonObj.home_team_players[i][2])+"' target = '_blank'>"+JsonObj.home_team_players[i][1]+"</td>"+
                                      "<td>"+JsonObj.home_team_players[i][3]+"</td>"+
                                      "<td>"+JsonObj.away_team_players[i][0]+"</td>"+
                                      "<td><a href = '/eachPlayer/"+btoa(JsonObj.away_team_players[i][2])+"' target = '_blank'>"+JsonObj.away_team_players[i][1]+"</td>"+
                                      "<td>"+JsonObj.away_team_players[i][3]+"</td>"+
                                    "</tr>" );
                                }
                                content += ("<tr><td colspan = '2'> Total Score: </td> <td>" + JsonObj.home_total_score + "</td><td colspan = '2'> Total Score: </td> <td>" + JsonObj.away_total_score + "</td>");
                                content += ("<tr><td colspan = '2'> Total Strength: </td> <td>" + JsonObj.home_team_strength + "</td><td colspan = '2'> Total Strength : </td> <td>" + JsonObj.away_team_strength + "</td>");
                                content += ("<tr><td colspan = '2'> Static Ranking </td> <td>" + JsonObj.static_home_team_ranking + "</td><td colspan = '2'> Static Ranking </td> <td>" + JsonObj.static_away_team_ranking + "</td>");
                                content += ("<tr><td colspan = '2'> Dynamic Ranking (8): </td> <td>" + JsonObj.dynamic_home_team_ranking + "</td><td colspan = '2'> Dynamic Ranking (8): </td> <td>" + JsonObj.dynamic_away_team_rankig + "</td>");
                                $('#tbody').append(content);
                                
                            }

                            
                        },
                        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                            console.log(JSON.stringify(jqXHR));
                            $("#loader").fadeOut("slow");
                            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    });
                }
            }) ;
        </script>
    
@endpush