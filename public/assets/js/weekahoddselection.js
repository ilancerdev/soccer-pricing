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

                "<td align='center'>" +    "</td>" +
                "<td align='center'>" +    "</td>" +
                "<td align='center'>" +   "</td>" +
                "<td align='center'>" +   "</td>" +
                
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

$('#talbe_AH_div').css("display", "block");
}
            