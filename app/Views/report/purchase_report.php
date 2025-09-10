
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EMAX | Data Tables</title>



 <?= $this->include('Include/links.php');?>

 <link rel="stylesheet" href="<?= base_url(); ?>/public/script/daterangepicker/daterangepicker-bs3.css">

 <script type="text/javascript" src="<?= base_url(); ?>/public/script/dataTables.export.js"></script> 

    <script src="<?= base_url(); ?>/public/script/daterangepicker/moment.min.js"></script>
    <script src="<?= base_url(); ?>/public/script/daterangepicker/daterangepicker.js"></script>


<!-- <script type="text/javascript" src="/script/script.js"></script> -->
<style type="text/css">
  .cancelBtn {
      background-color:#dc3545;
  }

  select {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    width: 100%;
    border: 1px solid #ccc;
    height: 34px;
  }
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div id="loader"></div>


<div class="wrapper">

   <?= $this->include('Include/header.php');?>


  <?= $this->include('Include/sidebar.php');?>



  <!-- Content Wrapper. Contains page content -->
  
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Purchase Report
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        
        <li class="active">Purchase Report</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-info" style="overflow: auto;">
            <div class="box-header">
              <form action="" method="GET">
                <!-- Place the filter icon first -->
                <div class="col-md-1">
                    <h3 class="box-title">
                        <i class="fa fa-fw fa-filter fa-3x"></i>
                    </h3>
                </div>
                
                <!-- Select Client -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Select Client:</label>
                        <select name="client" id="client" class="form-control select2" style="height: 35px !important;width:100% !important;">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                
            <!--    <div class="col-md-3">
                  <div class="form-group">
                      <label>Select Type:</label>                    
                      <select name="ctype" id="ctype" class="form-control select234" style="height: 35px !important;width:100% !important;" >
                          <option value=""></option>
                          <option value="1"> Suppliers </option>
                          <option value="2"> Customers</option>
                          <option value="2"> Dual (Cust / Sup)</option>                             
                        </select>       
                  </div>
               </div> 
 -->                
             <div class="col-md-3">
               <div class="form-group">
                  <label>Date range:</label>                    
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                         <input type="text" class="form-control pull-left" id="daterange-btn" name="date_range">
                    </div><!-- /.input group -->                  
               </div><!-- /.form group -->
             </div>
                <!-- Submit Button -->
                <!-- <div class="col-md-2">
                    <div class="form-group">
                        <label></label></br>
                        <input type="submit" class="btn btn-success" name="submit">
                    </div>
                </div> -->
                </form>
            </div>
 
      
            <div class="row">
              <div class="col-md-12">
                <div class="box box-success">
                  <div class="box-header" style="text-align:center">
                  </br>
                      <h3 class="box-title" id="item"></h3>
                      </br>
                      
                      <h4 id="date"> </h4>
                      </br>
                        <div id="hide">
                        <h3 class="box-title" id="company"></h3></br>
                        
                      </div>
                    </div>
                    <h3>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ' '." CodeTech Engineers";?></h3>
               <section class="content">
                  <div class="row">
                 <div class="col-xs-12">
                      <div class="box">
                        <div class="box-body">                                                 
                               <table id="example" class="table table-bordered table-striped">

                                     <thead>
                                        <tr>
                                            <th style="width: 100px;"> Sr no. </th>
                                            <th style="width: 800px;">Inv No</th>
                                            <th style="width: 400px;">Inv Date</th>
                                            <th style="width: 800px;">Client</th>
                                            
                                            
                                            <th style="width: 400px;">Location</th>
                                            <th style="width: 300px;">GST</th>
                                            <th style="width: 100px;">Bill Type</th>

                                            <th style="width: 800px;">Item Name </th>
                                            
                                            <th style="width: 100px;">Subtotal</th>
                                            <th style="width:100px;">Tax %</th>
                                            <th style="width: 200px;">Tax Amt</th>
                                            <th style="width: 300px;">Total Amt</th>
                                        </tr>
                                    </thead>

                                     <tbody>                                                                     
                  
                                     
                                         </tbody>
                                         <tfoot>
                                      <tr>
                                            <td> </td>
                                            <td>&nbsp;</td>
                                            <td><h3>Total </h3></td>
                                            <td></td>
                                            <td>&nbsp;</td>
                                                                              
                                            <td><h3><?php //echo "total_bales";?></h3></td>
                                            <td><h3><?php //echo "total_weight";?></h3></td>
                                            <td>&nbsp;</td>
                                            <td><h3 id="subtotal">0</h3></td>
                                            <td><h3></h3></td>
                                            <td><h3 id="taxamt">0</h3></td>
                                            <td><h3 id="totalamt">0</h3></td>
                                    </tr>
                                        </tfoot>
                                 </table> 
                                 
                             </div>
                         </div>
                          <div  class="btn-group" data-toggle="buttons" role="group">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="0" value="Sr. no.">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="1" value="Inv No.">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="2" value="Inv Date">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="3" value="Client Name">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="4" value="Location">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="5" value="GST">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="6" value="Bill Type">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="7" value="Item Name">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="8" value="Subtotal">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="9" value="Tax %">
                                  <input type="button" class="toggle-vis btn btn-primary" data-column="10" value="Tax Amt">
                                 <input type="button" class="toggle-vis btn btn-primary" data-column="11" value="Total Amt">
                                  </br>

                                </div>  
                         </div>
                       </div>
                    </section>
                </div>
           </div>
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <hr>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    
    <?= $this->include('Include/settings.php');?>

    <?= $this->include('Include/footer.php');?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script>
   
    var base_url = "<?= base_url(); ?>"; // Pass base_url from PHP to JS
