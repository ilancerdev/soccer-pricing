var stake_val;
var timer;

// initial column select list for priting excel
var mo_column_select = [  0 , 1, 3 ,5 , 15, 16 , 17 ];
var ou_column_select = [  0 , 1, 3 , 12, 13];
var ah_column_select = [  0 , 1, 3 , 18, 19, 20, 21, 22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51];


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

$(document).ready(function(){
  
  $('#WeekMatchTable_MO .table_header_checker').click(function(event){
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

  $('#WeekMatchTable_OU .table_header_checker').click(function(event){
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

  $('#WeekMatchTable_AH .table_header_checker').click(function(event){
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



  stake_val = $('#stake_input').val();

}) ;

function stakeValueChanged()
{
  stake_val = $('#stake_input').val();
  console.log(stake_val)
  $('#WeekMatchTable_MO').DataTable().clear(); 
  $('#WeekMatchTable_MO').DataTable().destroy(); 
  get_weekMatches_withMO()
}

function get_Stake_Pnl(actual_odd, real_odd)
{
   
   percent =  (1 / real_odd)
   
   //percent = percent.toFixed
   stake = ((actual_odd -1) * percent - (1 - percent)) / (actual_odd - 1) * stake_val
   
   
   return stake;
}
function get_weekMatches_withMO()
{
  var table;
  $("#loader").fadeIn("fast");
  $.ajax({
      url: "showMatchsOfThisWeek_MO",
      type : 'GET',
      
      dataType: 'json',
      
      success:function(response)
      {          
        
        if ($.fn.DataTable.isDataTable('#WeekMatchTable_MO')) {
              
              $('#WeekMatchTable_MO').dataTable().fnDestroy();
           
          }
        console.log(response);
        len = response['tbody'].length;
        
        if(len == 0)
        {
          $('#tbody_MO').html("");
          $('#tbody_MO').append("<tr><td  colspan = '50'>No availabe data now!</td></tr>");
          $("#loader").fadeOut("fast");
          alert("No data this week.");
        }
        else
        {
            $('#tbody_MO').html("");
            len = response['tbody'].length;
            matches_object = response['tbody'];
            var str_tr = "";
            
            for(var i = 0; i< len; i++)
            {
              var home_bet = "";
              var home_Stake = "" , home_PnL = "", draw_Stake = "", draw_PnL = "", away_Stake = "", away_PnL = "";
              var draw_bet = "";
              var away_bet = "";
              if(matches_object[i]. Real_Home)
              {
                real_home_price = parseFloat(matches_object[i]. Real_Home);
                actual_home_price = parseFloat(matches_object[i]. highest_Home)
                if (actual_home_price > real_home_price)
                {
                  home_bet = "Bet";
                  if(matches_object[i].Result != '-'){
                    home_Stake = get_Stake_Pnl(actual_home_price, real_home_price)
                  
                    home_Stake = home_Stake.toFixed(2);
                    home_PnL = (matches_object[i].Result == 'H') ? home_Stake * (actual_home_price - 1): (0 - home_Stake);
                    home_PnL = home_PnL.toFixed(2)
                  }
                  
                }
                else
                {
                  home_bet = "No Bet";
                  if(matches_object[i].Result != '-')
                  {
                    home_Stake = "0"
                    home_PnL = "0"
                  }
                  
                }
              }

              if(matches_object[i]. Real_Draw){
                real_draw_price = parseFloat(matches_object[i]. Real_Draw);
                actual_draw_price = parseFloat(matches_object[i]. highest_Draw)
                if (actual_draw_price > real_draw_price)
                {
                  draw_bet = "Bet";
                  if(matches_object[i].Result != '-'){
                    draw_Stake = get_Stake_Pnl(actual_draw_price, real_draw_price)
                    draw_Stake = draw_Stake.toFixed(2);
                    draw_PnL = (matches_object[i].Result == 'D') ? draw_Stake * (actual_draw_price - 1): (0 - draw_Stake);
                    draw_PnL = draw_PnL.toFixed(2)
                  }
                }
                  
                else{
                  draw_bet = "No Bet"
                  if(matches_object[i].Result != '-')
                  {
                    draw_Stake = "0"
                    draw_PnL = "0"
                  }
                }
                
              }

              if(matches_object[i]. Real_Away){
                real_away_price = parseFloat(matches_object[i]. Real_Away);
                actual_away_price = parseFloat(matches_object[i]. highest_Away)
                if (actual_away_price > real_away_price)
                {
                  away_bet = "Bet";
                  if(matches_object[i].Result != '-'){
                    away_Stake = get_Stake_Pnl(actual_away_price, real_away_price)
                    away_Stake = away_Stake.toFixed(2);
                    away_PnL = (matches_object[i].Result == 'A') ? away_Stake * (actual_away_price - 1): (0 - away_Stake);
                    away_PnL = away_PnL.toFixed(2)
                  }
                }
                  
                else{
                  away_bet = "No Bet"
                  if(matches_object[i].Result != '-')
                  {
                    away_Stake = "0"
                    away_PnL = "0"
                  }
                }
                
              }
              

              str_tr += "<tr>" +
                
                "<td align='center' class = 'table-light'>" + matches_object[i].League + "</td>" +
                "<td align='center'  class = 'table-light'>" + matches_object[i].Season + "</td>" +
                "<td align='center'  class = 'table-light'>" + matches_object[i].Date + "</td>" +
                
                "<td align='center'  class = 'table-light'>" + matches_object[i].wn + "</td>" +
                "<td align='center'  class = 'table-light'>" + matches_object[i].Game + "</td>" +
                "<td align='center'  class = 'table-light'>" + matches_object[i].cream_status + "</td>" +

                "<td align='center'  class = 'table-light'>" + matches_object[i].Score + "</td>" +
                "<td align='center'  class = 'table-light'>" + matches_object[i].Result + "</td>" +
                "<td align='center'  class = 'table-light'>" + matches_object[i].Home_team_name + "</td>" +

                "<td align='center'  class = 'table-light'>" + matches_object[i].Away_team_name + "</td>" +

                "<td align='center'  class = 'table-light'>" + matches_object[i].staticRank + "</td>" +
                "<td align='center'  class = 'table-light'>" + matches_object[i].Dynamic_HRank_6 + " v " + matches_object[i].Dynamic_ARank_6 + "</td>" +
                "<td align='center'  class = 'table-light'>" +  matches_object[i].Dynamic_HRank_8 + " v " + matches_object[i].Dynamic_ARank_8 + "</td>" +

                "<td align='center'  class = 'table-light'>" +  ( matches_object[i].home_team_strength ? matches_object[i].home_team_strength: '') + "</td>" +
                "<td align='center'  class = 'table-light'>" +  ( matches_object[i].away_team_strength ? matches_object[i].away_team_strength: '')+ "</td>" +

                "<td align='center' class = 'table-success'>" +  (matches_object[i]. highest_Home+"" ? matches_object[i]. highest_Home : '')+  "</td>" +
                "<td align='center' class = 'table-success'>" +  (matches_object[i]. highest_Draw+"" ?matches_object[i]. highest_Draw: '')+ "</td>" +
                "<td align='center' class = 'table-success'>" +  (matches_object[i]. highest_Away+"" ? matches_object[i]. highest_Away: '')+ "</td>" +

                "<td align='center' class= 'table-info'>" + ( matches_object[i]. Real_Home ? matches_object[i]. Real_Home: '' ) + "</td>" +
                "<td align='center' class= 'table-info'>" + ( matches_object[i]. Real_Draw ? matches_object[i]. Real_Draw : '') + "</td>" +
                "<td align='center' class= 'table-info'>" + ( matches_object[i]. Real_Away ? matches_object[i]. Real_Away : '') + "</td>" +

                "<td align='center'  class= 'table-danger'>" + home_bet + "</td>" +
                "<td align='center'  class= 'table-danger'>" + draw_bet + "</td>" +
                "<td align='center'  class= 'table-danger'>" + away_bet + "</td>" +


                "<td align='center'  class= 'table-warning'>" + home_Stake + "</td>" +
                "<td align='center'  class= 'table-warning'>" + draw_Stake + "</td>" +
                "<td align='center'  class= 'table-warning'>" + away_Stake + "</td>" +

                
                "<td align='center'  class= 'table-primary'>" + home_PnL + "</td>" +
                "<td align='center'  class= 'table-primary'>" + draw_PnL + "</td>" +
                "<td align='center'  class= 'table-primary'>" + away_PnL + "</td>" +
                
                
                "</tr>";
            }
            $('#tbody_MO').append(str_tr);
            $("#loader").fadeOut("fast");
            table = $('#WeekMatchTable_MO').dataTable({
              lengthMenu: [[25, 50, 100, -1], [25,50, 100, "All"]],
              pageLength: 25 ,
              destroy: true
            });
            
        
        
        
        var buttons = new $.fn.dataTable.Buttons("#WeekMatchTable_MO", {
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
                      columns: mo_column_select
                  }
            } ]

            }).container().appendTo($('#pre_cont_MO'));
          }               
      },
      error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
          console.log(JSON.stringify(jqXHR));
          
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
      },
      complete:function(data){
        timer =  setTimeout(get_weekMatches_withMO,300000);
        //timer =  setTimeout(table.reload,3000);
       }
  });
//}
$('#talbe_MO_div').css("display", "block");
$('#talbe_AH_div').css("display", "none");
$('#talbe_OU_div').css("display", "none");
}
function get_weekMatches_withOU()
{
    clearTimeout(timer);
    if(!$('#WeekMatchTable_OU tbody tr').length){
    $("#loader").fadeIn("fast");
    $.ajax({
        url: "showMatchsOfThisWeek_OU",
        type : 'GET',
        
        dataType: 'json',
        success:function(response)
        {                     
          console.log(response);
          len = response['tbody'].length;
          $("#loader").fadeOut("fast");
            
            if(len == 0)
            {
                $('#tbody_OU').append("<tr><td  colspan = '13'>No availabe data now!</td></tr>");
            }
            else
            {
                len = response['tbody'].length;
                matches_object = response['tbody'];
                var str_tr = "";
                
                for(var i = 0; i< len; i++)
                {
                  
                  
                  str_tr += "<tr>" +
                    
                    "<td align='center'>" + matches_object[i].League + "</td>" +
                    "<td align='center'>" + matches_object[i].Season + "</td>" +
                    "<td align='center'>" + matches_object[i].Date + "</td>" +
                    
                    "<td align='center'>" + matches_object[i].WN + "</td>" +
                    "<td align='center'>" + matches_object[i].Game + "</td>" +
                    "<td align='center'>" + matches_object[i].Score + "</td>" +
                    "<td align='center'>" + matches_object[i].Result + "</td>" +
                    "<td align='center'>" + matches_object[i].Home_team_name + "</td>" +

                    "<td align='center'>" + matches_object[i].Away_team_name + "</td>" +

                    "<td align='center'>" + matches_object[i].staticRank + "</td>" +
                    "<td align='center'>" + matches_object[i].Dynamic_HRank_6 + " v " + matches_object[i].Dynamic_ARank_6 + "</td>" +
                    "<td align='center'>" +  matches_object[i].Dynamic_HRank_8 + " v " + matches_object[i].Dynamic_ARank_8 + "</td>" +

                    "<td align='center'>" +  matches_object[i]. highest_Over +  "</td>" +
                    "<td align='center'>" +  matches_object[i]. highest_Under + "</td>" +

                    "<td align='center'>" +  "" + "</td>" +
                    "<td align='center'>" +  "" + "</td>" +

                    "<td align='center'>" +  "" + "</td>" +
                    "<td align='center'>" +  "" + "</td>" +
                    
                    "</tr>";
                }
                $('#tbody_OU').append(str_tr);
                $('#WeekMatchTable_OU').dataTable({
                  lengthMenu: [[25,50, 100, -1], [25,50, 100, "All"]],
                  pageLength: 25 ,
                });
                
            }
          
          
          var buttons = new $.fn.dataTable.Buttons("#WeekMatchTable_OU", {
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
              } ]

              }).container().appendTo($('#pre_cont_OU'));
                          
        },
        error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
            console.log(JSON.stringify(jqXHR));
            
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    });
  }
  $('#talbe_MO_div').css("display", "none");
  $('#talbe_OU_div').css("display", "block");
  $('#talbe_AH_div').css("display", "none");
}

