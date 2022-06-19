var league_id;
var season_id;
$(document).ready(function(){
  
  //$('#season_special_field').hide();
  setTimeout(function() {    
        
        $("#loader").fadeOut("slow");
        }, 200);

});
function LeagueChangeFunction(obj){
   if(obj.value == 13 || obj.value ==  17)
   {
       $('#season_special_field').css('display','inline-flex');
        $('#season_normal_field').css('display', 'none');
   }
   else{
        $('#season_special_field').css('display', 'none');
        $('#season_normal_field').css('display','inline-flex');
   }
   league_id = obj.value;
   if (league_id && season_id) {
        dataTableSetting();
   }
}
function seasonChangeFunction(obj){

    //alert(obj.value);
    season_id = obj.value;
    
   if (league_id && season_id) {
        dataTableSetting();
   }

}
function dataTableSetting()
{
  
  $('#matchTable').DataTable({
          processing: false,
          lengthMenu: [[100, -1], [100, "All"]],
          pageLength: 100,
          destroy: true,
          serverSide: true,
          ajax: {
          url: "matchlist",
          type: 'GET',

          data: function (d) {
              d.league_id = league_id;
              d.season_id = season_id;
          }
        },
        columns: [
              {data: 'No',     name: 'No' },
              { data: 'Date',  name: 'Date'},
              {data: 'WN',     name: 'Week Number'} ,
              { data: 'Time',  name: 'Time'},
              { data: 'Home',  name: 'Home' },
              { data: 'Score', name: 'Score'  },
              { data: 'Away',  name: 'Away'},
              { data: 'Half',  name: 'Half' },
              { data: 'match_Status', name: 'status'},
              { data: 'odds',  name: 'odds'}, 
        
            ],
        


      });
      
 
  $('#matchTable').css('visibility', 'initial');
}