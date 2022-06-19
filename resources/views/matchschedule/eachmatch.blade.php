@extends('layouts/master')
@php 
   $title = $home_team.' - '.$away_team
@endphp
@section('title', $title)
@section('main')
    <div class="content container-fluid">
        
        <div  class="flex-center container mt-4" style="color: black;">
          
          
            <table >
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
         <div  class="flex-center container mt-4" style="color: black;">
            <table  class="table table-bordered table-striped" id="PlayerTable">
              <thead class="table-dark">
                <tr>
                  <th style="width:300px;">PlayerName</th>
                  <th style="width: 50px;">Goals</th>
                  <th style="width: 50px;">Assits</th>
                  <th style="width: 300px;">PlayerName</th>
                  <th style="width: 50px;">Goals</th>
                  <th style="width: 50px;">Assits</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  for ($i=0; $i < 11 ; $i++) { 
                    echo "<tr>
                    <td><a href = '/eachPlayer/". base64_encode($tbody[$i]->id)."' target = '_blank'>{$tbody[$i]->NAME}</td>
                    <td>{$tbody[$i]->goals}</td>
                    <td>{$tbody[$i]->assists}</td>
                    <td><a href = '/eachPlayer/".base64_encode($tbody[$i+ 11]->id)."' target = '_blank'>{$tbody[$i + 11]->NAME}</td>
                    <td>{$tbody[$i+11]->goals}</td>
                    <td>{$tbody[$i+11]->assists}</td>
                    </tr>";
                  }
                  
                ?>
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