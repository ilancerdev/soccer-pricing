@extends('layouts/master')
@section('title', 'Price Data')
@section('main')
    <div class="content container-fluid">
        <div class="flex-center container mt-4">
            <h1 class="flex-center" style="max-width:300px;"> Price Data</h1>
        </div>
        <br>
        <div id="history_loader"></div>  
        <div id="loader" style="display: none;"></div>  
        <div  class="container flex-center" style="color: black;  display:inline-flex" >
            
            
            <div  style="margin: 0 15px; display:inline-flex"  id="weeknumber_field">
                <label>WeekNumber&nbsp;:&nbsp;</label>
                <input id="weeknumber" type="number" name="week" style = "width: 150px;height:35px;" onchange="weekChangeFunction(this)" required>   
            </div>
            <div  style="margin: 0 15px; display:inline-flex" id="odds_field">
                  <label> Markets &nbsp;:&nbsp;</label>
                        
                  <select id="markets"   title="Choose odds type" onchange="MarketTypeChangeFunction(this)" style="min-width: 200px;">
                        <option> Choose Markets</option>    
                        <option value="M" >     Match odds          </option>
                        <option value="-2" >    Asian Handicap -2   </option>
                        <option value="-1.75" > Asian Handicap -1.75</option>
                        <option value="-1.5" >  Asian Handicap -1.5</option>
                        <option value="-1.25" > Asian Handicap -1.25</option>
                        <option value="-1" >    Asian Handicap -1</option>
                        <option value="-0.75" > Asian Handicap -0.75</option>
                        <option value="-0.5" >  Asian Handicap -0.5</option>
                        <option value="-0.25" > Asian Handicap -0.25</option>
                        <option value="0" >     Asian Handicap 0</option>
                        <option value="+0.25" > Asian Handicap +0.25</option>
                        <option value="+0.5" >  Asian Handicap +0.5</option>
                        <option value="+0.75" > Asian Handicap +0.75</option>
                        <option value="+1" >    Asian Handicap +1</option>
                        <option value="+1.25" > Asian Handicap +1.25</option>
                        <option value="+1.5" >  Asian Handicap +1.5</option>
                        <option value="+1.75" > Asian Handicap +1.75</option>
                        <option value="+2" >    Asian Handicap +2</option>
                     
                  </select>
            </div>
              
        </div>
         
        <br><br>
        <div style="margin-left: 20px;" class="container">
          
          <div id="talbe_MO_div" style="display: block;">
                <div class="flex-center" id="pre_table_MO">

                </div>
                <table class="table table-bordered table-striped table-hover" id="table_mo_price" style="width:1500px;">
                    <thead class="table-dark">
                        <tr>
                            <th >Labels</th>
                            <th> Week </th>
                            <th >H      </th>
                            <th >D      </th>
                            <th >A      </th>
                            <th >Total  </th>
                            <th >H%     </th>
                            <th >D%     </th>
                            <th >A%     </th>
                            <th>H price </th>
                            <th>D price</th>
                            <th>A price</th>
                       
                          
                        </tr>
                    </thead>
                </table>
          </div>

          

          <div id="talbe_AH_div" style="display: none;">
            <div class="flex-center" id="pre_table_AH">

            </div>
            <table class="table table-bordered table-striped" id="table_ah_price" style="width:1500px;">
               <thead class="table-dark">
                  <tr>
                     <th >Labels        </th>
                     <th> Week          </th>
                     <th >win           </th>
                     <th >lose          </th>
                     <th >flat          </th>
                     <th >Half win      </th>
                     <th >Half lose     </th>
                     <th >Total win     </th>
                     <th >Total lose    </th>
                     <th >Grand total   </th>
                     <th>Home Prob      </th>
                     <th >Home Price    </th>
                     <th>Away Prob      </th>
                     <th>Away Price     </th>
                     
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
    <script src="assets/js/price_service.js"></script>  
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous"></script>
@endpush 