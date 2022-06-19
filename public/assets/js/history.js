var league_id_array;
var season_id_array;
var oddstype;
var weeknumberArray;
var stake;
var mo_column_select = [  0 , 1, 3 , 5, 14 , 15, 16  ];
var ou_column_select = [  0 , 1, 3 , 5, 14, 15];
var ah_column_select = [  0 , 1, 3 , 5, 14, 15, 16 ,17,18, 19, 20, 21, 22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46 , 47];

function add(arr, value) {
  const found = arr.some(el => el == value);
  if (!found) arr.push(value);
  arr.sort(function(a, b){return a - b})
  return arr;
}
function rm_element(arr, value) {
  const found = arr.some(el => el == value);
  if (found) {
    index = arr.indexOf(value)
    arr.splice(index,1)
  }
  arr.sort(function(a, b){return a - b})
  return arr;
}

$(document).ready(function()
{
    $("#League_select").select2();
    $("#season_select").select2();
    $("#odds").select2();
    setTimeout(function()
    {    
        $("#history_loader").fadeOut("slow");
        }, 100);

  stake = $("#stake_val").val()

  $('#rankingTable_MO .table_header_checker').click(function(event){
    event.stopPropagation();
    value =  $(this).attr('value')
    if ($(this).prop("checked") == true)
      {
        console.log("checked")
        add(mo_column_select, parseInt(value))
      }
    else
    {
      console.log("unchecked")
      rm_element(mo_column_select, parseInt(value))
    } 
      
    console.log(mo_column_select)
    
  });
  $('#rankingTable_OU .table_header_checker').click(function(event){
    event.stopPropagation();
    value =  $(this).attr('value')
    if ($(this).prop("checked") == true)
      {
        console.log("checked")
        add(ou_column_select, parseInt(value))
      }
    else
    {
      console.log("unchecked")
      rm_element(ou_column_select, parseInt(value))
    } 
      
    console.log(ou_column_select)
    
  });

  $('#rankingTable_AH .table_header_checker').click(function(event){
    event.stopPropagation();
    value =  $(this).attr('value')
    if ($(this).prop("checked") == true)
      {
        console.log("checked")
        add(ah_column_select, parseInt(value))
      }
    else
    {
      console.log("unchecked")
      rm_element(ah_column_select, parseInt(value))
    } 
      
    console.log(ah_column_select)
    
  });

});
function LeagueChangeFunction(obj)
{
  if (obj.selectedIndex == 0)
  {
    //$('#League_select').selectpicker('selectAll');
    $("#League_select option").prop("selected", "selected");
  }
  var selected = [...obj.selectedOptions].map(option => option.value);
   league_id_array = selected.join(',');
   if (league_id_array && season_id_array && oddstype) {
      showTable();
   }
}
function seasonChangeFunction(obj)
{
  if (obj.selectedIndex == 0)
  {
    $("#season_select option").prop("selected", "selected");;
  }
  var selected = [...obj.selectedOptions] .map(option => option.value);
  season_id_array = selected.join(',');
  if (league_id_array && season_id_array && oddstype) {
      showTable();
  }

}

function stakeChangeFunction(obj){
    stake = $("#stake_val").val()
    if (league_id_array && season_id_array && oddstype) {
        showTable();
    }
}

