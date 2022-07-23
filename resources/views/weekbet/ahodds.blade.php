@extends('layouts/master')
@section('title', 'Weekly Asian Handicap selection')
@section('main')
    <div class="content container-fluid">
        <div class="flex-center container mt-4">
            <div class="flex-center">
                <h1>Weekly Asian Handicap selection</h1><br>
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
        <div id="talbe_AH_div" style="">
            <br>
            <div class="flex-center" id="pre_cont_AH">
            
            </div>
                <table class="table table-striped table-hover" style="width: 8000px;margin-left:50px;" id = 'WeekMatchTable_AH'>
                <thead class="table-dark">
                
                <th>League &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '0' checked/></th>
                <th>Season          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '1' checked/></th>
                <th>Date            &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '2'/></th>
                <th>Game            &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '3'/></th>
                <th>Cream_status    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '4'/></th>
                <th>Score           &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '5'/></th>
                <th>Result          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '6'/></th>
                <th>Home Team       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '7'/></th>
                <th>Dy_HRank(8)     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '8'/></th>
                <th>Away Team       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '9'/></th>
                <th>Dy_ARank(8)     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '10'/></th>
                <th>St_Rank         &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '11'/></th>
                <th>Dy_Rank(8)      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '12'/></th>
                <th>Handicap        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '13' checked/></th>
                <th>A_Price_1       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '14' checked/></th>
                <th>A_Price_2       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '15' checked/></th>
                <th>Real_Price_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '16' checked/></th>
                <th>Real_Price_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '17' checked/></th>
                <th> Edge           &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '18' checked/></th>
                <th>AH Bet          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '19' checked/></th>
                <th>AH Stake        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '20' checked/></th>
                <th>AH PnL          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '21' checked/></th>
               

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
    <script src="assets/js/weekahoddselection.js"></script>  
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous"></script>
   

    
@endpush