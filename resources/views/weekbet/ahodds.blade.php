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
    <script src="assets/js/weekahoddselection.js"></script>  
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous"></script>
   

    
@endpush