function weekChangeFunction(obj)
{
  
    weeknumberArray = obj.value;
    if (league_id_array && season_id_array && oddstype) {
      showTable();
    }

}
function oddsTypeChangeFunction(obj)
{
    oddstype = obj.value;
    if (league_id_array && season_id_array && oddstype) {
        showTable();
   }

}
function showTable()
{
  console.log(season_id_array);
  console.log(weeknumberArray);
  if(oddstype ==  1)
    showTable_MO();
  if(oddstype ==  2)
    showTable_OU();
  if (oddstype == 3)
    showTable_AH();
}
function showTable_MO()
{
    $("#loader").fadeIn("slow");
   $("#talbe_MO_div").css("display", "block");
   $("#talbe_AH_div").css("display", "none");
   $("#talbe_OU_div").css("display", "none");
   
      $('#rankingTable_MO').DataTable({
        processing: false,
        lengthMenu: [[10, 50, 100, -1], [ 10,50, 100, "All"]],
        pageLength: 100,
        destroy: true,
        serverSide: true,
        
        ajax: {
          url: "showDynamnicRanking_MO",
          type: 'POST',
          data:
          {
            _token : $('meta[name="csrf-token"]').attr('content'),
            season_id_array : season_id_array,
            league_id_array : league_id_array,
            weeknumber_array : weeknumberArray,
            stake_val : stake
          }
          
          },
          columns: [
                
                { data: 'league_title',  name: 'league_title', width: '200px' },
                { data: 'season_title', name: 'season_title' },
                { data: 'date', name: 'date' },
                { data: 'c_WN', name: 'c_WN' },
                { data: 'Game', name: 'Game', width:'200px'},
                { data: 'cream_status', name: 'cream_status'} ,
                { data: 'Score', name: 'Score' },
                { data: 'Home_team_name', name: 'Home_team_name'},
                { data: 'home_team_strength', name: 'home_team_strength'},
                { data: 'Away_team_name', name: 'Away_team_name'},
                { data: 'Away_team_strength', name: 'Away_team_strength'},
                { data: 'staticRank', name: 'staticRank'},
                { data: 'DynamicRank_8', name: 'DynamicRank_8'},
                { data: 'DynamicRank_6', name: 'DynamicRank_6'},
                { data: 'Home', name: 'Home'},
                { data: 'Draw', name: 'Draw'},
                { data: 'Away', name: 'Away'},
                { data: 'H_price', name: 'H_price'},
                { data: 'D_price', name: 'D_price'},
                { data: 'A_price', name: 'A_price'},
                { data: 'home_bet', name: 'home_bet'},
                { data: 'draw_bet', name: 'draw_bet'},
                { data: 'away_bet', name: 'away_bet'},
                { data: 'home_stake', name: 'home_stake'},
                { data: 'draw_stake', name: 'draw_stake'},
                { data: 'away_stake', name: 'away_stake'},
                { data: 'home_pnl', name: 'home_pnl'},
                { data: 'draw_pnl', name: 'draw_pnl'},
                { data: 'away_pnl', name: 'away_pnl'},

           
          ],
          createdRow: function ( row, data, index ) 
          {  
            $('td', row).eq(14).addClass('table-success');
            $('td', row).eq(15).addClass('table-success');
            $('td', row).eq(16).addClass('table-success');

            $('td', row).eq(17).addClass('table-info');
            $('td', row).eq(18).addClass('table-info');
            $('td', row).eq(19).addClass('table-info');  

            $('td', row).eq(20).addClass('table-danger');
            $('td', row).eq(21).addClass('table-danger');
            $('td', row).eq(22).addClass('table-danger');

            $('td', row).eq(23).addClass('table-warning');
            $('td', row).eq(24).addClass('table-warning');
            $('td', row).eq(25).addClass('table-warning');

            $('td', row).eq(26).addClass('table-primary');
            $('td', row).eq(27).addClass('table-primary');
            $('td', row).eq(28).addClass('table-primary');
            
        }

      }
      );
      $("#loader").fadeOut("slow");
      var buttons = new $.fn.dataTable.Buttons("#rankingTable_MO", {
       buttons: [{
            extend : 'excel',
            text : 'Export to Excel',
            exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'original',   // 'current', 'applied', 'index',  'original'
                    page : 'all',         // 'all',     'current'
                    search : 'none'       // 'none',    'applied', 'removed'
                } ,
                columns: mo_column_select
              
            }
       }

        
      ]

    }).container().appendTo($('#pre_table_MO'));            

    
}

function showTable_OU()
{
  
   $("#talbe_MO_div").css("display", "none");
   $("#talbe_AH_div").css("display", "none");
   $("#talbe_OU_div").css("display", "block");
   
      $('#rankingTable_OU').DataTable({
            processing: false,
            lengthMenu: [[10, 50, 100, -1], [ 10,50, 100, "All"]],
            pageLength: 100,
            destroy: true,
            serverSide: true,
            
            ajax: {
              url: "showDynamnicRanking_OU",
              type: 'POST',
              data:
              {
                _token :  $('meta[name="csrf-token"]').attr('content'),
                season_id_array : season_id_array,
                league_id_array : league_id_array,
                weeknumber_array : weeknumberArray,
              }
              
            },
            columns: [
                  
                  { data: 'league_title',  name: 'league_title', width: '300px' },
                  { data: 'season_title', name: 'season_title' },
                  { data: 'date', name: 'date' },
                  { data: 'c_WN', name: 'c_WN' },
                  { data: 'Game', name: 'Game'},
                  { data: 'cream_status', name: 'cream_status'} ,
                  { data: 'Score', name: 'Score' },
                  { data: 'Home_team_name', name: 'Home Name' },
                  
                  { data: 'home_team_strength', name: 'home_team_strength'},
                  { data: 'Away_team_name', name: 'Away Name'},
                 
                  { data: 'Away_team_strength', name: 'Away_team_strength'},
                  { data: 'staticRank', name: 'staticRank'},
                  { data: 'DynamicRank_8', name: 'DynamicRank_8'},
                  { data: 'DynamicRank_6', name: 'DynamicRank_6'},
                 
                  { data: 'highest_Over', name: 'Over 2.5'},
                  { data: 'highest_Under', name: 'Under 2.5'},
            ]

      }
      );
      
      var buttons = new $.fn.dataTable.Buttons("#rankingTable_OU", {
       buttons: [{
            extend : 'excel',
            text : 'Export to Excel',
            exportOptions : {
                modifier : {
                    // DataTables core
                    order : 'original',  // 'current', 'applied', 'index',  'original'
                    page : 'all',      // 'all',     'current'
                    search : 'none'     // 'none',    'applied', 'removed'
                },
                columns: ou_column_select
            }
       }

        
      ]

    }).container().appendTo($('#pre_table_OU'));            

    
}