</script>

<script>
 
  var globalSubtotalTotal=0;
    function loadInvoices(date = null, client = null) {

        console.log("Loading invoices for page: " + date + client); // Add this line
        $.ajax({
            url: base_url + '/purchaseinv/loadinvoices',
            type: 'GET',
            data: { 
                    date: date,
                    client: client,
                  }, // Send the current page number to the server
            dataType: 'json',
            success: function(response) {

                console.log("res"+response);
                $('#example').DataTable().destroy();
        
        var table = $('#example').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'processing': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'footer': true,
        'data': response.aaData,
        dom: "<'row'<'col-sm-3'l><'col-sm-9'<'pull-center'fB>>>rtip",
        buttons: getExportButtons('#example',[0,1,2,3,4,5,6,7,8,9,10,11]), 
        columns: [
            { 'data': 'id' }, 
            { 'data': 'inv no' },
             {
                'data': 'inv date',
                render: function(data, type, row, meta) {
                    var parts = data.split('-');
                    var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                    return formattedDate;
                }
            },// Add the 'id' column
            { 'data': 'client' },
            { 'data': 'location' },
            { 'data': 'GST' },
            {
                'data': 'c_type',
                render: function(data, type, row, meta) {
                    if (data == "IGST") {
                        return '<span class="label label-success">' + data + '</span>';
                    } else {
                        return '<span class="label label-warning">' + data + '</span>';
                    }
                }
            }, 
            
            { 'data': 'item' },
            { 'data': 'subtotal',
               render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },
        
            { 'data': 'taxrate',
             render: function(data, type, row, meta) {
                    // Check if c_type is IGST
                    if (row.c_type == "IGST") {
                        return (data / 2) + ' - ' + (data / 2) + ' %';
                        //return '9-9 %'; // Set taxrate to 9-9 %
                    } else {
                        return data+'%'; // Set taxrate to 18 %
                    }
                }
             },
            { 'data': 'taxamount',
               render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },
        
            { 'data': 'totalamount',
               render: function(data, type, row, meta) {
               return parseFloat(data).toFixed(2); // returns e.g. "123.00"
              }
            },
        
        ],
        initComplete: function() {
            var btns = $('.dt-button');
            btns.addClass('btn btn-primary btn-sm btn-group');
            btns.removeClass('dt-button');
        },
        lengthMenu: [
            [10, 50, 150, -1],
            [10, 50, 150, "All"]
        ]
    });

 
 document.querySelectorAll('.toggle-vis').forEach((el) => {
    el.addEventListener('click', function (e) {
        e.preventDefault();
 
        let columnIdx = e.target.getAttribute('data-column');
        let column = table.column(columnIdx);
        
        // Toggle the visibility
        column.visible(!column.visible());
    });
});
                

  $('#subtotal').text(response.totalSubtotal + ".00");
  $('#taxamt').text(response.totalTaxAmount + ".00");
  $('#totalamt').text(response.totalAmount + ".00");


                }
              })
             }


 $(document).ready(function() {

let selectedYear = null;
let selectedClient = null;

    $('#client').select2({
    placeholder: "Select a Person or Company",
    allowClear: true,
            ajax: {
            url: base_url + "/purchaseinv/getsupplier", // Controller method
            type: "GET",
            dataType: "json",
             delay: 250, // Add a delay to limit requests for better performance
            data: function(params) {
            // Send the current input value to the server as 'category_name'
            return {
                category_name: params.term || '' // params.term is the search term
            };
        },
        processResults: function(data) {
            console.log(data); // For debugging, remove this after testing
            return {
                results: data
            };
        },
        cache: true
    }
});



  $('#ctype').select2({
    placeholder: "Select User Type",
    allowClear: true,

});


    


$('#daterange-btn').on('apply.daterangepicker', function(ev, picker) {
    selectedYear = picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD');
    loadInvoices(selectedYear, selectedClient);
});


  $('#client').on('select2:select', function() {
        selectedClient = $(this).val();
        loadInvoices(null, selectedClient);
    });

    // $('#client').on('select2:unselect', function() {
    //     selectedClient = null;
    //     loadInvoices(selectedYear, selectedClient);
    // });
    var table = $('#example').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'processing': true,
        'ordering': true,
        'info': true,
        'autoWidth': false,
        'footer': true,
        dom: "<'row'<'col-sm-3'l><'col-sm-9'<'pull-center'fB>>>rtip",
        buttons: getExportButtons('#example',[0,1,2,3,4,5,6,7,8,9,10,11]), 
        columns: [
            { 'data': 'id' }, 
            { 'data': 'inv no' },
             {
                'data': 'inv date',
                render: function(data, type, row, meta) {
                    var parts = data.split('-');
                    var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                    return formattedDate;
                }
            },// Add the 'id' column
            { 'data': 'client' },
            
            
             // Corrected the order based on your PHP code
           
            
            { 'data': 'location' },
            { 'data': 'GST' },
            {
                'data': 'c_type',
                render: function(data, type, row, meta) {
                    if (data == "IGST") {
                        return '<span class="label label-success">' + data + '</span>';
                    } else {
                        return '<span class="label label-warning">' + data + '</span>';
                    }
                }
            }, // Corrected the order based on your PHP code
            
            
             // Corrected the order based on your PHP code
            
            { 'data': 'item' },
            { 'data': 'subtotal' },
            { 'data': 'taxrate',
             render: function(data, type, row, meta) {
        // Check if c_type is IGST
        if (row.c_type == "IGST") {
            return '18 %'; // Set taxrate to 9-9 %
        } else {
            return '9-9 %'; // Set taxrate to 18 %
        }
    }
             },
            { 'data': 'taxamount' },
            { 'data': 'totalamount' }
        ],
        initComplete: function() {
            var btns = $('.dt-button');
            btns.addClass('btn btn-primary btn-sm btn-group');
            btns.removeClass('dt-button');
        },
        lengthMenu: [
            [10, 50, 150, -1],
            [10, 50, 150, "All"]
        ]
    });

 
 document.querySelectorAll('.toggle-vis').forEach((el) => {
    el.addEventListener('click', function (e) {
        e.preventDefault();
 
        let columnIdx = e.target.getAttribute('data-column');
        let column = table.column(columnIdx);
        
        // Toggle the visibility
        column.visible(!column.visible());
    });
});

 $('#daterange-btn').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Last Financial Year': getLastFinancialYearRange(),
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),

    });

    function getLastFinancialYearRange() {
    var today = moment();
    var lastFyStart, lastFyEnd;

    // Assuming financial year is from April 1st to March 31st
    if (today.month() < 3) { // January to March
        // Last financial year was the previous calendar year
        lastFyStart = moment().subtract(1, 'years').month(3).startOf('month'); // April 1st of previous year
        lastFyEnd = moment().subtract(1, 'years').month(2).endOf('month'); // March 31st of current year
    } else {
        // Last financial year was within this calendar year
        lastFyStart = moment().subtract(1, 'years').month(3).startOf('month'); // April 1st of previous year
        lastFyEnd = moment().month(2).endOf('month'); // March 31st of this year
    }

    return [lastFyStart, lastFyEnd];
}
 

});

</script>
<script type="text/javascript">
  $('.btn-primary').on("click",function(){

        //$(".btn-primary").not(this).removeClass('active');
        if($(this).hasClass('active')){
            //$('.Resume-click-open').css({'height' : '100px'});
            $(this).removeClass('active');
            $(this).removeClass('btn-danger');
            //$(this).addClass("btn-primary");
        }else{
            $(this).addClass('active');
            $(this).addClass("btn-danger");
        }


    //$(".btn-success").removeClass('btn-danger');
    
});

</script>
 <script type="text/javascript" src="<?= base_url(); ?>/public/jslogic/getExportButtons.js"></script>
</body>
</html>
