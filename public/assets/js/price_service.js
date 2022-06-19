var week_number = 0, market_type ="";

$(document).ready(function()
{
   
    $("#markets").select2();
    setTimeout(function()
    {    
        $("#history_loader").fadeOut("slow");
    }, 100);

});

function weekChangeFunction(obj)
{
  
    week_number = obj.value;
    
    if (week_number > 0 & market_type != "") {
        if (market_type == "M")
            show_MO_Price();
        else
            show_AH_price()
    }

}

function MarketTypeChangeFunction(obj)
{
    market_type = obj.value;
    if (week_number > 0 & market_type != "") {
        
        if (market_type == "M")
            show_MO_Price();
        else
            show_AH_price()
      }
}

function show_MO_Price()
{
    console.log(week_number, market_type)
    $("#loader").fadeIn("slow");
    $("#talbe_MO_div").css("display", "block");
    $("#talbe_AH_div").css("display", "none");

    $('#table_mo_price').DataTable({
        processing: false,
        lengthMenu: [[100 ,200 -1], [ 100,200 , "All"]],
        pageLength: 100,
        destroy: true,
        serverSide: true,
        
        ajax: {
          url: "show_MO_price",
          type: 'POST',
          data:
          {
            _token : $('meta[name="csrf-token"]').attr('content'),
            week_number : week_number,
            market_type : market_type,
            
          }
          
          },
          columns: [
                
                { data: 'refer',  name: 'refer', },
                { data: 'c_week_number', name: 'c_week_number'} ,
                { data: 'H', name: 'H'},
                { data: 'D', name: 'D'},
                { data: 'A', name: 'A'},
                { data: 'total', name: 'total'},
                { data: 'H_pro', name: 'H_pro'},
                { data: 'D_pro', name: 'D_pro'},
                { data: 'A_pro', name: 'A_pro'},
                {data: 'H_price', name: 'H_price'},
                { data: 'D_price', name: 'D_price'},
                { data: 'A_price', name: 'A_price'},
                

           
          ],
          createdRow: function ( row, data, index ) 
          {  
            
            $('td', row).eq(1).addClass('table-success');
            $('td', row).eq(2).addClass('table-success');
            $('td', row).eq(3).addClass('table-success');
            $('td', row).eq(4).addClass('table-success');

            $('td', row).eq(6).addClass('table-info');
            $('td', row).eq(7).addClass('table-info');
            $('td', row).eq(8).addClass('table-info');  

            $('td', row).eq(5).addClass('table-danger');
            // $('td', row).eq(21).addClass('table-danger');
            // $('td', row).eq(22).addClass('table-danger');

            $('td', row).eq(9).addClass('table-warning');
            $('td', row).eq(10).addClass('table-warning');
            $('td', row).eq(11).addClass('table-warning');

            // $('td', row).eq(26).addClass('table-primary');
            // $('td', row).eq(27).addClass('table-primary');
            // $('td', row).eq(28).addClass('table-primary');
            
        }

      }
      );
      $("#loader").fadeOut("slow");
      var buttons = new $.fn.dataTable.Buttons("#table_mo_price", {
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
               
              
            }
       }

        
      ]

    }).container().appendTo($('#pre_table_MO'));    

}

function show_AH_price()
{
    console.log(week_number, market_type)
    // $("#loader").fadeIn("slow");
    $("#talbe_AH_div").css("display", "block");
    $("#talbe_MO_div").css("display", "none");

    $('#table_ah_price').DataTable({
        processing: false,
        lengthMenu: [[100 ,200 -1], [ 100,200 , "All"]],
        pageLength: 100,
        destroy: true,
        serverSide: true,
        
        ajax: {
          url: "show_AH_price",
          type: 'POST',
          data:
          {
            _token : $('meta[name="csrf-token"]').attr('content'),
            week_number : week_number,
            market_type : market_type,
            
          }
          
          },
          columns: [
                
                { data: 'refer',  name: 'refer', },
                { data: 'c_week_number', name: 'c_week_number'} ,
                { data: 'win', name: 'win'},
                { data: 'lose', name: 'lose'},
                { data: 'flat', name: 'flat'},
                { data: 'half_win', name: 'half_win'},
                { data: 'half_lose', name: 'half_lose'},
                { data: 'total_win', name: 'total_win'},
                { data: 'total_lose', name: 'total_lose'},
                { data: 'grand_total', name: 'grand_total'},
                { data: 'home_prob', name: 'home_prob'},
                { data: 'home_price', name: 'home_price'},
                { data: 'away_prob', name: 'away_prob'},
                { data: 'away_price', name: 'away_price'},
                

           
          ],
          createdRow: function ( row, data, index ) 
          {  
            
            $('td', row).eq(1).addClass('table-success');
            $('td', row).eq(2).addClass('table-success');
            $('td', row).eq(3).addClass('table-success');
            $('td', row).eq(4).addClass('table-success');

            
            $('td', row).eq(7).addClass('table-info');
            $('td', row).eq(8).addClass('table-info');  
            $('td', row).eq(9).addClass('table-info');

            $('td', row).eq(5).addClass('table-danger');
            $('td', row).eq(6).addClass('table-danger');
            // $('td', row).eq(21).addClass('table-danger');
            // $('td', row).eq(22).addClass('table-danger');

           
            $('td', row).eq(10).addClass('table-warning');
            $('td', row).eq(11).addClass('table-warning');
            $('td', row).eq(12).addClass('table-warning');
            $('td', row).eq(13).addClass('table-warning');
            // $('td', row).eq(26).addClass('table-primary');
            // $('td', row).eq(27).addClass('table-primary');
            // $('td', row).eq(28).addClass('table-primary');
            
        }

      }
      );
      $("#loader").fadeOut("slow");
      var buttons = new $.fn.dataTable.Buttons("#table_ah_price", {
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
               
              
            }
       }

        
      ]

    }).container().appendTo($('#pre_table_AH'));   
}