function showTable_AH()
{
  $("#talbe_MO_div").css("display", "none");
  $("#talbe_OU_div").css("display", "none");
  $("#talbe_AH_div").css("display", "block");
  
  $('#rankingTable_AH').DataTable({
        processing: false,
        lengthMenu: [[10, 50, 100, -1], [ 10,50, 100, "All"]],
        pageLength: 100,
        destroy: true,
        serverSide: true,
        
        ajax: {
          url: "showDynamnicRanking_AH",
          type: 'POST',
          data:
          {
            _token :  $('meta[name="csrf-token"]').attr('content'),
            season_id_array : season_id_array,
            league_id_array : league_id_array,
            weeknumber_array : weeknumberArray,
          }
          
        },
        columns: [
              
              { data: 'league_title',  name: 'league_title', width: '300px' },
              { data: 'season_title', name: 'season_title' },
              { data: 'date', name: 'date' },
              { data: 'c_WN', name: 'c_WN' },
              { data: 'Game', name: 'Game'},
              { data: 'cream_status', name: 'cream_status'} ,
              { data: 'Score', name: 'Score' },
              { data: 'Home_team_name', name: 'Home Name' },
           
              { data: 'home_team_strength', name: 'home_team_strength'},
              { data: 'Away_team_name', name: 'Away Name'},
          
              { data: 'Away_team_strength', name: 'Away_team_strength'},
              { data: 'staticRank', name: 'staticRank'},
              { data: 'DynamicRank_8', name: 'DynamicRank_8'},
              { data: 'DynamicRank_6', name: 'DynamicRank_6'},

              { data: 'AH2_1'   , name: 'AH -2.0_1'},
              { data: 'AH2_2'   , name: 'AH -2.0_2'},

              { data: 'AH1d75_1'   , name: 'AH -1.75_1'},
              { data: 'AH1d75_2'   , name: 'AH -1.75_2'},
              { data: 'AH1d5_1'   , name: 'AH -1.5_1'},
              { data: 'AH1d5_2'   , name: 'AH -1.5_2'},
              { data: 'AH1d25_1'   , name: 'AH -1.25_1'},
              { data: 'AH1d25_2'   , name: 'AH -1.25_2'},
              { data: 'AH1_1'   , name: 'AH -1.0_1'},
              { data: 'AH1_2'   , name: 'AH -1.0_2'},
              { data: 'AH0d75_1'   , name: 'AH -0.75_1'},
              { data: 'AH0d75_2'   , name: 'AH -0.75_2'},
              { data: 'AH0d5_1'   , name: 'AH -0.5_1'},
              { data: 'AH0d5_2'   , name: 'AH -0.5_2'},
              { data: 'AH0d25_1'   , name: 'AH -0.25_1'},
              { data: 'AH0d25_2'   , name: 'AH -0.25_2'},

              { data: 'AH0_1'   , name: 'AH 0.0_1'},
              { data: 'AH0_2'   , name: 'AH 0.0_2'},

              { data: 'AH_p0d25_1'   , name: 'AH +0.25_1'},
              { data: 'AH_p0d25_2'   , name: 'AH +0.25_2'},
              { data: 'AH_p0d5_1'   , name: 'AH +0.5_1'},
              { data: 'AH_p0d5_2'   , name: 'AH +0.5_2'},
              { data: 'AH_p0d75_1'   , name: 'AH +0.75_1'},
              { data: 'AH_p0d75_2'   , name: 'AH +0.75_2'},

              { data: 'AH_p1_1'   , name: 'AH +1.0_1'},
              { data: 'AH_p1_2'   , name: 'AH +1.0_2'},

              { data: 'AH_p1d25_1'   , name: 'AH +1.25_1'},
              { data: 'AH_p1d25_2'   , name: 'AH +1.25_2'},

              { data: 'AH_p1d5_1'   , name: 'AH +1.5_1'},
              { data: 'AH_p1d5_2'   , name: 'AH +1.5_2'},

              { data: 'AH_p1d75_1'   , name: 'AH +1.75_1'},
              { data: 'AH_p1d75_2'   , name: 'AH +1.75_2'},

              { data: 'AH_p2_1'   , name: 'AH +2.0_1'},
              { data: 'AH_p2_2'   , name: 'AH +2.0_2'}
              

        ]

  });
  var buttons = new $.fn.dataTable.Buttons("#rankingTable_AH", {
    buttons: [{
        extend : 'excel',
        text : 'Export to Excel',
        exportOptions : {
            modifier : {
                // DataTables core
                order : 'original',  // 'current', 'applied', 'index',  'original'
                page : 'all',      // 'all',     'current'
                search : 'none'     // 'none',    'applied', 'removed'
            }, 
            columns: ah_column_select
        }
    }]

  }).container().appendTo($('#pre_table_AH'));
  
  

    

}