function get_weekMatches_withAH()
{
  clearTimeout(timer);
  if(!$('#WeekMatchTable_AH tbody tr').length)
  {
  $("#loader").fadeIn("fast");
  $.ajax({
    url: "showMatchsOfThisWeek_AH",
    type : 'GET',
    
    dataType: 'json',
    success:function(response)
    {                     
      console.log(response);
      len = response['tbody'].length;
      $("#loader").fadeOut("fast");
        
        if(len == 0)
        {
            $('#tbody_AH').append("<tr><td  colspan = '24'>No availabe data now!</td></tr>");
        }
        else
        {
            len = response['tbody'].length;
            matches_object = response['tbody'];
            var str_tr = "";
            for(var i = 0; i< len; i++)
            {
              str_tr += "<tr>" +
                
                "<td align='center'>" + matches_object[i].League + "</td>" +
                "<td align='center'>" + matches_object[i].Season + "</td>" +
                "<td align='center'>" + matches_object[i].Date + "</td>" +
                "<td align='center'>" + matches_object[i].WN + "</td>" +
                "<td align='center'>" + matches_object[i].Game + "</td>" +
                "<td align='center'>" + matches_object[i].Score + "</td>" +
                "<td align='center'>" + matches_object[i].Result + "</td>" +
                "<td align='center'>" + matches_object[i].Home_team_name + "</td>" +
            
                "<td align='center'>" + matches_object[i].Static_HRank + "</td>" +
              
                "<td align='center'>" + matches_object[i].Dynamic_HRank_6 + "</td>" +
                
                "<td align='center'>" + matches_object[i].Dynamic_HRank_8 + "</td>" +
      
                "<td align='center'>" + matches_object[i].Away_team_name + "</td>" +
                
                "<td align='center'>" + matches_object[i].Static_ARank + "</td>" +
            
                "<td align='center'>" + matches_object[i].Dynamic_ARank_6 + "</td>" +
          
                "<td align='center'>" + matches_object[i].Dynamic_ARank_8 + "</td>" +
        
                "<td align='center'>" + matches_object[i].staticRank + "</td>" +
                "<td align='center'>" + matches_object[i].Dynamic_HRank_6 + " v " + matches_object[i].Dynamic_ARank_6 + "</td>" +
                "<td align='center'>" +  matches_object[i].Dynamic_HRank_8 + " v " + matches_object[i].Dynamic_ARank_8 + "</td>" +

                "<td align='center'>" +  matches_object[i].AH2_1 +  "</td>" +
                "<td align='center'>" +  matches_object[i].AH2_2 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH1d75_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH1d75_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH1d5_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH1d5_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH1d25_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH1d25_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH1_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH1_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH0d75_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH0d75_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH0d5_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH0d5_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH0d25_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH0d25_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH0_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH0_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p0d25_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p0d25_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p0d5_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p0d5_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p0d75_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p0d75_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p1_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p1_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p1d25_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p1d25_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p1d5_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p1d5_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p1d75_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p1d75_2 +  "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p2_1 + "</td>" +
                "<td align='center'>" +  matches_object[i]. AH_p2_2 +  "</td>" +
                "</tr>";
            }
            $('#tbody_AH').append(str_tr);
            $('#WeekMatchTable_AH').dataTable({
              lengthMenu: [[25,50, 100, -1], [25,50, 100, "All"]],
              pageLength: 25 ,
      });
            
        }
      
      
      var buttons = new $.fn.dataTable.Buttons("#WeekMatchTable_AH", {
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
          } ]

          }).container().appendTo($('#pre_cont_AH'));
                      
    },
    error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        console.log(JSON.stringify(jqXHR));
        
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
});
}
$('#talbe_MO_div').css("display", "none");
$('#talbe_OU_div').css("display", "none");
$('#talbe_AH_div').css("display", "block");
}
            