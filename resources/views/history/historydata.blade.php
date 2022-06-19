@extends('layouts/master')
@section('title', 'History Data')
@section('main')
    <div class="content container-fluid">
        <div class="flex-center container mt-4">
            <h1 class="flex-center" style="max-width:300px;"> Historic Data</h1>
        </div>
        <br>
        <div id="history_loader"></div>  
        <div id="loader" style="display: none;"></div>  
        <div  class="container" style="color: black; min-width:2500px;display:inline-flex" >
            
            <div style="margin: 0 15px 0 0; display:inline-flex">
              
                <label>League&nbsp;:&nbsp;</label>
                <select id="League_select" multiple style = "width: 250px;" onchange="LeagueChangeFunction(this)">
                    <option>Select All</option>
                    <option value="1">Austrian Tipico Bundesliga</option>
                    <option value="2">Bulgarina Parva Liga</option>
                    <option value="3">Czech 1.Liga</option>
                    <option value="4">Croatia 1. HNL</option>
                    <option value="5">Denmark Superliga</option>
                    <option value="6">England Premier League</option>
                    <option value="7">French Ligue 1</option>
                    <option value="8">German Bundesliga 1</option>
                    <option value="9">Greece Super League</option>
                    <option value="10">Hungary OTP Bank Liga</option>
                    <option value="11">Italy Serie A</option>
                    <option value="12">Netherlands Eredivisie</option>
                    <option value="13">Norway Eliteserien</option>
                    <option value="14">Portugal Primeira Liga</option>
                    <option value="15">Serbia Super Liga</option>
                    <option value="16">Spain La Liga</option>
                    <option value="17">Sweden Allsenskan</option>
                    <option value="18">Swiss Super League</option>
                    <option value="19">Turkish Super Lig</option>
                    <option value="20">Ukraine Premier League</option>
                </select>
            </div>
          
            <div  style="margin: 0 15px; display:inline-flex"  id="season_normal_field">
                    <label>Season&nbsp;:&nbsp;</label>
                        
                    <select id="season_select" style = "width: 250px;"  multiple title="Choose one season" onchange="seasonChangeFunction(this)">
                        <option>Select All</option>
                        <option value="935" class="season_normal">2022-2023</option>
                        <option value="857" class="season_normal">2021-2022</option>
                        <option value="799" class="season_normal">2020-2021</option>
                        <option value="12" class="season_normal">2019-2020</option>
                        <option value="5" class="season_normal">2018-2019</option>
                        <option value="4" class="season_normal">2017-2018</option>
                        <option value="3" class="season_normal">2016-2017</option>
                        <option value="2" class="season_normal">2015-2016</option>
                        <option value="1" class="season_normal">2014-2015</option>
                        <option value="13" class="season_normal">2013-2014</option>
                        <option value="15" class="season_normal">2012-2013</option>
                        <option value="17" class="season_normal">2011-2012</option>
                        <option value="19" class="season_normal">2010-2011</option>
                        <option value="916" class="season_special">2022</option>
                        <option value="844" class="season_special">2021</option>
                        <option value="64" class="season_special">2020</option>
                        <option value="11" class="season_special">2019</option>
                        <option value="10" class="season_special">2018</option>
                        <option value="9" class="season_special">2017</option>
                        <option value="8" class="season_special">2016</option>
                        <option value="7" class="season_special">2015</option>
                        <option value="6" class="season_special">2014</option>
                        <option value="14" class="season_special">2013</option>
                        <option value="16" class="season_special">2012</option>
                        <option value="18" class="season_special">2011</option>
                        <option value="20" class="season_special">2010</option>
                    </select>
            </div>
            <div  style="margin: 0 15px; display:inline-flex"  id="weeknumber_field">
                <label>WeekNumber&nbsp;:&nbsp;</label>
                <input id="weeknumber"  name="week" style = "width: 150px;height:35px;" onchange="weekChangeFunction(this)">   
            </div>
            <div  style="margin: 0 15px; display:inline-flex" id="odds_field">
                  <label> Odds &nbsp;:&nbsp;</label>
                        
                  <select id="odds"   title="Choose odds type" onchange="oddsTypeChangeFunction(this)">
                        <option> Choose Odds</option>    
                        <option value="1" > Match odds</option>
                        <option value="2" > O/U odds</option>
                        <option value="3" > Asian Handicap</option>
                     
                  </select>
            </div>

            

            <div  style="margin: 0 15px; display:inline-flex"  id="stake_field">
                <label>Stake&nbsp;:&nbsp;</label>
                <input  id="stake_val" name="stake_val" style="height:30px" value = '5000' onchange="stakeChangeFunction(this)">   
            </div>

              
              
        </div>
      
        <br><br>
        <div style="margin-left: 20px;" class="container">
          
          <div id="talbe_MO_div" style="display: block;">
                <div class="flex-center" id="pre_table_MO">

                </div>
                <table class="table table-bordered table-striped table-hover" id="rankingTable_MO" style="width:6000px;">
                    <thead class="table-dark">
                        <tr>
                            <th >League         &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '0' checked/></th>
                            <th >Season         &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '1' checked/></th>
                            <th >Date           &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '2'/></th>
                            <th >Week number    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '3' checked/></th>
                            <th >Game            &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '4'/></th>
                            <th >Cream_status   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '5' checked/></th>
                            <th >Score          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '6'/></th>
                            <th >Home Name      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '7'/></th>
                         
                            <th>Home_strength   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '8'/></th>
                            <th >Away Name      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '9'/></th>
                       
                            <th>Away_strength   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '10'/></th>
                            <th>staticRank      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '11'/></th>
                            <th>DynamicRank_8   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '12'/></th>
                            <th>DynamicRank_6   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '13'/></th>

                            <th>Home            &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '14' checked/></th>
                            <th>Draw            &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '15' checked/></th>
                            <th>Away            &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '16' checked/></th>

                            <th>real_Home       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '17'/></th>
                            <th>real_Draw       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '18'/></th>
                            <th>real_Away       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '19'/></th>

                            <th> home_bet       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '20'/></th>
                            <th> draw_bet       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '21'/></th>
                            <th> away_bet       &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '22'/></th>

                            <th>Home_stake      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '23'/></th>
                            <th>Draw_stake      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '24'/></th>
                            <th>Away_stake      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '25'/></th>

                            <th>Home_PnL        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '26'/></th>
                            <th>Draw_PnL        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '27'/></th>
                            <th>Away_PnL        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '28'/></th>
                        </tr>
                    </thead>
                </table>
          </div>

          <div id="talbe_OU_div" style="display: none;">
                <div class="flex-center" id="pre_table_OU">

                </div>
                <table class="table table-bordered table-striped table-hover" id="rankingTable_OU" style="width:5000px;">
                    <thead class="table-dark">
                        <tr>
                     
                        <th >League         &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '0' checked/></th>
                        <th >Season         &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '1' checked/></th>
                        <th >Date           &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '2'/></th>
                        <th >Week number    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '3' checked/></th>
                        <th>Game            &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '4'/></th>
                        <th >Cream_status   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '5' checked/></th>
                        <th >Score          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '6'/></th>
                        <th >Home Name      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '7'/></th>
                  
                        <th>Home_strength   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '8'/></th>
                        <th >Away Name      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '9'/></th>
                  
                        <th>Away_strength   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '10'/></th>
                        <th>staticRank      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '11'/></th>
                        <th>DynamicRank_8   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '12'/></th>
                        <th>DynamicRank_6   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '13'/></th>

                        <th>Actual_Over     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '14' checked/></th>
                        <th>Actual_Under    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '15' checked/></th>

                

                  </tr>
               </thead>
            </table>
          </div>

          <div id="talbe_AH_div" style="display: none;">
            <div class="flex-center" id="pre_table_AH">

            </div>
            <table class="table table-bordered table-striped" id="rankingTable_AH" style="width:8000px;">
               <thead class="table-dark">
                  <tr>
                     
                     <th >League        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '0' checked/></th>
                     <th >Season        &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '1' checked/></th>
                     <th >Date          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '2' /></th>
                     <th >Week number   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '3' checked/></th>
                     <th >Game           &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '4' /></th>
                     <th >Cream_status   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '5' checked/></th>
                     <th >Score          &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '6' /></th>
                     <th >Home Name      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '7' /></th>
               
                     <th>Home_strength   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '8' /></th>
                     <th >Away Name      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '9' /></th>
                     <th>Away_strength   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '10' /></th>
                     <th>staticRank      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '11' /></th>
                     <th>DynamicRank_8   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '12' /></th>
                     <th>DynamicRank_6   &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '13' /></th>
                     <th>AH -2.0_1      &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '14' checked/></th>
                      <th>AH -2.0_2     &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '15' checked/></th>
                      
                      <th>AH -1.75_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '16' checked/></th>
                      <th>AH -1.75_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '17' checked/></th>

                      <th>AH -1.5_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '18' checked/></th>
                      <th>AH -1.5_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '19' checked/></th>
                      
                      <th>AH -1.25_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '20' checked/></th>
                      <th>AH -1.25_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '21' checked/></th>
                      
                      <th>AH -1.0_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '22' checked/></th>
                      <th>AH -1.0_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '23' checked/></th>
                      
                      <th>AH -0.75_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '24' checked/></th>
                      <th>AH -0.75_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '25' checked/></th>
                      
                      <th>AH -0.5_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '26' checked/></th>
                      <th>AH -0.5_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '27' checked/></th>

                      <th>AH -0.25_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '28' checked/></th>
                      <th>AH -0.25_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '29' checked/></th>

                      <th>AH 0.0_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '30' checked/></th>
                      <th>AH 0.0_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '31' checked/></th>

                      <th>AH +0.25_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '32' checked/></th>
                      <th>AH +0.25_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '33' checked/></th>
                      <th>AH +0.5_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '34' checked/></th>
                      <th>AH +0.5_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '35' checked/></th>

                      <th>AH +0.75_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '36' checked/></th>
                      <th>AH +0.75_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '37' checked/></th>

                      <th>AH +1.0_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '38' checked/></th>
                      <th>AH +1.0_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '39' checked/></th>

                      <th>AH +1.25_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '40' checked/></th>
                      <th>AH +1.25_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '41' checked/></th>

                      <th>AH +1.5_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '42' checked/></th>
                      <th>AH +1.5_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '43' checked/></th>

                      <th>AH +1.75_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '44' checked/></th>
                      <th>AH +1.75_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '45' checked/></th>

                      <th>AH +2.0_1    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '46' checked/></th>
                      <th>AH +2.0_2    &nbsp;<input type="checkbox" class='table_header_checker' name="League" value = '47' checked/></th>

                     

                  </tr>
               </thead>
            </table>
          </div>

        </div>
        <div id="buttons">
          
        </div>
    </div>
@endsection
@push('scripts')
    <script src="assets/js/history.js"></script>  
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous"></script>
@endpush