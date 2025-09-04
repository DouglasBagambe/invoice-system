<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Generate Proforma Invoice</title>
  <?= $this->include('Include/links.php');?>
  <style>
    [class^='select2'] { border-radius: 0px !important; line-height: 25px !important; }
    .form-horizontal .has-feedback .form-control-feedback { right: 67px; }
    body { font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px; font-weight: 400; line-height: 1.42857143; }
    .btn { display: inline-block; padding: 6px 12px; margin-bottom: 0; font-size: 14px; font-weight: 400; line-height: 1.42857143; text-align: center; white-space: nowrap; vertical-align: middle; }
    .form-control { display: block; width: 100%; height: 34px; padding: 6px 12px; font-size: 14px; line-height: 1.42857143; color: #555; background-color: #fff; background-image: none; border: 1px solid #ccc; border-radius: 0px; }
    .has-error .select2-selection { border: 1px solid rgb(185, 74, 72) !important; }
    input.error { border: 1px solid #f00; }
    .error { border: 1px solid #f00 !important; }
    .input-group-addon { padding: 11px 24px 6px 11px; }
    select { position: relative; z-index: 1; }
    .dropdown-menu { margin-top: 10px; padding: 10px; font-size: 15px; }
    
    /* Improved table styling */
    #item_table { border-collapse: separate; border-spacing: 0; margin: 20px 0; }
    #item_table th, #item_table td { 
      padding: 8px 6px; 
      border: 1px solid #ddd; 
      vertical-align: middle;
      text-align: center;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    #item_table th { 
      background: #f5f5f5; 
      font-weight: bold; 
      border-bottom: 2px solid #ddd;
      font-size: 12px;
      line-height: 1.2;
    }
    #item_table input, #item_table select { 
      width: 100%; 
      height: 28px; 
      padding: 2px 4px; 
      font-size: 12px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    #item_table input[type="number"] { text-align: right; }
    #item_table .btn-sm { padding: 2px 6px; font-size: 11px; }
    
    /* Column widths */
    .col-check { width: 40px; }
    .col-item-no { width: 60px; }
    .col-item-name { width: 180px; }
    .col-desc { width: 120px; }
    .col-qty { width: 50px; }
    .col-unit { width: 60px; }
    .col-price { width: 80px; }
    .col-vat { width: 60px; }
    .col-vat-type { width: 80px; }
    .col-vat-status { width: 80px; }
    .col-total { width: 80px; }
    .col-action { width: 50px; }
    
    .bank-form, .item-form { 
      background: #ffffff; 
      padding: 25px; 
      margin: 20px 0; 
      border: 2px solid #007bff; 
      border-radius: 8px; 
      display: none;
      box-shadow: 0 8px 16px rgba(0,123,255,0.15);
      position: relative;
      z-index: 1050;
      animation: slideDown 0.3s ease-out;
    }
    .bank-form h4, .item-form h4 { 
      margin-top: 0; 
      margin-bottom: 15px;
      color: #007bff; 
      font-weight: bold;
      border-bottom: 2px solid #007bff;
      padding-bottom: 8px;
    }
    .item-form .btn { margin-right: 10px; }
    .add-new-item:hover { background-color: #0056b3; border-color: #0056b3; }
    .invoice-summary { 
      background: #f8f9fa; 
      padding: 20px; 
      border: 1px solid #dee2e6; 
      border-radius: 4px; 
      margin: 20px 0; 
    }
    .summary-row { margin-bottom: 15px; }
    .summary-row:last-child { margin-bottom: 0; }
    .summary-col { padding: 0 10px; }
    .final-submit { 
      background: #f0f8f0; 
      padding: 20px; 
      border: 1px solid #d4edda; 
      border-radius: 4px; 
      text-align: center; 
      margin-top: 20px; 
    }
    
    /* Animation for form slide */
    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    /* Improved add new item button */
    .add-new-item {
      transition: all 0.3s ease;
      border: 1px solid #17a2b8;
      height: 28px;
      padding: 2px 8px;
      border-radius: 0 3px 3px 0;
    }
    .add-new-item:hover {
      background-color: #138496 !important;
      border-color: #117a8b !important;
      transform: translateY(-1px);
    }
    
    /* Input group styling for item table */
    #item_table .input-group {
      width: 100%;
    }
    #item_table .input-group .form-control {
      border-radius: 3px 0 0 3px;
    }
    #item_table .input-group-btn {
      width: auto;
    }
    #item_table .input-group-btn .btn {
      border-left: 0;
    }
    
    /* Form validation styles */
    .form-control.is-invalid {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    /* Success message styling */
    .alert-success {
      color: #155724;
      background-color: #d4edda;
      border-color: #c3e6cb;
      padding: 10px 15px;
      border-radius: 4px;
      margin: 10px 0;
    }
    
    /* VAT toggle styling */
    .radio-inline {
      font-weight: normal;
      margin-right: 10px;
      cursor: pointer;
    }
    .radio-inline input[type="radio"] {
      margin-right: 4px;
      cursor: pointer;
    }
    .radio-inline small {
      font-size: 12px;
      color: #666;
    }
    
    /* Client form specific styling */
    #clientDetailsForm {
      background: #ffffff;
      padding: 25px;
      margin: 20px 0;
      border: 2px solid #28a745;
      border-radius: 8px;
      display: none;
      box-shadow: 0 8px 16px rgba(40,167,69,0.15);
      position: relative;
      z-index: 1050;
      animation: slideDown 0.3s ease-out;
    }
    
    #clientDetailsForm h4 {
      margin-top: 0;
      margin-bottom: 15px;
      color: #28a745;
      font-weight: bold;
      border-bottom: 2px solid #28a745;
      padding-bottom: 8px;
    }
    
    /* Input group styling for client dropdown */
    #supplier + .input-group-btn .btn {
      border-left: 0;
      border-radius: 0 3px 3px 0;
    }
    
    #supplier {
      border-radius: 3px 0 0 3px;
    }
    
    /* Form validation styles for client form */
    .form-control.is-invalid {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .help-block {
      font-size: 12px;
      margin-top: 5px;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="loader"></div>
<div class="wrapper">

<?= $this->include('Include/header.php');?>
<?= $this->include('Include/sidebar.php');?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Proforma Invoice Details</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Generate Proforma Invoice</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Generate Proforma Invoice</h3>
          </div>
          
          <p align="center" style="color:#F00;" id="main-error-message"></p>

          <form class="form-horizontal" name="proformaForm" id="proformaForm" method="post" action="<?= base_url();?>/proinv/insert" enctype="multipart/form-data">
            <div class="box-body">
              
              <!-- Basic Info Section -->
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Client Name <span style="color: red;">*</span></label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <select name="supplier" id="supplier" class="form-control select2" onchange="showCustomer(this.value)">
                          <option value="">Select Client</option>
                        </select>
                        <div class="input-group-btn">
                          <button type="button" id="addNewClient" class="btn btn-info btn-sm" title="Add New Client">
                            <i class="fa fa-plus"></i>
                          </button>
                        </div>
                      </div>
                      <div id="supplier_error" style="color: red;"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Address</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" rows="2" id="c_add" name="c_add" placeholder="Client address will appear here automatically"></textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Invoice ID</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="invid" id="invid" value="<?= esc($invoice_id); ?>">
                      <div id="invid_error" style="color: red;"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Invoice Date</label>
                    <div class="col-sm-8">
                      <div class="input-group date">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" name="datepicker" class="form-control" id="datepicker" value="<?php echo date('d-m-Y'); ?>">
                      </div>
                      <div id="date_error" style="color: red;"></div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Items Table -->
              <div class="form-group col-sm-12">
                <div style="overflow-x: auto;">
                  <table class="table table-bordered" id="item_table">
                    <thead>
                      <tr>
                        <th class="col-check"><input id="checkAll" type="checkbox"></th>
                        <th class="col-item-no">Item No</th>
                        <th class="col-item-name">Item Name <span style="color: red;">*</span></th>
                        <th class="col-desc">Description</th>
                        <th class="col-qty">Qty <span style="color: red;">*</span></th>
                        <th class="col-unit">Unit</th>
                        <th class="col-price">Price <span style="color: red;">*</span></th>
                        <!-- <th class="col-vat">VAT %</th>
                        <th class="col-vat-type">VAT Type</th> -->
                        <th class="col-vat-status">Tax</th>
                        <th class="col-total">Total <span style="color: red;">*</span></th>
                        <th class="col-action">
                          <button type="button" name="add" class="btn btn-success btn-sm add">
                            <span class="glyphicon glyphicon-plus"></span>
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="datarow">
                        <td><input class="itemRow" type="checkbox"></td>
                        <td><input type="text" name="item_code[]" id="productCode_1" value="1" class="form-control"></td>
                        <td>
                          <div class="input-group">
                          <select name="item_name[]" id="productName_1" class="form-control item_name" onchange="showHsn(1,this.value)">
                            <option value="">Select Item</option>
                          </select>
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-info btn-sm add-new-item" title="Add New Item">
                                <i class="fa fa-plus"></i>
                          </button>
                            </div>
                          </div>
                        </td>
                        <td><input type="text" name="item_desc[]" id="productDesc_1" class="form-control item_desc"></td>
                        <td><input type="number" name="item_quantity[]" id="quantity_1" min="1" value="1" class="form-control quantity"></td>
                        <td><input type="text" name="unit[]" id="unit_1" value="Kgs" class="form-control unit" placeholder="Kgs"></td>
                        <td><input type="number" name="price[]" id="price_1" class="form-control price"></td>
                        <!-- <td><input type="number" name="vat_rate[]" id="vat_rate_1" value="18" class="form-control vat_rate" min="0" max="100"></td> -->
                        <!-- <td>
                          <select name="vat_type[]" id="vat_type_1" class="form-control vat_type">
                            <option value="exclusive">Exclusive</option>
                            <option value="inclusive">Inclusive</option>
                          </select>
                        </td> -->
                        <td>
                          <select name="vat_status[]" id="vat_status_1" class="form-control vat_status">
                            <option value="taxable">Vat (18%)</option>
                            <option value="exempt">Exempt</option>
                          </select>
                        </td>
                        <td><input type="number" name="total[]" id="total_1" class="form-control total" readonly></td>
                        <td>
                          <button type="button" name="remove" class="btn btn-danger btn-sm remove">
                            <span class="glyphicon glyphicon-minus"></span>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- New Item Form -->
              <div id="itemDetailsForm" class="item-form">
                <div class="clearfix">
                  <h4 style="float: left;">
                    <i class="fa fa-plus-circle text-primary"></i> Add New Item
                  </h4>
                  <button type="button" id="cancelItemForm" class="btn btn-sm btn-default" style="float: right;">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
                <div style="clear: both; margin-bottom: 15px;"></div>
                
                <div id="itemFormMessage" class="alert alert-success" style="display: none;"></div>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Item Name <span style="color: red;">*</span></label>
                      <input type="text" name="new_item_name" id="new_item_name" class="form-control" placeholder="Enter item name">
                      <div class="help-block" id="item_name_error" style="color: red;"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Description</label>
                      <input type="text" name="new_item_desc" id="new_item_desc" class="form-control" placeholder="Enter item description (optional)">
                    </div>
                  </div>
                </div>
                <div class="form-group text-right">
                  <button type="button" id="cancelItemForm2" class="btn btn-default">
                    <i class="fa fa-times"></i> Cancel
                  </button>
                  <button type="button" id="saveItemDetails" class="btn btn-primary">
                    <i class="fa fa-save"></i> Save Item
                  </button>
                </div>
              </div>

              <!-- New Bank Form -->
              <div id="bankDetailsForm" class="bank-form">
                <h4>Add New Bank Details</h4>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Bank Name <span style="color: red;">*</span></label>
                      <input type="text" name="new_bank_name" id="new_bank_name" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Account Number <span style="color: red;">*</span></label>
                      <input type="text" name="new_account_number" id="new_account_number" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Bank Code/Swift Code <span style="color: red;">*</span></label>
                      <input type="text" name="new_bank_code" id="new_bank_code" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Account Name <span style="color: red;">*</span></label>
                      <input type="text" name="new_account_name" id="new_account_name" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button type="button" id="saveBankDetails" class="btn btn-primary">Save Bank</button>
                  <button type="button" id="cancelBankForm" class="btn btn-default">Cancel</button>
                </div>
              </div>

              <!-- New Client Form -->
              <div id="clientDetailsForm" class="bank-form">
                <div class="clearfix">
                  <h4 style="float: left;">
                    <i class="fa fa-user-plus text-primary"></i> Add New Client
                  </h4>
                  <button type="button" id="cancelClientForm" class="btn btn-sm btn-default" style="float: right;">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
                <div style="clear: both; margin-bottom: 15px;"></div>
                
                <div id="clientFormMessage" class="alert alert-success" style="display: none;"></div>
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Client Name <span style="color: red;">*</span></label>
                      <input type="text" name="new_client_name" id="new_client_name" class="form-control" placeholder="Enter client name">
                      <div class="help-block" id="client_name_error" style="color: red;"></div>
                    </div>
                    <div class="form-group">
                      <label>Address <span style="color: red;">*</span></label>
                      <textarea name="new_client_address" id="new_client_address" class="form-control" rows="2" placeholder="Enter client address"></textarea>
                      <div class="help-block" id="client_address_error" style="color: red;"></div>
                    </div>
                    <div class="form-group">
                      <label>Mobile Number <span style="color: red;">*</span></label>
                      <input type="text" name="new_client_mobile" id="new_client_mobile" class="form-control" placeholder="Enter mobile number">
                      <div class="help-block" id="client_mobile_error" style="color: red;"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Country</label>
                      <input type="text" name="new_client_country" id="new_client_country" class="form-control" value="India" placeholder="Enter country">
                    </div>
                    <div class="form-group">
                      <label>GST Number</label>
                      <input type="text" name="new_client_gst" id="new_client_gst" class="form-control" placeholder="Enter GST number">
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" name="new_client_email" id="new_client_email" class="form-control" placeholder="Enter email address">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Client Type <span style="color: red;">*</span></label>
                      <select name="new_client_type" id="new_client_type" class="form-control">
                        <option value="">Select Type</option>
                        <option value="Loc">Local</option>
                        <option value="IGST">IGST</option>
                      </select>
                      <div class="help-block" id="client_type_error" style="color: red;"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>User Type <span style="color: red;">*</span></label>
                      <select name="new_client_user_type" id="new_client_user_type" class="form-control">
                        <option value="">Select User Type</option>
                        <option value="0">Regular</option>
                        <option value="1">Premium</option>
                        <option value="2">VIP</option>
                      </select>
                      <div class="help-block" id="client_user_type_error" style="color: red;"></div>
                    </div>
                  </div>
                </div>
                <div class="form-group text-right">
                  <button type="button" id="cancelClientForm2" class="btn btn-default">
                    <i class="fa fa-times"></i> Cancel
                  </button>
                  <button type="button" id="saveClientDetails" class="btn btn-primary">
                    <i class="fa fa-save"></i> Save Client
                  </button>
                </div>
              </div>

              <!-- New Signature Form -->
              <div id="signatureDetailsForm" class="bank-form">
                <h4>Add New Signature</h4>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Signature Name <span style="color: red;">*</span></label>
                      <input type="text" name="new_signature_name" id="new_signature_name" class="form-control" placeholder="e.g., Main Signature">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Upload Signature <span style="color: red;">*</span></label>
                      <input type="file" name="new_signature_file" id="new_signature_file" class="form-control" accept="image/*">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>
                    <input type="checkbox" name="set_as_default" id="set_as_default"> Set as Default Signature
                  </label>
                </div>
                <div class="form-group">
                  <button type="button" id="saveSignatureDetails" class="btn btn-primary">Save Signature</button>
                  <button type="button" id="cancelSignatureForm" class="btn btn-default">Cancel</button>
                </div>
              </div>

              <!-- Invoice Summary -->
              <div class="invoice-summary">
                <h4 style="margin-top: 0; margin-bottom: 20px;">Invoice Summary</h4>
                
                <div class="row summary-row">
                  <div class="col-md-3 summary-col">
                    <label>Subtotal <span style="color: red;">*</span></label>
                    <div class="input-group">
                      <div class="input-group-addon">USH</div>
                      <input value="" type="number" class="form-control" name="subTotal" id="subTotal" readonly>
                    </div>
                  </div>
                  <div class="col-md-3 summary-col">
                    <label>Total VAT Amount</label>
                    <div class="input-group">
                      <div class="input-group-addon">USH</div>
                      <input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" readonly>
                    </div>
                    <small class="help-block">Calculated automatically from individual items</small>
                  </div>

                  <div class="col-md-3 summary-col">
                    <label>Total <span style="color: red;">*</span></label>
                    <div class="input-group">
                      <div class="input-group-addon">USH</div>
                      <input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" readonly>
                    </div>
                  </div>
                </div>

                <div class="row summary-row">
                  <div class="col-md-6 summary-col">
                    <label>Select Bank <span style="color: red;">*</span></label>
                    <select name="bank_id" id="bank_id" class="form-control select2">
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
                  <div class="col-md-6 summary-col">
                    <label>Select Signature</label>
                    <select name="signature_id" id="signature_id" class="form-control select2">
                      <option value="">Select Signature</option>
                      <?php if(isset($userSignatures) && !empty($userSignatures)): ?>
                        <?php foreach ($userSignatures as $signature): ?>
                          <option value="<?= $signature['id'] ?>" <?= $signature['is_default'] ? 'selected' : '' ?>>
                            <?= $signature['signature_name'] ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                    <button type="button" id="addNewSignature" class="btn btn-info btn-sm" style="margin-top: 5px;">
                      <i class="fa fa-plus"></i> Add New Signature
                    </button>
                    <div id="signature_error" style="color: red;"></div>
                  </div>
                </div>

                <div class="row summary-row">
                  <div class="col-md-3 summary-col">
                    <label>Validity (Days)</label>
                    <div class="input-group">
                      <input value="90" type="number" class="form-control" name="validity_period" id="validity_period">
                      <div class="input-group-addon">Days</div>
                    </div>
                  </div>
                  <div class="col-md-3 summary-col">
                    <label>Delivery (Days)</label>
                    <div class="input-group">
                      <input value="4" type="number" class="form-control" name="delivery_period" id="delivery_period">
                      <div class="input-group-addon">Days</div>
                    </div>
                  </div>
                  <div class="col-md-6 summary-col">
                    <label>Payment Terms</label>
                    <input value="Payment must be within 30 working days after delivery" type="text" class="form-control" name="payment_terms" id="payment_terms">
                  </div>
                </div>
              </div>



              <!-- Submit -->
              <div class="final-submit">
                <input type="submit" name="submit" id="submitbtn" value="Save Invoice" 
                style="width: 20em; height: 3.5em; font-size: 18px; font-weight: bold;" class="btn btn-success">
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
 
<?= $this->include('Include/settings.php');?>
<?= $this->include('Include/footer.php');?>
 
<script type="text/javascript">
var base_url = "<?= base_url(); ?>";

$(document).ready(function() {
    var rowCount = 1;
    var currentItemRow = null;
    
    // ESC key to close form
    $(document).keyup(function(e) {
        if (e.keyCode === 27) { // ESC key
            if ($('#itemDetailsForm').is(':visible')) {
                $('#itemDetailsForm').slideUp(300);
                currentItemRow = null;
                clearItemForm();
            } else if ($('#clientDetailsForm').is(':visible')) {
                $('#clientDetailsForm').slideUp(300);
                $('#supplier').prop('disabled', false);
                clearClientForm();
            }
        }
    });
    
    $('#supplier').select2({
        placeholder: "Select Client",
        ajax: {
            url: base_url + '/proinv/getclient',
            dataType: 'json',
            delay: 250,
            data: function (params) { return { category_name: params.term }; },
            processResults: function (data) { return { results: data }; },
            cache: true
        }
    });
    
    function initializeProductSelect(selector) {
        $(selector).select2({
            placeholder: "Select Item",
            allowClear: true,
            ajax: {
                url: base_url + '/proinv/getproducts',
                dataType: 'json',
                delay: 250,
                data: function (params) { 
                    return { category_name: params.term }; 
                },
                processResults: function (data) { 
                    // Check if data is an array and has items
                    if (!Array.isArray(data) || data.length === 0) {
                        return { results: [] };
                    }
                    
                    // Map the data correctly - handle different response formats
                    var results = data.map(function(item) {
                        // Handle different possible data structures
                        if (typeof item === 'string') {
                            return { id: item, text: item };
                        } else if (item.id && item.text) {
                            return { id: item.id, text: item.text };
                        } else if (item.name) {
                            return { id: item.id || item.name, text: item.name };
                        } else {
                            return { id: item.id || item, text: item.text || item.name || item };
                        }
                    });
                    
                    return { results: results };
                },
                cache: true
            }
        });
    }
    
    initializeProductSelect('#productName_1');
    $('#datepicker').datepicker({ autoclose: true, format: 'dd-mm-yyyy' });
    
    // Form toggles
    $('#addNewBank').click(function() { 
        $('#bankDetailsForm').slideDown(300); 
        $('#bank_id').prop('disabled', true); 
    });
    $('#cancelBankForm').click(function() { 
        $('#bankDetailsForm').slideUp(300); 
        $('#bank_id').prop('disabled', false); 
        clearBankForm(); 
    });
    
    // Client form toggles
    $('#addNewClient').click(function() { 
        $('#clientDetailsForm').slideDown(300); 
        $('#supplier').prop('disabled', true); 
    });
    $('#cancelClientForm, #cancelClientForm2').click(function() { 
        $('#clientDetailsForm').slideUp(300); 
        $('#supplier').prop('disabled', false); 
        clearClientForm(); 
    });
    
    // Signature form toggles
    $('#addNewSignature').click(function() { 
        $('#signatureDetailsForm').slideDown(300); 
        $('#signature_id').prop('disabled', true); 
    });
    $('#cancelSignatureForm').click(function() { 
        $('#signatureDetailsForm').slideUp(300); 
        $('#signature_id').prop('disabled', false); 
        clearSignatureForm(); 
    });
    
    // Add New Item form handlers
    $(document).on('click', '.add-new-item', function(e) { 
        e.preventDefault();
        currentItemRow = $(this).closest('tr'); 
        $('#itemDetailsForm').slideDown(300);
        $('#new_item_name').focus();
    });
    
    // Multiple cancel handlers for different buttons
    $('#cancelItemForm, #cancelItemForm2').click(function() { 
        $('#itemDetailsForm').slideUp(300); 
        currentItemRow = null; 
        clearItemForm(); 
    });
    
    // Save handlers
    $('#saveItemDetails').click(function() {
        var itemName = $('#new_item_name').val().trim();
        var itemDesc = $('#new_item_desc').val().trim();
        
        // Clear previous errors
        $('#item_name_error').text('');
        $('#new_item_name').removeClass('is-invalid');
        $('#itemFormMessage').hide();
        
        // Validation
        if (!itemName) { 
            $('#item_name_error').text('Item name is required');
            $('#new_item_name').addClass('is-invalid').focus();
            return; 
        }
        
        // Disable button to prevent double clicks
        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        
        $.ajax({
            url: base_url + '/proinv/saveitem',
            method: 'POST',
            dataType: 'json',
            data: { 
                item_name: itemName, 
                description: itemDesc 
            },
            success: function(response) {
                
                if (response && response.success) {
                    // Show success message
                    $('#itemFormMessage').text('Item "' + itemName + '" saved successfully!').show();
                    
                    if (currentItemRow) {
                        var selectElement = currentItemRow.find('.item_name');
                        
                        // Clear existing selection first
                        selectElement.val(null).trigger('change');
                        
                        // Add new option
                        var newOption = new Option(itemName, itemName, true, true);
                        selectElement.append(newOption).trigger('change');
                        
                        // Set description
                        currentItemRow.find('.item_desc').val(itemDesc);
                    }
                    
                    // Close form after 2 seconds
                    setTimeout(function() {
                        $('#itemDetailsForm').slideUp(300); 
                        currentItemRow = null; 
                        clearItemForm();
                    }, 2000);
                    
                } else { 
                    alert('Failed to save item: ' + (response.message || 'Unknown error')); 
                }
            },
            error: function(xhr, status, error) { 
                alert('Error saving item: ' + error); 
            },
            complete: function() {
                // Re-enable button
                $('#saveItemDetails').prop('disabled', false).html('<i class="fa fa-save"></i> Save Item');
            }
        });
    });
    
    $('#saveBankDetails').click(function() {
        var bankName = $('#new_bank_name').val().trim();
        var accountNumber = $('#new_account_number').val().trim();
        var bankCode = $('#new_bank_code').val().trim();
        var accountName = $('#new_account_name').val().trim();
        
        // Clear previous errors
        $('.bank-form .error').removeClass('error');
        $('.bank-form [id$="_error"]').text('');
        
        // Validation
        if (!bankName) { $('#new_bank_name').addClass('error'); return; }
        if (!accountNumber) { $('#new_account_number').addClass('error'); return; }
        if (!bankCode) { $('#new_bank_code').addClass('error'); return; }
        if (!accountName) { $('#new_account_name').addClass('error'); return; }
        
        // Disable button to prevent double clicks
        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        
        $.ajax({
            url: base_url + '/proinv/savebank',
            method: 'POST',
            dataType: 'json',
            data: { 
                bname: bankName, 
                ac: accountNumber, 
                ifsc: bankCode, 
                account_name: accountName 
            },
            success: function(response) {
                if (response && response.success) {
                    // Add new option to bank dropdown
                    var newOption = new Option(bankName + ' - ' + accountNumber, response.bank_id, true, true);
                    $('#bank_id').append(newOption).trigger('change');
                    
                    // Close form and reset
                    $('#bankDetailsForm').slideUp(300);
                    $('#bank_id').prop('disabled', false);
                    clearBankForm();
                    
                    alert('Bank saved successfully!');
                } else {
                    alert('Failed to save bank details: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                alert('Error saving bank details: ' + error);
            },
            complete: function() {
                // Re-enable button
                $('#saveBankDetails').prop('disabled', false).html('Save Bank');
            }
        });
    });
    
    $('#saveClientDetails').click(function() {
        var clientName = $('#new_client_name').val().trim();
        var clientAddress = $('#new_client_address').val().trim();
        var clientMobile = $('#new_client_mobile').val().trim();
        var clientCountry = $('#new_client_country').val().trim();
        var clientGst = $('#new_client_gst').val().trim();
        var clientEmail = $('#new_client_email').val().trim();
        var clientType = $('#new_client_type').val();
        var clientUserType = $('#new_client_user_type').val();
        
        // Clear previous errors
        $('#clientFormMessage').hide();
        $('.help-block').text('');
        $('.form-control').removeClass('is-invalid');
        
        // Validation
        var isValid = true;
        if (!clientName) { 
            $('#client_name_error').text('Client name is required');
            $('#new_client_name').addClass('is-invalid');
            isValid = false;
        }
        if (!clientAddress) { 
            $('#client_address_error').text('Address is required');
            $('#new_client_address').addClass('is-invalid');
            isValid = false;
        }
        if (!clientMobile) { 
            $('#client_mobile_error').text('Mobile number is required');
            $('#new_client_mobile').addClass('is-invalid');
            isValid = false;
        }
        if (!clientType) { 
            $('#client_type_error').text('Client type is required');
            $('#new_client_type').addClass('is-invalid');
            isValid = false;
        }
        if (!clientUserType) { 
            $('#client_user_type_error').text('User type is required');
            $('#new_client_user_type').addClass('is-invalid');
            isValid = false;
        }
        
        if (!isValid) {
            return;
        }
        
        // Disable button to prevent double clicks
        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        
        $.ajax({
            url: base_url + '/proinv/saveclient',
            method: 'POST',
            dataType: 'json',
            data: { 
                c_name: clientName,
                c_add: clientAddress,
                mob: clientMobile,
                country: clientCountry || 'India',
                gst: clientGst,
                email: clientEmail,
                c_type: clientType,
                u_type: clientUserType
            },
            success: function(response) {
                if (response && response.success) {
                    // Show success message
                    $('#clientFormMessage').text('Client "' + clientName + '" saved successfully!').show();
                    
                    // Add new option to client dropdown
                    var newOption = new Option(clientName, response.client_id, true, true);
                    $('#supplier').append(newOption).trigger('change');
                    
                    // Set address automatically
                    $('#c_add').val(clientAddress);
                    
                    // Close form after 2 seconds
                    setTimeout(function() {
                        $('#clientDetailsForm').slideUp(300); 
                        $('#supplier').prop('disabled', false);
                        clearClientForm();
                    }, 2000);
                    
                } else { 
                    alert('Failed to save client: ' + (response.message || 'Unknown error')); 
                }
            },
            error: function(xhr, status, error) { 
                alert('Error saving client: ' + error); 
            },
            complete: function() {
                // Re-enable button
                $('#saveClientDetails').prop('disabled', false).html('<i class="fa fa-save"></i> Save Client');
            }
        });
    });
    
    $('#saveSignatureDetails').click(function() {
        var signatureName = $('#new_signature_name').val().trim();
        var signatureFile = $('#new_signature_file')[0].files[0];
        var setAsDefault = $('#set_as_default').is(':checked');
        
        // Clear previous errors
        $('.bank-form .error').removeClass('error');
        $('.bank-form [id$="_error"]').text('');
        
        // Validation
        if (!signatureName) { 
            $('#new_signature_name').addClass('error'); 
            alert('Signature name is required');
            return; 
        }
        if (!signatureFile) { 
            $('#new_signature_file').addClass('error'); 
            alert('Please select a signature file');
            return; 
        }
        
        // Disable button to prevent double clicks
        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        
        var formData = new FormData();
        formData.append('signature_name', signatureName);
        formData.append('signature_file', signatureFile);
        formData.append('set_as_default', setAsDefault ? 1 : 0);
        
        $.ajax({
            url: base_url + '/proinv/savesignature',
            method: 'POST',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response && response.success) {
                    // Add new option to signature dropdown
                    var newOption = new Option(signatureName, response.signature_id, true, true);
                    $('#signature_id').append(newOption).trigger('change');
                    
                    // Close form and reset
                    $('#signatureDetailsForm').slideUp(300);
                    $('#signature_id').prop('disabled', false);
                    clearSignatureForm();
                    
                    alert('Signature saved successfully!');
                } else {
                    alert('Failed to save signature: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr, status, error) {
                alert('Error saving signature: ' + error);
            },
            complete: function() {
                // Re-enable button
                $('#saveSignatureDetails').prop('disabled', false).html('Save Signature');
            }
        });
    });
    
    function clearBankForm() { 
        $('#new_bank_name, #new_account_number, #new_bank_code, #new_account_name').val(''); 
    }
    
    function clearClientForm() { 
        $('#new_client_name, #new_client_address, #new_client_mobile, #new_client_country, #new_client_gst, #new_client_email').val(''); 
        $('#new_client_type, #new_client_user_type').val('');
        $('.help-block').text('');
        $('.form-control').removeClass('is-invalid');
        $('#clientFormMessage').hide();
    }
    
    function clearSignatureForm() { 
        $('#new_signature_name, #new_signature_file').val(''); 
        $('#set_as_default').prop('checked', false);
    }
    
    function clearItemForm() { 
        $('#new_item_name, #new_item_desc').val(''); 
        $('#item_name_error').text('');
        $('#new_item_name').removeClass('is-invalid');
        $('#itemFormMessage').hide();
    }
    
    // Add/Remove rows
    $(document).on('click', '.add', function() {
        rowCount++;
        var html = '<tr class="datarow">';
        html += '<td><input class="itemRow" type="checkbox"></td>';
        html += '<td><input type="text" name="item_code[]" id="productCode_' + rowCount + '" value="' + rowCount + '" class="form-control"></td>';
        html += '<td><div class="input-group">';
        html += '<select name="item_name[]" id="productName_' + rowCount + '" class="form-control item_name" onchange="showHsn(' + rowCount + ',this.value)"><option value="">Select Item</option></select>';
        html += '<div class="input-group-btn"><button type="button" class="btn btn-info btn-sm add-new-item" title="Add New Item"><i class="fa fa-plus"></i></button></div>';
        html += '</div></td>';
        html += '<td><input type="text" name="item_desc[]" id="productDesc_' + rowCount + '" class="form-control item_desc"></td>';
        html += '<td><input type="number" name="item_quantity[]" id="quantity_' + rowCount + '" min="1" value="1" class="form-control quantity"></td>';
        html += '<td><input type="text" name="unit[]" id="unit_' + rowCount + '" value="Kgs" class="form-control unit"></td>';
        html += '<td><input type="number" name="price[]" id="price_' + rowCount + '" class="form-control price"></td>';
        html += '<td><input type="number" name="vat_rate[]" id="vat_rate_' + rowCount + '" value="18" class="form-control vat_rate" min="0" max="100"></td>';
        html += '<td><select name="vat_type[]" id="vat_type_' + rowCount + '" class="form-control vat_type"><option value="exclusive">Exclusive</option><option value="inclusive">Inclusive</option></select></td>';
        html += '<td><select name="vat_status[]" id="vat_status_' + rowCount + '" class="form-control vat_status"><option value="taxable">Taxable</option><option value="exempt">Exempt</option></select></td>';
        html += '<td><input type="number" name="total[]" id="total_' + rowCount + '" class="form-control total" readonly></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>';
        html += '</tr>';
        $('#item_table tbody').append(html);
        initializeProductSelect('#productName_' + rowCount);
    });
    
    $(document).on('click', '.remove', function() { $(this).closest('tr').remove(); calculateTotals(); });
    $(document).on('input', '.quantity, .price, .vat_rate', function() {
        calculateRowTotal($(this).closest('tr'));
        calculateTotals();
    });
    
    $(document).on('change', '.vat_type, .vat_status', function() {
        calculateRowTotal($(this).closest('tr'));
        calculateTotals();
    });
    
    function calculateRowTotal(row) {
        var quantity = parseFloat(row.find('.quantity').val()) || 0;
        var price = parseFloat(row.find('.price').val()) || 0;
        var vatRate = parseFloat(row.find('.vat_rate').val()) || 0;
        var vatType = row.find('.vat_type').val();
        var vatStatus = row.find('.vat_status').val();
        
        var subtotal = quantity * price;
        var vatAmount = 0;
        var total = subtotal;
        
        if (vatStatus === 'taxable' && vatRate > 0) {
            if (vatType === 'exclusive') {
                vatAmount = (subtotal * vatRate) / 100;
                total = subtotal + vatAmount;
            } else {
                // VAT inclusive - extract VAT from total
                total = subtotal;
                vatAmount = total - (total / (1 + (vatRate / 100)));
            }
        }
        
        row.find('.total').val(total.toFixed(2));
    }
    
    function calculateTotals() {
        var totalSubtotal = 0;
        var totalVatAmount = 0;
        var totalAmount = 0;
        
        $('.datarow').each(function() {
            var row = $(this);
            var quantity = parseFloat(row.find('.quantity').val()) || 0;
            var price = parseFloat(row.find('.price').val()) || 0;
            var vatRate = parseFloat(row.find('.vat_rate').val()) || 0;
            var vatType = row.find('.vat_type').val();
            var vatStatus = row.find('.vat_status').val();
            
            var rowSubtotal = quantity * price;
            var rowVatAmount = 0;
            var rowTotal = rowSubtotal;
            
            if (vatStatus === 'taxable' && vatRate > 0) {
                if (vatType === 'exclusive') {
                    rowVatAmount = (rowSubtotal * vatRate) / 100;
                    rowTotal = rowSubtotal + rowVatAmount;
                } else {
                    // VAT inclusive - extract VAT from total
                    rowTotal = rowSubtotal;
                    rowVatAmount = rowTotal - (rowTotal / (1 + (vatRate / 100)));
                }
            }
            
            totalSubtotal += rowSubtotal;
            totalVatAmount += rowVatAmount;
            totalAmount += rowTotal;
        });
        
        $('#subTotal').val(totalSubtotal.toFixed(2));
        $('#taxAmount').val(totalVatAmount.toFixed(2));
        $('#totalAftertax').val(totalAmount.toFixed(2));
    }
    
    // Form submission
    $('#proformaForm').submit(function(e) {
        e.preventDefault();
        var isValid = true;
        
        $('.error').removeClass('error');
        $('[id$="_error"]').text('');
        
        if (!$('#supplier').val()) { $('#supplier').addClass('error'); $('#supplier_error').text('Please select a client'); isValid = false; }
        
        var hasItems = false;
        $('.item_name').each(function() { if ($(this).val()) { hasItems = true; return false; } });
        if (!hasItems) { isValid = false; alert('At least one item is required'); }
        
        $('.datarow').each(function() {
            var row = $(this);
            var itemName = row.find('.item_name').val();
            var quantity = row.find('.quantity').val();
            var price = row.find('.price').val();
            if (itemName) {
                if (!quantity || quantity <= 0) { row.find('.quantity').addClass('error'); isValid = false; }
                if (!price || price <= 0) { row.find('.price').addClass('error'); isValid = false; }
            }
        });
        
        if (!$('#bank_id').val() && !$('#new_bank_name').val()) { $('#bank_error').text('Please select a bank'); isValid = false; }
        if (!$('#signature_id').val() && !$('#new_signature_name').val()) { $('#signature_error').text('Please select a signature'); isValid = false; }
        
        if (!isValid) { $('#main-error-message').text('Please correct the errors and try again.'); return; }
        
        $('#submitbtn').prop('disabled', true).val('Saving...');
        var formData = new FormData(this);
        

        
        $.ajax({
            url: $(this).attr('action'), 
            type: 'POST', 
            data: formData, 
            contentType: false, 
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response && response.success) {
                    alert('Proforma Invoice created successfully!');
                    if (response.orderid) { 
                        window.open(base_url + '/proinv/printproinv?orderid=' + response.orderid, '_blank'); 
                    }
                    $('#proformaForm')[0].reset(); 
                    location.reload();
                } else { 
                    alert('Error: ' + (response.message || 'Failed to create invoice')); 
                }
            },
            error: function(xhr, status, error) { 
                let errorMessage = 'An error occurred while saving';
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response && response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    if (xhr.responseText) {
                        errorMessage = xhr.responseText;
                    }
                }
                alert('Error: ' + errorMessage); 
            },
            complete: function() { 
                $('#submitbtn').prop('disabled', false).val('Save Invoice'); 
            }
        });
    });
});

function showCustomer(clientId) {
    if (clientId) {
        $.ajax({
            url: base_url + '/proinv/getclient', data: { client_id: clientId },
            success: function(response) {
                if (response && response.length > 0) {
                    var client = response.find(function(c) { return c.id == clientId; });
                    if (client && client.c_add) { $('#c_add').val(client.c_add); }
                }
            }
        });
    }
}

function showHsn(rowNumber, productName) {
    // HSN functionality disabled as per requirements
    // if (productName) {
    //     $.ajax({
    //         url: base_url + '/proinv/getproducthsn', dataType: 'json', data: { q: productName },
    //         success: function(response) {
    //             if (response && response.hsn) { $('#hsn_' + rowNumber).val(response.hsn); }
    //         }
    //     });
    // }
}
</script>

</body>
</html>