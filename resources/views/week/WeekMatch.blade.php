@extends('layouts/master')
@section('title', 'Week Matches')
@section('main')
    <div class="content container-fluid">
        <div class="flex-center container mt-4">
            <div class="flex-center">
                <h1>This week's match</h1><br>
            </div>
          
        </div>
        <div class="flex-center" >
            <h4> {{$startDate}}   ~   </h4>
            <h4> {{$endDate}} </h4>
          
        </div>
        <div class="row"  style="width: 70%; margin-left:15%;">
            <div class="col-lg-3  text-center">
                <button class="btn btn-info" style="margin-top: 10px;" onclick="get_weekMatches_withMO()">Match Odds</button>
            </div>   
            <div class="col-lg-3  text-center">
                <button class="btn btn-info" style="margin-top: 10px;" onclick="get_weekMatches_withOU()">O/U Odds</button>
            </div>
            <div class="col-lg-3  text-center">
                <button class="btn btn-info" style="margin-top: 10px;" onclick="get_weekMatches_withAH()">Asian Handicaps</button>
            </div>
            
            <div class="col-lg-3 flex-center " >
                <div><h5 style="margin-top:10px;">Stake :  </h5></div>
                <input value="5000" style = "width:50%" id="stake_input" onchange="stakeValueChanged()">
            </div>
        </div>
        <div class="row">
            <div id="talbe_MO_div" style="display: none;">
                <br>
                <div class="flex-center" id="pre_cont_MO">
                    
                </div>
                <table class="table table-striped table-hover" style="width: 5000px;margin-left:50px; text-align: center;"  id = 'WeekMatchTable_MO'>
                    <thead class="table-dark">
                        
                        <th style="width: 200px"> League    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '0' checked/></th>
                        <th>Season                          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '1' checked/></th>
                        <th style="width: 80px">Date        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '2'/></th>
                        <th>Week Number                     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '3' checked/></th>
                        <th style="width: 200px">Game       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '4'/></th>

                        <th style="width: 200px">Cream_status       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '5' checked/></th>

                        <th>Score                           &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '6'/></th>
                        <th>Result                          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '7'/></th>
                        <th>Home Team                       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '8'/></th>
                        <th>Away Team                       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '9'/></th>
                        
                        <th>Static Rank                     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '10'/></th>
                        <th>Dy_Rank(6)                      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '11'/></th>
                        <th>Dy_Rank(8)                      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '12'/></th>

                        <th>Home_strength                   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '13'/></th>
                        <th>away_strength                   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '14'/></th>

                        <th >Actual_Home                    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '15' checked/></th>
                        <th>Actual_Draw                     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '16' checked/></th>
                        <th>Actual_Away                     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '17' checked/></th>
                        
                        <th>Real_Home                       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '18'/></th>
                        <th>Real_Draw                       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '19'/></th>
                        <th>Real_Away                       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '20'/></th>

                     

                    

                    </thead>
                    <tbody id="tbody_MO" class = "table-bordered">
                        
                    </tbody>
                </table>
            </div>

            <div id="talbe_OU_div" style="display: none;">
                <br>
                <div class="flex-center" id="pre_cont_OU">
                
                </div>
                <table class="table table-bordered table-hover" style="width: 4000px;margin-left:50px;" id = 'WeekMatchTable_OU'>
                <thead class="table-dark">
                
                <th>League &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '0' checked/></th>
                <th>Season  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '1' checked/></th>
                <th>Date    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '2' /></th>
                
                <th>Week Number &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '3' checked/></th>
                <th>Game        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '4' /></th>
                <th>Score       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '5' /></th>
                <th>Result      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '6' /></th>
                <th>Home Team   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '7' /></th>
                <th>Away Team   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '8' /></th>
                
                <th>Static Rank &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '9' /></th>
                <th>Dy_Rank(6)  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '10' /></th>
                <th>Dy_Rank(8)  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '11' /></th>

                <th>Actual_Over 2.5 &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '12' checked/></th>
                <th>Actual_Under 2.5 &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '13' checked/></th>

                <th>Real_Over 2.5 &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '14' /></th>
                <th>Real_Under 2.5 &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '15' /></th>

                <th>Over_Bet  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '16' /></th>
                <th>Under_Bet  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '17' /></th>

                </thead>
                <tbody id="tbody_OU">
                    
                </tbody>
            </table>
            </div>
            
            <div id="talbe_AH_div" style="display: none;">
            <br>
            <div class="flex-center" id="pre_cont_AH">
            
            </div>
                <table class="table table-bordered table-hover" style="width: 8000px;margin-left:50px;" id = 'WeekMatchTable_AH'>
                <thead class="table-dark">
                
                <th>League &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '0' checked/></th>
                <th>Season          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '1' checked/></th>
                <th>Date            &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '2'/></th>
                <th>Week Number     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '3' checked/></th>
                <th>Game            &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '4'/></th>
                
                <th>Score           &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '5'/></th>
                <th>Result          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '6'/></th>
                <th>Home Team       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '7'/></th>
                <th>St_HRank        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '8'/></th>
                <th>Dy_HRank(6)     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '9'/></th>
                <th>Dy_HRank(8)     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '10'/></th>
                <th>Away Team       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '11'/></th>
                <th>St_ARank        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '12'/></th>
                <th>Dy_ARank(6)     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '13'/></th>
                <th>Dy_ARank(8)     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '14'/></th>
                <th>St_Rank         &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '15'/></th>
                <th>Dy_Rank(6)      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '16'/></th>
                <th>Dy_Rank(8)      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '17'/></th>

                <th>AH -2.0_1   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '18' checked/></th>
                <th>AH -2.0_2   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '19' checked/></th>
                
                <th>AH -1.75_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '20' checked/></th>
                <th>AH -1.75_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '21' checked/></th>

                <th>AH -1.5_1   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '22' checked/></th>
                <th>AH -1.5_2   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '23' checked/></th>
                
                <th>AH -1.25_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '24' checked/></th>
                <th>AH -1.25_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '25' checked/></th>
                
                <th>AH -1.0_1   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '26' checked/></th>
                <th>AH -1.0_2   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '27' checked/></th>
                
                <th>AH -0.75_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '28' checked/></th>
                <th>AH -0.75_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '29' checked/></th>
                
                <th>AH -0.5_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '30' checked/></th>
                <th>AH -0.5_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '31' checked/></th>

                <th>AH -0.25_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '32' checked/></th>
                <th>AH -0.25_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '33' checked/></th>

                <th>AH 0.0_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '34' checked/></th>
                <th>AH 0.0_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '35' checked/></th>

                <th>AH +0.25_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '36' checked/></th>
                <th>AH +0.25_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '37' checked/></th>

                <th>AH +0.5_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '38' checked/></th>
                <th>AH +0.5_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '39' checked/></th>

                <th>AH +0.75_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '40' checked/></th>
                <th>AH +0.75_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '41' checked/></th>

                <th>AH +1_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '42' checked/></th>
                <th>AH +1_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '43' checked/></th>

                <th>AH +1.25_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '44' checked/></th>
                <th>AH +1.25_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '45' checked/></th>

                <th>AH +1.5_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '46' checked/></th>
                <th>AH +1.5_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '47' checked/></th>

                <th>AH +1.75_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '48' checked/></th>
                <th>AH +1.75_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '49' checked/></th>

                <th>AH +2_1  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '50' checked/></th>
                <th>AH +2_2  &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '51' checked/></th>

                </thead>
                <tbody id="tbody_AH">
                    
                </tbody>
                </table>
            </div >
       
        
        <div class="wrap">
               <div id="loader" style="display: none;"></div>  
        </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="assets/js/weekmatch.js"></script>  
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous"></script>
   

    
@endpush