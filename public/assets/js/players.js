var league_id;
var season_id;
$(document).ready(function(){
  
  //$('#season_special_field').hide();
  setTimeout(function() {    
       
        $("#loader").fadeOut("slow");
        }, 200);
   //$('select').selectpicker(); 
  

});
function LeagueChangeFunction(obj)
{
   if(obj.value == 13 || obj.value ==  17)
   {
       $('#season_special_field').show();
        $('#season_normal_field').hide();
   }
   else{
        $('#season_special_field').hide();
        $('#season_normal_field').show();
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
function dataTableSetting(){

    $('#matchTable').DataTable({
           processing: false,
           lengthMenu: [[25, 50, -1], [25, 50, "All"]],
            pageLength: 25,
           destroy: true,
           serverSide: true,
           ajax: 
           {
            url: "players"+"/"+league_id+"/"+season_id,
            type: 'GET',

            data: function (d) {
                d.league_id = league_id;
                d.season_id = season_id;
            }
          },
          columns: [
              {data: 'Player',  name: 'Player' , width:'18%'},
              {data: 'Team',  name: 'Team' , width: "18%"},
              {data: 'Born',  name: 'Born' , width: "4%"},
              {data: 'Height',  name: 'Height' , width: "4%"},
              {data: 'Pos',  name: 'Pos' , width: "4%"},
             ],
          "order": [[ 1, "asc" ]]
        });
    var buttons = new $.fn.dataTable.Buttons("#matchTable", {
       buttons: [{
            extend : 'excel',
            text : 'Export to Excel',
            exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'original',  // 'current', 'applied', 'index',  'original'
                    page : 'all',      // 'all',     'current'
                    search : 'none'     // 'none',    'applied', 'removed'
                }
            }
       }

        
      ]

  }).container().appendTo($('#pre_cont'));
}