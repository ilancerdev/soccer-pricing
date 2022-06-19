@extends('layouts/master')
@section('title', 'Players')
@section('main')
    <div class="content container-fluid">
        <div class="flex-center container mt-4">
            <h1>Search any Players</h1>
        </div>
        <br>
        <div id="loader"></div>  
        <div  class="flex-center row " style="color: black;">
              <div style="margin: 0 15px;display:inline-flex" class="col-md-4 col-lg-4  text-center">
                    <label>League&nbsp;:&nbsp;</label>
                        <select id="League"  class="form-select" aria-label="Default select example" onchange="LeagueChangeFunction(this)">
                            <option> Choose one League </option>
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
              <div style="margin: 0 15px;display:inline-flex" class="col-md-4 col-lg-4  text-center" id="season_normal_field">
                  <label>Season&nbsp;:&nbsp;</label>
                        <select id="season"  class="form-select" aria-label="Default select example" onchange="seasonChangeFunction(this)">
                            <option> Choose one Season </option>
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
                        </select>
              </div>
              <div style="margin: 0 15px; display: none;" class="col-md-4 col-lg-4  text-center" id="season_special_field">
                  <label>Season:</label>
                        <select id="season" class="form-select" aria-label="Default select example" onchange="seasonChangeFunction(this)">
                            <option> Choose one Season </option> 
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
        </div>
        <br>
        <div class="flex-center row">
           <div class = "flex-center" id="pre_cont">

           </div>
            <table class="table table-bordered table-striped table-hover" id="matchTable" style="width:1000px;margin:0 auto;">
               <thead class="table-dark">
                  <tr>
                     <th >Player</th>
                     <th >Team</th>
                     <th >Born</th>
                     <th >Height</th>
                     <th >Pos</th>
                     
                  </tr>
               </thead>
            </table>
       
        </div>
        <div id="buttons">
          
        </div>
    </div>
@endsection
@push('scripts')
    <script src="assets/js/players.js"></script>  
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
   
    
@endpush