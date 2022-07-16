var stake_val;
var timer;

// initial column select list for priting excel

var ah_column_select = [  0 , 1, 3 , 18, 19, 20, 21];


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
  get_weekMatches_withAH();
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
  get_weekMatches_withAH()
}

function get_Stake_Pnl(actual_odd, real_odd)
{
   actual_odd = parseFloat(actual_odd)
   real_odd = parseFloat(real_odd)
   percent =  (1 / real_odd)
   
   //percent = percent.toFixed
   stake = ((actual_odd -1) * percent - (1 - percent)) / (actual_odd - 1) * stake_val
   
   
   return stake;
}

function get_edge(actual_odd, real_odd){
  var f_actual_odd = parseFloat(actual_odd)
  var f_real_odd = parseFloat(real_odd)
  return (f_actual_odd - f_real_odd)/(f_real_odd - 1)
}

function get_weekMatches_withAH()
{
  clearTimeout(timer);
  if(!$('#WeekMatchTable_AH tbody tr').length)
  {
  $("#loader").fadeIn("fast");
  $.ajax({
    url: "weekAHBet",
    type : 'GET',
    
    dataType: 'json',
    success:function(response)
    {                     
      console.log(response);
      len = response['tbody'].length;
      $("#loader").fadeOut("fast");
        
        if(len == 0)
        {
            $('#tbody_AH').html("");
            $('#tbody_AH').append("<tr><td  colspan = '24'>No availabe data now!</td></tr>");
            $("#loader").fadeOut("fast");
            alert("No Bet this week.");
        
        }
        else
        {
            len = response['tbody'].length;
            matches_object = response['tbody'];
            var str_tr = "";
            for(var i = 0; i< len; i++)
            {
                var market = "" , bet = "" , stake = "", PnL = ""
                p1_edge = get_edge(matches_object[i].AH_p1_1 , matches_object[i].real_p1_1)
                p1d25_edge = get_edge(matches_object[i].AH_p1d25_1 , matches_object[i].real_p1d25_1)
                p1d5_edge = get_edge(matches_object[i].AH_p1d5_1 , matches_object[i].real_p1d5_1)
                p1d75_edge = get_edge(matches_object[i].AH_p1d75_1 , matches_object[i].real_p1d75_1)
                p2_edge = get_edge(matches_object[i].AH_p2_1 , matches_object[i].real_p2_1)

                list = [p1_edge , p1d25_edge, p1d5_edge, p1d75_edge, p2_edge]

                var max = Math.max(...list)

                switch(max){
                  case p1_edge:
                      market = "+1";
                      bet =  p1_edge > 0 ? "Bet" : 'No Bet'
                      var stake_ = bet == 'Bet' ? get_Stake_Pnl(matches_object[i].AH_p1_1  , matches_object[i].real_p1_1) : '0'
                      stake = stake_.toFixed(2)
                      if (matches_object[i].Result != "-")
                      {
                          result_val = parseFloat(matches_object[i].home_score) - parseFloat(matches_object[i].away_score) + 1
                          var PnL_val = result_val > 0 ? home_Stake * (actual_home_price - 1): (0 - home_Stake)
                          PnL = PnL_val.toFixed(2)

                      }
                      break
                  case p1d25_edge:
                      market = "+1.25";
                      bet =  p1d25_edge > 0 ? "Bet" : 'No Bet'
                      var stake_ = bet == 'Bet' ? get_Stake_Pnl(matches_object[i].AH_p1d25_1  , matches_object[i].real_p1d25_1) : '0'
                      stake = stake_.toFixed(2)
                      if (matches_object[i].Result != "-")
                      {
                          result_val = parseFloat(matches_object[i].home_score) - parseFloat(matches_object[i].away_score) + 1.25
                          var PnL_val = result_val > 0 ? home_Stake * (actual_home_price - 1): (0 - home_Stake)
                          PnL = PnL_val.toFixed(2)

                      }
                      break
                  case p1d5_edge:
                    market = "+1.5";
                    bet =  p1d5_edge > 0 ? "Bet" : 'No Bet'
                    var stake_ = bet == 'Bet' ? get_Stake_Pnl(matches_object[i].AH_p1d5_1  , matches_object[i].real_p1d5_1) : '0'
                    stake = stake_.toFixed(2)
                    if (matches_object[i].Result != "-")
                    {
                        result_val = parseFloat(matches_object[i].home_score) - parseFloat(matches_object[i].away_score) + 1.5
                        var PnL_val = result_val > 0 ? home_Stake * (actual_home_price - 1): (0 - home_Stake)
                        PnL = PnL_val.toFixed(2)

                    }
                    break 
                case p1d75_edge:
                  market = "+1.75";
                  bet =  p1d75_edge > 0 ? "Bet" : 'No Bet'
                  var stake_ = bet == 'Bet' ? get_Stake_Pnl(matches_object[i].AH_p1d75_1  , matches_object[i].real_p1d75_1) : '0'
                  stake = stake_.toFixed(2)
                  if (matches_object[i].Result != "-")
                  {
                      result_val = parseFloat(matches_object[i].home_score) - parseFloat(matches_object[i].away_score) + 1.75
                      var PnL_val = result_val > 0 ? home_Stake * (actual_home_price - 1): (0 - home_Stake)
                      PnL = PnL_val.toFixed(2)

                  }
                  break  
                case p2_edge:
                    market = "+2";
                    bet =  p2_edge > 0 ? "Bet" : 'No Bet'
                    var stake_ = bet == 'Bet' ? get_Stake_Pnl(matches_object[i].AH_p2_1  , matches_object[i].real_p2_1) : '0'
                    stake = stake_.toFixed(2)
                    if (matches_object[i].Result != "-")
                    {
                        result_val = parseFloat(matches_object[i].home_score) - parseFloat(matches_object[i].away_score) + 2
                        var PnL_val = result_val > 0 ? home_Stake * (actual_home_price - 1): (0 - home_Stake)
                        PnL = PnL_val.toFixed(2)

                    }
                    break     

                }
                 

                str_tr += "<tr>" +
                
                "<td align='center'>" + matches_object[i].League + "</td>" +
                "<td align='center'>" + matches_object[i].Season + "</td>" +
                "<td align='center'>" + matches_object[i].Date + "</td>" +
                
                "<td align='center'>" + matches_object[i].WN + "</td>" +
                "<td align='center'>" + matches_object[i].Game + "</td>" +
                "<td align='center'>" + matches_object[i].cream_status + "</td>" +
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

                "<td align='center'>" +   market + "</td>" +
                "<td align='center'>" +   bet + "</td>" +
                "<td align='center'>" +   stake + "</td>" +
                "<td align='center'>" +   PnL + "</td>" +
                
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
    },
    complete:function(data){
      timer =  setTimeout(get_weekMatches_withAH,300000);
      //timer =  setTimeout(table.reload,3000);
     }
});
}

$('#talbe_AH_div').css("display", "block");
}
            