
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Generate Proforma Invoice</title>
  <?= $this->include('include/links.php');?>
  <style>
    [class^='select2'] {
      border-radius: 0px !important;
      line-height: 25px !important;
    }

    .form-horizontal .has-feedback .form-control-feedback {
        right: 67px;
    }
    
    body {
      font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
    }
    
    .btn{
      display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
    }

    .form-control{
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 0px;
    }

    .has-error .select2-selection {
        border: 1px solid rgb(185, 74, 72) !important;
    }

    input.error{
     border: 1px solid #f00;
    }
      
    .has-error .select2-selection {
        border-color: rgb(185, 74, 72) !important;
        min-width: 100%;
        max-width: 100%;
    }

    .error{
     border: 1px solid #f00 !important;
    }
    
    .input-group-addon {
      padding:11px 24px 6px 11px;
    }

    select {
      position: relative;
      z-index: 1;
    }

    .parent-container {
      overflow: visible !important;
    }
    
    .dropdown-menu{
      margin-top:10px;
      padding: 10px;
      font-size:15px;
    }

    .bank-form, .item-form {
      background: #f9f9f9;
      padding: 15px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .bank-form h4, .item-form h4 {
      margin-top: 0;
      color: #333;
    }

    #bankDetailsForm, #itemDetailsForm {
      display: none;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="loader"></div>
<div class="wrapper">

<?= $this->include('include/header.php');?>
<?= $this->include('include/sidebar.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Proforma Invoice Details
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Generate Proforma Invoice</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Generate Proforma Invoice</h3>
            </div>
            <br>
            
            <p align="center" style="color:#F00;" id="main-error-message"></p>

            <form class="form-horizontal style-form form" name="proformaForm" id="proformaForm" method="post" action="<?= base_url();?>/proinv/insert" enctype="multipart/form-data">
                         
              <div class="box-body">
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">Invoice ID</label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="invid" id="invid" value="<?= esc($invoice_id); ?>" readonly>
                    <div id="invid_error" style="color: red;"></div>
                  </div>
                  
                  <label class="col-sm-2 control-label">Client Name <span style="color: red;">*</span></label>
                  <div class="col-sm-4">
                    <select name="supplier" id="supplier" class="form-control select2" onchange="showCustomer(this.value)" style="height:40px !important;width: 80%;border-radius:0px;">
                      <option value="">Select Client</option>
                    </select>
                    <div id="supplier_error" style="color: red; width: 80%"></div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Invoice Date</label>
                  <div class="col-sm-3">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="datepicker" class="form-control pull-right" id="datepicker" value="<?php echo date('d-m-Y'); ?>">
                    </div>
                    <div id="date_error" style="color: red;"></div>
                  </div>

                  <label class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-4">
                   <textarea class="form-control" rows="3" id="c_add" name="c_add" placeholder="Client address will appear here automatically"></textarea>
                  </div>
                </div>

                <br>
                <!-- Items Table -->
                <div class="form-group col-sm-12 col-md-12" style="margin-left: 3px;">
                  <table class="table table-bordered" id="item_table">
                    <tr>
                      <th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
                      <th width="8%">Item No</th>
                      <th width="25%">Item Name <span style="color: red;">*</span></th>
                      <th width="20%">Description Name</th>
                      <th width="10%">HSN <span style="color: red;">*</span></th> 
                      <th width="5%">Qty <span style="color: red;">*</span></th>
                      <th width="8%">Unit</th>
                      <th width="12%">Price <span style="color: red;">*</span></th>                
                      <th width="10%">Total <span style="color: red;">*</span></th>
                      <th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></button></th>
                    </tr>
                    <tr class="datarow">
                      <td><input class="itemRow" type="checkbox"></td>
                      <td><input type="text" name="item_code[]" id="productCode_1" value="1" class="form-control" autocomplete="off"></td>
                      <td>
                        <select name="item_name[]" id="productName_1" class="form-control item_name" style="width: 100% !important;" onchange="showHsn(1,this.value)">
                          <option value="">Select Item</option>
                        </select>
                        <button type="button" class="btn btn-info btn-sm add-new-item" style="margin-top: 5px; width: 100%;">
                          <i class="fa fa-plus"></i> Add New Item
                        </button>
                      </td>
                      <td><input type="text" name="item_desc[]" id="productDesc_1" class="form-control item_desc"></td>
                      <td><input type="text" name="hsn[]" id="hsn_1" value="8443" class="form-control item_hsn"></td>
                      <td><input type="number" name="item_quantity[]" id="quantity_1" min="1" value="1" class="form-control quantity"></td>
                      <td><input type="text" name="unit[]" id="unit_1" value="Kgs" class="form-control unit" placeholder="Kgs, Pcs, Days, etc."></td>
                      <td><input type="number" name="price[]" id="price_1" class="form-control price" step="0.01" autocomplete="off"></td>
                      <td><input type="number" name="total[]" id="total_1" class="form-control total" step="0.01" readonly></td>
                      <td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>
                    </tr>
                  </table>
                </div>

                <!-- New Item Form (Hidden by default) -->
                <div id="itemDetailsForm" class="item-form">
                  <h4>Add New Item</h4>
                  <div class="form-group">
                    <label>Item Name <span style="color: red;">*</span></label>
                    <input type="text" name="new_item_name" id="new_item_name" class="form-control" placeholder="Enter item name">
                  </div>
                  <div class="form-group">
                    <label>HSN Code <span style="color: red;">*</span></label>
                    <input type="text" name="new_item_hsn" id="new_item_hsn" class="form-control" placeholder="Enter HSN code">
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="new_item_desc" id="new_item_desc" class="form-control" placeholder="Enter item description">
                  </div>
                  <div class="form-group">
                    <button type="button" id="saveItemDetails" class="btn btn-primary">Save Item</button>
                    <button type="button" id="cancelItemForm" class="btn btn-default">Cancel</button>
                  </div>
                </div>
                
                <br><br><br>

                <div class="row"> 
                  <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8" style="padding-left: 50px;padding-right: 100px;">
                    <h3>Notes:</h3>
                    <div class="form-group">
                      <textarea class="form-control txt" rows="7" cols="8" name="notes" id="notes" placeholder="Your Notes"></textarea>
                    </div>
                    <br>

                    <div class="form-group">
                      <input type="submit" name="submit" id="submitbtn" value="Save Invoice" 
                      style="width: 15em; height: 3em; font-size:20px;" class="btn btn-success submit_btn invoice-save-btm">           
                    </div>
                  </div>

                  <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4" style="padding-left:50px;">
                    
                    <div class="form-group">
                      <label>Subtotal <span style="color: red;">*</span> &nbsp;</label> 
                      <div class="input-group col-sm-10">
                        <div class="input-group-addon"><i class="fa fa-fw fa-inr"></i></div>
                        <input value="" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal" readonly>
                      </div>
                    </div> 
                    
                    <div class="form-group">
                      <label>Tax Rate <span style="color: red;">*</span> &nbsp;</label>
                      <div class="input-group col-sm-10">
                        <input value="18" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate" step="0.01">
                        <div class="input-group-addon">%</div>
                      </div>
                      <div id="taxrate_error" style="color: red; width: 83%"></div>
                    </div>

                    <div class="form-group">
                      <label>Tax Amount <span style="color: red;">*</span> &nbsp;</label>
                      <div class="input-group col-sm-10">
                        <div class="input-group-addon currency"><i class="fa fa-fw fa-inr"></i></div>
                        <input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount" readonly>
                      </div>
                    </div>              
                    
                    <div class="form-group">
                      <label>Total <span style="color: red;">*</span> &nbsp;</label>
                      <div class="input-group col-sm-10">
                        <div class="input-group-addon currency"><i class="fa fa-fw fa-inr"></i></div>
                        <input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total" readonly>
                      </div>
                    </div>

                    <!-- Bank Selection -->
                    <div class="form-group">
                      <label>Select Bank <span style="color: red;">*</span> &nbsp;</label>
                      <div class="col-sm-10">
                        <select name="bank_id" id="bank_id" class="form-control select2" style="width: 100%;">
                          <option value="">Select Bank</option>
                          <?php if(isset($banks) && !empty($banks)): ?>
                            <?php foreach ($banks as $bank): ?>
                              <option value="<?= $bank['bid'] ?>"><?= $bank['bname'] ?> - <?= $bank['ac'] ?></option>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </select>
                        <button type="button" id="addNewBank" class="btn btn-info btn-sm" style="margin-top: 5px;">
                          <i class="fa fa-plus"></i> Add New Bank
                        </button>
                        <div id="bank_error" style="color: red;"></div>
                      </div>
                    </div>

                    <!-- New Bank Form (Hidden by default) -->
                    <div id="bankDetailsForm" class="bank-form">
                      <h4>Add New Bank Details</h4>
                      <div class="form-group">
                        <label>Bank Name <span style="color: red;">*</span></label>
                        <input type="text" name="new_bank_name" id="new_bank_name" class="form-control" placeholder="Enter bank name">
                      </div>
                      <div class="form-group">
                        <label>Account Number <span style="color: red;">*</span></label>
                        <input type="text" name="new_account_number" id="new_account_number" class="form-control" placeholder="Enter account number">
                      </div>
                      <div class="form-group">
                        <label>Bank Code/Swift Code <span style="color: red;">*</span></label>
                        <input type="text" name="new_bank_code" id="new_bank_code" class="form-control" placeholder="Enter bank code">
                      </div>
                      <div class="form-group">
                        <label>Account Name <span style="color: red;">*</span></label>
                        <input type="text" name="new_account_name" id="new_account_name" class="form-control" placeholder="Enter account name">
                      </div>
                      <div class="form-group">
                        <button type="button" id="saveBankDetails" class="btn btn-primary">Save Bank</button>
                        <button type="button" id="cancelBankForm" class="btn btn-default">Cancel</button>
                      </div>
                    </div>

                    <!-- Signature Upload -->
                    <div class="form-group">
                      <label>Upload Signature &nbsp;</label>
                      <div class="col-sm-10">
                        <input type="file" name="signature" id="signature" class="form-control" accept="image/*">
                        <small class="help-block">Upload your signature image (JPG, PNG)</small>
                        <div id="signature_error" style="color: red;"></div>
                      </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="form-group">
                      <label>Validity Period (Days) &nbsp;</label>
                      <div class="input-group col-sm-10">
                        <input value="90" type="number" class="form-control" name="validity_period" id="validity_period" placeholder="90">
                        <div class="input-group-addon">Days</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Delivery Period (Days) &nbsp;</label>
                      <div class="input-group col-sm-10">
                        <input value="4" type="number" class="form-control" name="delivery_period" id="delivery_period" placeholder="4">
                        <div class="input-group-addon">Days</div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Payment Terms &nbsp;</label>
                      <div class="col-sm-10">
                        <input value="Payment must be within 30 working days after delivery" type="text" class="form-control" name="payment_terms" id="payment_terms" placeholder="Payment terms">
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
 
  <?= $this->include('include/settings.php');?>
  <?= $this->include('include/footer.php');?>
 
<script type="text/javascript">
    var base_url = "<?= base_url(); ?>";
</script>

<script type="text/javascript">
$(document).ready(function() {
    var rowCount = 1;
    var currentItemRow = null;
    
    // Initialize select2 for clients
    $('#supplier').select2({
        placeholder: "Select Client",
        ajax: {
            url: base_url + '/proinv/getclient',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    category_name: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
    
    // Initialize select2 for products
    function initializeProductSelect(selector) {
        $(selector).select2({
            placeholder: "Select Item",
            allowClear: true,
            ajax: {
                url: base_url + '/proinv/getproducts',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        category_name: params.term
                    };
                },
                processResults: function (data) {
                    console.log('Product data received:', data);
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    }
    
    // Initialize first row select
    initializeProductSelect('#productName_1');
    
    // Initialize datepicker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    
    // Bank form toggle
    $('#addNewBank').click(function() {
        $('#bankDetailsForm').slideDown();
        $('#bank_id').prop('disabled', true);
    });
    
    $('#cancelBankForm').click(function() {
        $('#bankDetailsForm').slideUp();
        $('#bank_id').prop('disabled', false);
        clearBankForm();
    });
    
    // Item form toggle
    $(document).on('click', '.add-new-item', function() {
        currentItemRow = $(this).closest('tr');
        $('#itemDetailsForm').slideDown();
    });
    
    $('#cancelItemForm').click(function() {
        $('#itemDetailsForm').slideUp();
        currentItemRow = null;
        clearItemForm();
    });
    
    // Save new item
    $('#saveItemDetails').click(function() {
        var itemName = $('#new_item_name').val();
        var itemHsn = $('#new_item_hsn').val();
        var itemDesc = $('#new_item_desc').val();
        
        if (!itemName || !itemHsn) {
            alert('Please fill item name and HSN code');
            return;
        }
        
        $.ajax({
            url: base_url + '/proinv/saveitem',
            method: 'POST',
            dataType: 'json',
            data: {
                item_name: itemName,
                hsn: itemHsn,
                description: itemDesc
            },
            success: function(response) {
                console.log('Save item response:', response);
                if (response.success) {
                    if (currentItemRow) {
                        // Add new option to current row's select - use itemName as both value and text
                        var selectElement = currentItemRow.find('.item_name');
                        var newOption = new Option(itemName, itemName, true, true);
                        selectElement.append(newOption).trigger('change');
                        
                        // Update HSN field
                        currentItemRow.find('.item_hsn').val(itemHsn);
                        
                        // Update description field
                        currentItemRow.find('.item_desc').val(itemDesc);
                    }
                    
                    $('#itemDetailsForm').slideUp();
                    currentItemRow = null;
                    clearItemForm();
                    alert('Item saved successfully');
                } else {
                    alert('Failed to save item: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                alert('Error saving item: ' + error);
            }
        });
    });
    
    // Save new bank
    $('#saveBankDetails').click(function() {
        var bankName = $('#new_bank_name').val();
        var accountNumber = $('#new_account_number').val();
        var bankCode = $('#new_bank_code').val();
        var accountName = $('#new_account_name').val();
        
        if (!bankName || !accountNumber || !bankCode || !accountName) {
            alert('Please fill all bank details');
            return;
        }
        
        $.ajax({
            url: base_url + '/proinv/savebank',
            method: 'POST',
            data: {
                bname: bankName,
                ac: accountNumber,
                ifsc: bankCode,
                account_name: accountName
            },
            success: function(response) {
                if (response.success) {
                    // Add new option to select
                    var newOption = new Option(bankName + ' - ' + accountNumber, response.bank_id, true, true);
                    $('#bank_id').append(newOption).trigger('change');
                    
                    $('#bankDetailsForm').slideUp();
                    $('#bank_id').prop('disabled', false);
                    clearBankForm();
                    alert('Bank details saved successfully');
                } else {
                    alert('Failed to save bank details');
                }
            }
        });
    });
    
    function clearBankForm() {
        $('#new_bank_name, #new_account_number, #new_bank_code, #new_account_name').val('');
    }
    
    function clearItemForm() {
        $('#new_item_name, #new_item_hsn, #new_item_desc').val('');
    }
    
    // Add new item row
    $(document).on('click', '.add', function() {
        rowCount++;
        var html = '<tr class="datarow">';
        html += '<td><input class="itemRow" type="checkbox"></td>';
        html += '<td><input type="text" name="item_code[]" id="productCode_' + rowCount + '" value="' + rowCount + '" class="form-control" autocomplete="off"></td>';
        html += '<td><select name="item_name[]" id="productName_' + rowCount + '" class="form-control item_name" style="width: 100% !important;" onchange="showHsn(' + rowCount + ',this.value)"><option value="">Select Item</option></select>';
        html += '<button type="button" class="btn btn-info btn-sm add-new-item" style="margin-top: 5px; width: 100%;"><i class="fa fa-plus"></i> Add New Item</button></td>';
        html += '<td><input type="text" name="item_desc[]" id="productDesc_' + rowCount + '" class="form-control item_desc"></td>';
        html += '<td><input type="text" name="hsn[]" id="hsn_' + rowCount + '" value="8443" class="form-control item_hsn"></td>';
        html += '<td><input type="number" name="item_quantity[]" id="quantity_' + rowCount + '" min="1" value="1" class="form-control quantity"></td>';
        html += '<td><input type="text" name="unit[]" id="unit_' + rowCount + '" value="Kgs" class="form-control unit"></td>';
        html += '<td><input type="number" name="price[]" id="price_' + rowCount + '" class="form-control price" step="0.01"></td>';
        html += '<td><input type="number" name="total[]" id="total_' + rowCount + '" class="form-control total" step="0.01" readonly></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>';
        html += '</tr>';
        
        $('#item_table').append(html);
        
        // Initialize select2 for new item dropdown
        initializeProductSelect('#productName_' + rowCount);
    });
    
    // Remove item row
    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        calculateTotals();
    });
    
    // Calculate line total when quantity or price changes
    $(document).on('input', '.quantity, .price', function() {
        var row = $(this).closest('tr');
        var quantity = parseFloat(row.find('.quantity').val()) || 0;
        var price = parseFloat(row.find('.price').val()) || 0;
        var total = quantity * price;
        
        row.find('.total').val(total.toFixed(2));
        calculateTotals();
    });
    
    // Calculate tax when tax rate changes
    $(document).on('input', '#taxRate', function() {
        calculateTotals();
    });
    
    function calculateTotals() {
        var subtotal = 0;
        
        $('.total').each(function() {
            var value = parseFloat($(this).val()) || 0;
            subtotal += value;
        });
        
        $('#subTotal').val(subtotal.toFixed(2));
        
        var taxRate = parseFloat($('#taxRate').val()) || 0;
        var taxAmount = (subtotal * taxRate) / 100;
        $('#taxAmount').val(taxAmount.toFixed(2));
        
        var totalAfterTax = subtotal + taxAmount;
        $('#totalAftertax').val(totalAfterTax.toFixed(2));
    }
    
    // Form submission
    $('#proformaForm').submit(function(e) {
        e.preventDefault();
        
        // Basic validation
        var isValid = true;
        var errorMessages = [];
        
        // Clear previous errors
        $('.error').removeClass('error');
        $('[id$="_error"]').text('');
        
        // Validate client selection
        if (!$('#supplier').val()) {
            $('#supplier').addClass('error');
            $('#supplier_error').text('Please select a client');
            isValid = false;
            errorMessages.push('Client selection is required');
        }
        
        // Validate at least one item
        var hasItems = false;
        $('.item_name').each(function() {
            if ($(this).val()) {
                hasItems = true;
                return false;
            }
        });
        
        if (!hasItems) {
            isValid = false;
            errorMessages.push('At least one item is required');
        }
        
        // Validate item details
        $('.datarow').each(function(index) {
            var row = $(this);
            var itemName = row.find('.item_name').val();
            var quantity = row.find('.quantity').val();
            var price = row.find('.price').val();
            
            if (itemName) {
                if (!quantity || quantity <= 0) {
                    row.find('.quantity').addClass('error');
                    isValid = false;
                }
                if (!price || price <= 0) {
                    row.find('.price').addClass('error');
                    isValid = false;
                }
            }
        });
        
        // Validate bank selection (either existing or new)
        if (!$('#bank_id').val() && !$('#new_bank_name').val()) {
            $('#bank_error').text('Please select a bank or add new bank details');
            isValid = false;
        }
        
        if (!isValid) {
            $('#main-error-message').text('Please correct the errors below and try again.');
            return;
        }
        
        // Show loading state
        $('#submitbtn').prop('disabled', true).val('Saving...');
        
        // Create FormData object to handle file upload
        var formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    alert('Proforma Invoice created successfully!');
                    
                    // Redirect to print page
                    if (response.orderid) {
                        window.open(base_url + '/proinv/printproinv?orderid=' + response.orderid, '_blank');
                    }
                    
                    // Reset form or redirect
                    $('#proformaForm')[0].reset();
                    location.reload();
                } else {
                    alert('Error: ' + (response.message || 'Failed to create invoice'));
                    $('#main-error-message').text(response.message || 'Failed to create invoice');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
                $('#main-error-message').text('An error occurred while saving the invoice');
            },
            complete: function() {
                $('#submitbtn').prop('disabled', false).val('Save Invoice');
            }
        });
    });
});

// Show customer details when client is selected
function showCustomer(clientId) {
    if (clientId) {
        $.ajax({
            url: base_url + '/proinv/getclient',
            data: { client_id: clientId },
            success: function(response) {
                if (response && response.length > 0) {
                    var client = response.find(function(c) { return c.id == clientId; });
                    if (client && client.c_add) {
                        $('#c_add').val(client.c_add);
                    }
                }
            }
        });
    }
}

// Show HSN code when product is selected
function showHsn(rowNumber, productName) {
    if (productName) {
        $.ajax({
            url: base_url + '/proinv/getproducthsn',
            dataType: 'json',
            data: { q: productName },
            success: function(response) {
                console.log('HSN response:', response);
                if (response && response.hsn) {
                    $('#hsn_' + rowNumber).val(response.hsn);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching HSN:', error);
            }
        });
    }
}
</script>

</body>
</html>