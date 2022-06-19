@extends('layouts/master')
@php 
   $title = $home_team.' - '.$away_team
@endphp
@section('title', $title)
@section('main')
    <div class="content container-fluid">
        
        <div  class="flex-center container mt-4" style="color: black;">
            <table>
                <tbody>
                    <tr style="background-color: #e8e5e3;">
                        <td style="padding: 0 25px; width: 400px;" ><h2 id="home_team_name">{{$home_team}}</h2></td>
                        <td style="width: 100px;"><h4 id="match_date">{{$Date}}</h4></td>
                        <td style="padding: 0 25px; width:400px;" ><h2 id="away_team_name">{{$away_team}}</h2></td>
                    </tr>
                    <tr style="background-color: #c9c6c3;">
                        <td><img src='{{$home_img}}'></td>
                        <td style="background-color:#dbd8d5;"><h6>{{$total_score}} <br> ({{$half_score}})</h6></td>
                        <td><img src='{{$away_img}}'></td>
                    </tr> 
                </tbody>
            </table>
          
        </div>
       
        <div class="container mt-4"> 
        <table class="table table-bordered table-striped" id="ranking_table" >
               <thead class="table-dark">
                  <tr>
                     <th colspan="4" > Ranking information  </th>
                  </tr>
                  <tr>
                     
                     <th colspan="2"> <h4>{{$home_team}} </h4> </th>
                     
                     <th colspan="2"> <h4> {{$away_team}} </h4>  </th>
                  </tr>
               </thead>
               <tbody>
                 <tr>
                   <td>Team Score</td>

                   <td>{{$info[0]->home_team_score}}</td>
                   <td>Team Score</td>
                   <td>{{$info[0]->away_team_score}}</td>
                 </tr>
                 <tr>
                   <td>Team Strength</td>
                   <td>{{$info[0]->home_team_strength}}</td>
                   <td>Team Strength</td>
                   <td>{{$info[0]->away_team_strength}}</td>
                 </tr>
                 <tr>
                   <td>Static Ranking</td>
                   <td>{{$static_home_ranking}}</td>
                   <td>Static Ranking</td>
                   <td>{{$static_away_ranking}}</td>
                 </tr>
                 <tr>
                   <td>Dynamic Ranking (8)</td>
                   <td>{{$info[0]->D_Home_ranking_8}}</td>
                   <td>Dynamic Ranking (8)</td>
                   <td>{{$info[0]->D_Away_ranking_8}}</td>
                 </tr>
               </tbody>
        </table>
        
        
        
        <table class="table table-bordered table-striped" id="odd_1X2_table" >
               <thead class="table-dark">
                  
                  <tr>
                     <th> Bookmaker  </th>
                     <th> 1  </th>
                     <th> X  </th>
                     <th> 2  </th>
                     <th> Over  </th>
                     <th> Under  </th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($bookmaker_list as $bookmaker)
                    <tr>
                        @foreach (${$bookmaker} as $odd)
                            <td>{{$odd ->Bookmaker}}</td>
                            <td>{{$odd->Home}}</td>
                            <td>{{$odd->Draw}}</td>
                            <td>{{$odd->Away}}</td>
                            <td>{{$odd->Over2d5}}</td>
                            <td>{{$odd->Under2d5}}</td>
                        @endforeach
                      
                    </tr>
                  @endforeach

              
               </tbody>
        </table>
        
      
        </div>
    </div>
@endsection
@push('scripts')
    
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
   
    
@endpush