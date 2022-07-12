@extends('layouts/master')
@section('title', 'Weekly match odds selection')
@section('main')
    <div class="content container-fluid">
        <div class="flex-center container mt-4">
            <div class="flex-center">
                <h1>Weekly Match odds selection</h1><br>
            </div>
          
        </div>

        <div class="row"  style="width: 70%; margin-left:15%;">
            <div class="flex-center" >
                <h4> {{$startDate}}   ~   </h4>
                <h4> {{$endDate}} </h4>
                <div class="col-lg-3 flex-center " >
                    <div><h5 >Stake :  </h5></div>
                    <input value="5000" style = "width:50%; margin-top: -18px;" id="stake_input" onchange="stakeValueChanged()">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div id="talbe_MO_div">
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

                        <th>Home_Bet                        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '21'/></th>
                        <!-- <th>Draw_Bet                        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '22'/></th>
                        <th>Away_Bet                        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '23'/></th> -->

                        <th>Home_Stake                      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '24'/></th>
                        <!-- <th>Draw_Stake                      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '25'/></th>
                        <th>Away_Stake                      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '26'/></th> -->

                        <th>Home_PnL                        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '27'/></th>
                        <!-- <th>Draw_PnL                        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '28'/></th>
                        <th>Away_PnL                        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '29'/></th> -->

                    

                    </thead>
                    <tbody id="tbody_MO" class = "table-bordered">
                        
                    </tbody>
                </table>
            </div>

            <div class="wrap">
               <div id="loader" style="display: none;"></div>  
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script src="assets/js/weekmatchoddsselection.js"></script>  
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous"></script>
   

    
@endpush