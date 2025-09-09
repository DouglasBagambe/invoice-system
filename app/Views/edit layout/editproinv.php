<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Edit Proforma Invoice</title>
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
    .col-item-name { width: 300px; } /* Increased width since description column is removed */
    /* .col-desc { width: 120px; } */ /* Commented out - description column removed */
    .col-qty { width: 50px; }
    .col-unit { width: 60px; }
    .col-price { width: 80px; }
    .col-vat { width: 60px; }
    .col-vat-type { width: 80px; }
    .col-vat-status { width: 80px; }
    .col-total { width: 80px; }
    .col-action { width: 50px; }
    
    /* Modern Modal Overlay */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(5px);
      z-index: 9999;
      display: none;
    }

    /* Sleek Modal Forms */
    .sleek-modal {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      border-radius: 12px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
      max-width: 500px;
      width: 90%;
      max-height: 80vh;
      overflow-y: auto;
      z-index: 10000;
      display: none;
      animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
      from {
        opacity: 0;
        transform: translate(-50%, -60%);
      }
      to {
        opacity: 1;
        transform: translate(-50%, -50%);
      }
    }

    .modal-header {
      padding: 20px 25px 0;
      border-bottom: none;
    }

    .modal-title {
      font-size: 20px;
      font-weight: 600;
      color: #2c3e50;
      margin: 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .modal-close {
      position: absolute;
      top: 15px;
      right: 20px;
      background: none;
      border: none;
      font-size: 24px;
      color: #95a5a6;
      cursor: pointer;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: all 0.2s;
    }

    .modal-close:hover {
      background: #ecf0f1;
      color: #e74c3c;
    }

    .modal-body {
      padding: 20px 25px;
    }

    .modal-footer {
      padding: 0 25px 25px;
      display: flex;
      gap: 12px;
      justify-content: flex-end;
    }

    /* Modern Form Styling */
    .form-group-modern {
      margin-bottom: 20px;
    }

    .form-group-modern label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      color: #34495e;
      font-size: 14px;
    }

    .form-control-modern {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #e1e8ed;
      border-radius: 8px;
      font-size: 14px;
      transition: all 0.3s;
      background: #fff;
    }

    .form-control-modern:focus {
      outline: none;
      border-color: #3498db;
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }

    .form-control-modern.error {
      border-color: #e74c3c;
      box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
    }

    .error-text {
      color: #e74c3c;
      font-size: 12px;
      margin-top: 4px;
      display: block;
    }

    /* Modern Buttons */
    .btn-modern {
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
    }

    .btn-primary-modern {
      background: linear-gradient(135deg, #3498db, #2980b9);
      color: white;
    }

    .btn-primary-modern:hover {
      background: linear-gradient(135deg, #2980b9, #21618c);
      transform: translateY(-1px);
      box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
    }

    .btn-secondary-modern {
      background: #ecf0f1;
      color: #7f8c8d;
      border: 2px solid #e1e8ed;
    }

    .btn-secondary-modern:hover {
      background: #d5dbdb;
      border-color: #bdc3c7;
    }

    .btn-success-modern {
      background: linear-gradient(135deg, #27ae60, #229954);
      color: white;
    }

    .btn-success-modern:hover {
      background: linear-gradient(135deg, #229954, #1e8449);
      transform: translateY(-1px);
      box-shadow: 0 5px 15px rgba(39, 174, 96, 0.4);
    }

    /* Sleek Add Buttons */
    .add-btn-sleek {
      background: linear-gradient(135deg, #3498db, #2980b9);
      border: none;
      border-radius: 6px;
      color: white;
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 14px;
    }

    .add-btn-sleek:hover {
      background: linear-gradient(135deg, #2980b9, #21618c);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(52, 152, 219, 0.4);
    }

    .add-btn-success {
      background: linear-gradient(135deg, #27ae60, #229954);
    }

    .add-btn-success:hover {
      background: linear-gradient(135deg, #229954, #1e8449);
      box-shadow: 0 4px 12px rgba(39, 174, 96, 0.4);
    }

    /* Item name field autocomplete styling */
    .item-suggestions {
      position: fixed;
      background: white;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      max-height: 200px;
      overflow-y: auto;
      z-index: 9999;
      display: none;
      min-width: 200px;
    }

    .suggestion-item {
      padding: 8px 12px;
      cursor: pointer;
      border-bottom: 1px solid #f0f0f0;
      font-size: 12px;
    }

    .suggestion-item:hover, .suggestion-item.active {
      background: #f8f9fa;
    }

    .suggestion-item:last-child {
      border-bottom: none;
    }

    /* Input group for item name with position relative */
    .item-input-wrapper {
      position: relative;
      width: 100%;
    }

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
    
    /* Success message styling */
    .success-message {
      background: linear-gradient(135deg, #d4edda, #c3e6cb);
      color: #155724;
      padding: 12px 16px;
      border-radius: 8px;
      margin: 15px 0;
      display: none;
      animation: slideDown 0.3s ease-out;
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
    
    /* Form validation styles for main form */
    .form-control.is-invalid {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .help-block {
      font-size: 12px;
      margin-top: 5px;
    }

    /* Loading state for buttons */
    .btn-loading {
      pointer-events: none;
      opacity: 0.7;
    }

    .spinner {
      width: 16px;
      height: 16px;
      border: 2px solid transparent;
      border-top: 2px solid currentColor;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .sleek-modal {
        width: 95%;
        max-height: 90vh;
      }
      
      .modal-body {
        padding: 15px 20px;
      }
      
      .modal-footer {
        padding: 0 20px 20px;
        flex-direction: column;
      }
      
      .btn-modern {
        justify-content: center;
      }
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div id="loader"></div>
<div class="wrapper">

<?= $this->include('Include/header.php');?>
<?= $this->include('Include/sidebar.php');?>

<!-- Modal Overlays -->
<div id="modalOverlay" class="modal-overlay"></div>

<!-- Client Modal -->
<div id="clientModal" class="sleek-modal">
  <div class="modal-header">
    <h4 class="modal-title">
      <i class="fa fa-user-plus" style="color: #27ae60;"></i>
      Add New Client
    </h4>
    <button type="button" class="modal-close">&times;</button>
  </div>
  <div class="modal-body">
    <div id="clientSuccessMessage" class="success-message"></div>
    
    <div class="row">
      <div class="col-md-6">
        <div class="form-group-modern">
          <label>Client Name <span style="color: #e74c3c;">*</span></label>
          <input type="text" id="new_client_name" class="form-control-modern" placeholder="Enter client name">
          <span class="error-text" id="client_name_error"></span>
        </div>
        
        <div class="form-group-modern">
          <label>Address <span style="color: #e74c3c;">*</span></label>
          <textarea id="new_client_address" class="form-control-modern" rows="2" placeholder="Enter client address" style="resize: vertical; height: auto; min-height: 80px;"></textarea>
          <span class="error-text" id="client_address_error"></span>
        </div>
        
        <div class="form-group-modern">
          <label>Mobile Number <span style="color: #e74c3c;">*</span></label>
          <input type="text" id="new_client_mobile" class="form-control-modern" placeholder="Enter mobile number">
          <span class="error-text" id="client_mobile_error"></span>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="form-group-modern">
          <label>Country</label>
          <input type="text" id="new_client_country" class="form-control-modern" value="Uganda" placeholder="Enter country">
        </div>
        
        <div class="form-group-modern">
          <label>GST Number</label>
          <input type="text" id="new_client_gst" class="form-control-modern" placeholder="Enter GST number">
        </div>
        
        <div class="form-group-modern">
          <label>Email</label>
          <input type="email" id="new_client_email" class="form-control-modern" placeholder="Enter email address">
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-md-6">
        <div class="form-group-modern">
          <label>Client Type <span style="color: #e74c3c;">*</span></label>
          <select id="new_client_type" class="form-control-modern">
            <option value="">Select Type</option>
            <option value="Loc">Local</option>
            <option value="IGST">IGST</option>
          </select>
          <span class="error-text" id="client_type_error"></span>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group-modern">
          <label>User Type <span style="color: #e74c3c;">*</span></label>
          <select id="new_client_user_type" class="form-control-modern">
            <option value="">Select User Type</option>
            <option value="0">Regular</option>
            <option value="1">Premium</option>
            <option value="2">VIP</option>
          </select>
          <span class="error-text" id="client_user_type_error"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn-modern btn-secondary-modern" id="cancelClientModal">
      <i class="fa fa-times"></i> Cancel
    </button>
    <button type="button" class="btn-modern btn-success-modern" id="saveClient">
      <i class="fa fa-save"></i> Save Client
    </button>
  </div>
</div>

<!-- Bank Modal -->
<div id="bankModal" class="sleek-modal">
  <div class="modal-header">
    <h4 class="modal-title">
      <i class="fa fa-bank" style="color: #3498db;"></i>
      Add New Bank
    </h4>
    <button type="button" class="modal-close">&times;</button>
  </div>
  <div class="modal-body">
    <div id="bankSuccessMessage" class="success-message"></div>
    
    <div class="row">
      <div class="col-md-6">
        <div class="form-group-modern">
          <label>Bank Name <span style="color: #e74c3c;">*</span></label>
          <input type="text" id="new_bank_name" class="form-control-modern" placeholder="Enter bank name">
          <span class="error-text" id="bank_name_error"></span>
        </div>
        
        <div class="form-group-modern">
          <label>Account Number <span style="color: #e74c3c;">*</span></label>
          <input type="text" id="new_account_number" class="form-control-modern" placeholder="Enter account number">
          <span class="error-text" id="account_number_error"></span>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="form-group-modern">
          <label>Bank Code/Swift Code <span style="color: #e74c3c;">*</span></label>
          <input type="text" id="new_bank_code" class="form-control-modern" placeholder="Enter bank code">
          <span class="error-text" id="bank_code_error"></span>
        </div>
        
        <div class="form-group-modern">
          <label>Account Name <span style="color: #e74c3c;">*</span></label>
          <input type="text" id="new_account_name" class="form-control-modern" placeholder="Enter account name">
          <span class="error-text" id="account_name_error"></span>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn-modern btn-secondary-modern" id="cancelBankModal">
      <i class="fa fa-times"></i> Cancel
    </button>
    <button type="button" class="btn-modern btn-primary-modern" id="saveBank">
      <i class="fa fa-save"></i> Save Bank
    </button>
  </div>
</div>

<!-- Signature Modal -->
<div id="signatureModal" class="sleek-modal">
  <div class="modal-header">
    <h4 class="modal-title">
      <i class="fa fa-pencil" style="color: #9b59b6;"></i>
      Add New Signature
    </h4>
    <button type="button" class="modal-close">&times;</button>
  </div>
  <div class="modal-body">
    <div id="signatureSuccessMessage" class="success-message"></div>
    
    <div class="form-group-modern">
      <label>Signature Name <span style="color: #e74c3c;">*</span></label>
      <input type="text" id="new_signature_name" class="form-control-modern" placeholder="e.g., Main Signature">
      <span class="error-text" id="signature_name_error"></span>
    </div>
    
    <div class="form-group-modern">
      <label>Upload Signature <span style="color: #e74c3c;">*</span></label>
      <input type="file" id="new_signature_file" class="form-control-modern" accept="image/*">
      <span class="error-text" id="signature_file_error"></span>
    </div>
    
    <div class="form-group-modern">
      <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
        <input type="checkbox" id="set_as_default" style="margin: 0;">
        Set as Default Signature
      </label>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn-modern btn-secondary-modern" id="cancelSignatureModal">
      <i class="fa fa-times"></i> Cancel
    </button>
    <button type="button" class="btn-modern btn-primary-modern" id="saveSignature">
      <i class="fa fa-save"></i> Save Signature
    </button>
  </div>
</div>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Edit Proforma Invoice Details</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Edit Proforma Invoice</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Edit Proforma Invoice</h3>
          </div>
          
          <p align="center" style="color:#F00;" id="main-error-message"></p>

          <form class="form-horizontal" name="proformaForm" id="proformaForm" method="post" action="<?= base_url();?>/proinv/updateproinv" enctype="multipart/form-data">
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
                          <button type="button" id="addNewClient" class="add-btn-sleek add-btn-success" title="Add New Client">
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
                      <input type="text" class="form-control" name="invid" id="invid" value="">
                      <div id="invid_error" style="color: red;"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Invoice Date</label>
                    <div class="col-sm-8">
                      <div class="input-group date">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input 
                          type="date" 
                          name="datepicker" 
                          class="form-control" 
                          id="datepicker" 
                          value="<?= date('Y-m-d'); ?>"
                        >
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
                        <th class="col-item-name">Item Description <span style="color: red;">*</span></th>
                        <!-- <th class="col-desc">Description</th> -->
                        <th class="col-qty">Qty <span style="color: red;">*</span></th>
                        <th class="col-unit">Unit</th>
                        <th class="col-price">Price <span style="color: red;">*</span></th>
                        <th class="col-vat-status">Tax</th>
                        <th class="col-total">Total <span style="color: red;">*</span></th>
                        <th class="col-action">
                          <button type="button" name="add" class="btn btn-success btn-sm add">
                            <span class="glyphicon glyphicon-plus"></span>
                          </button>
                        </th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                  </table>
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
                    <div class="input-group">
                      <select name="bank_id" id="bank_id" class="form-control select2">
                        <option value="">Select Bank</option>
                        <?php if(isset($banks) && !empty($banks)): ?>
                          <?php foreach ($banks as $bank): ?>
                            <option value="<?= $bank['bid'] ?>"><?= $bank['bname'] ?> - <?= $bank['ac'] ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <div class="input-group-btn">
                        <button type="button" id="addNewBank" class="add-btn-sleek" title="Add New Bank">
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div id="bank_error" style="color: red;"></div>
                  </div>
                  <div class="col-md-6 summary-col">
                    <label>Select Signature</label>
                    <div class="input-group">
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
                      <div class="input-group-btn">
                        <button type="button" id="addNewSignature" class="add-btn-sleek" title="Add New Signature">
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
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
                <input type="submit" name="submit" id="submitbtn" value="Update Invoice" 
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
    var rowCount = 0;
    var debounceTimer = null;
    
    // ESC key to close modals
    $(document).keyup(function(e) {
        if (e.keyCode === 27) { // ESC key
            closeAllModals();
        }
    });
    
    // Modal functions
    function showModal(modalId) {
        $('#modalOverlay').fadeIn(300);
        $('#' + modalId).fadeIn(300);
    }
    
    function closeModal(modalId) {
        $('#' + modalId).fadeOut(300);
        $('#modalOverlay').fadeOut(300);
    }
    
    function closeAllModals() {
        $('.sleek-modal').fadeOut(300);
        $('#modalOverlay').fadeOut(300);
        clearAllForms();
    }
    
    // Modal event handlers
    $('#addNewClient').click(() => showModal('clientModal'));
    $('#addNewBank').click(() => showModal('bankModal'));
    $('#addNewSignature').click(() => showModal('signatureModal'));
    
    // Close modal buttons
    $('.modal-close, #cancelClientModal, #cancelBankModal, #cancelSignatureModal').click(function() {
        closeAllModals();
    });
    
    // Click outside modal to close
    $('#modalOverlay').click(function() {
        closeAllModals();
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
    
    $('#datepicker').datepicker({ autoclose: true, format: 'dd-mm-yyyy' });
    
    // Item name autocomplete functionality
    $(document).on('input', '.item_name', function() {
        var $input = $(this);
        var value = $input.val().trim();
        var rowId = $input.attr('id').split('_')[1];
        var $suggestions = $('#suggestions_' + rowId);
        
        if (debounceTimer) {
            clearTimeout(debounceTimer);
        }
        
        if (value.length < 2) {
            $suggestions.hide();
            return;
        }
        
        debounceTimer = setTimeout(function() {
            $.ajax({
                url: base_url + '/proinv/getproducts',
                method: 'GET',
                dataType: 'json',
                data: { category_name: value },
                success: function(data) {
                    $suggestions.empty();
                    
                    if (data && data.length > 0) {
                        data.forEach(function(item) {
                            var itemText = typeof item === 'string' ? item : (item.text || item.name || item);
                            var itemId = typeof item === 'string' ? item : (item.id || item.name || item);
                            
                            $suggestions.append(
                                '<div class="suggestion-item" data-value="' + itemId + '">' + itemText + '</div>'
                            );
                        });
                        
                        // Position the suggestions relative to the input field
                        var inputOffset = $input.offset();
                        var inputWidth = $input.outerWidth();
                        
                        $suggestions.css({
                            'top': inputOffset.top + $input.outerHeight() + 2,
                            'left': inputOffset.left,
                            'width': inputWidth
                        });
                        
                        $suggestions.show();
                    } else {
                        $suggestions.hide();
                    }
                },
                error: function() {
                    $suggestions.hide();
                }
            });
        }, 300);
    });
    
    // Handle suggestion clicks
    $(document).on('click', '.suggestion-item', function() {
        var $suggestion = $(this);
        var value = $suggestion.data('value');
        var text = $suggestion.text();
        var $suggestions = $suggestion.parent();
        var rowId = $suggestions.attr('id').split('_')[1];
        
        $('#productName_' + rowId).val(text);
        $suggestions.hide();
    });
    
    // Hide suggestions when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.item-input-wrapper').length && !$(e.target).closest('.item-suggestions').length) {
            $('.item-suggestions').hide();
        }
    });
    
    // Reposition suggestions on scroll
    $(window).on('scroll resize', function() {
        $('.item-suggestions:visible').each(function() {
            var $suggestions = $(this);
            var rowId = $suggestions.attr('id').split('_')[1];
            var $input = $('#productName_' + rowId);
            
            if ($input.length) {
                var inputOffset = $input.offset();
                $suggestions.css({
                    'top': inputOffset.top + $input.outerHeight() + 2,
                    'left': inputOffset.left,
                    'width': $input.outerWidth()
                });
            }
        });
    });
    
    // Auto-save new items function
    function saveItemIfNew(itemName, rowId) {
        if (!itemName || itemName.trim() === '') return;
        
        // Check if item already exists in database by making a quick search
        $.ajax({
            url: base_url + '/proinv/checkitem',
            method: 'GET',
            dataType: 'json',
            data: { item_name: itemName.trim() },
            success: function(response) {
                if (!response.exists) {
                    // Item doesn't exist, save it automatically
                    $.ajax({
                        url: base_url + '/proinv/saveitem',
                        method: 'POST',
                        dataType: 'json',
                        data: { 
                            item_name: itemName.trim(),
                            description: '' 
                        },
                        success: function(saveResponse) {
                            console.log('New item saved automatically: ' + itemName);
                        },
                        error: function() {
                            console.log('Could not auto-save item: ' + itemName);
                        }
                    });
                }
            },
            error: function() {
                // If check fails, just continue - item will be used as-is
                console.log('Could not check if item exists: ' + itemName);
            }
        });
    }
    
    // Save handlers with improved UI feedback
    $('#saveClient').click(function() {
        var $btn = $(this);
        var originalHtml = $btn.html();
        
        // Collect form data
        var clientData = {
            c_name: $('#new_client_name').val().trim(),
            c_add: $('#new_client_address').val().trim(),
            mob: $('#new_client_mobile').val().trim(),
            country: $('#new_client_country').val().trim() || 'Uganda',
            gst: $('#new_client_gst').val().trim(),
            email: $('#new_client_email').val().trim(),
            c_type: $('#new_client_type').val(),
            u_type: parseInt($('#new_client_user_type').val())
        };
        
        // Clear previous errors
        $('.error-text').text('');
        $('.form-control-modern').removeClass('error');
        
        // Validation
        var isValid = true;
        if (!clientData.c_name) {
            $('#client_name_error').text('Client name is required');
            $('#new_client_name').addClass('error');
            isValid = false;
        }
        if (!clientData.c_add) {
            $('#client_address_error').text('Address is required');
            $('#new_client_address').addClass('error');
            isValid = false;
        }
        if (!clientData.mob) {
            $('#client_mobile_error').text('Mobile number is required');
            $('#new_client_mobile').addClass('error');
            isValid = false;
        }
        if (!clientData.c_type) {
            $('#client_type_error').text('Client type is required');
            $('#new_client_type').addClass('error');
            isValid = false;
        }
        if (!clientData.u_type && clientData.u_type !== 0) {
            $('#client_user_type_error').text('User type is required');
            $('#new_client_user_type').addClass('error');
            isValid = false;
        }
        
        if (!isValid) return;
        
        // Show loading state
        $btn.addClass('btn-loading').html('<div class="spinner"></div> Saving...');
        
        $.ajax({
            url: base_url + '/proinv/saveclient',
            method: 'POST',
            dataType: 'json',
            data: clientData,
            success: function(response) {
                if (response && response.success) {
                    $('#clientSuccessMessage').text('Client "' + clientData.c_name + '" saved successfully!').show();
                    
                    // Add to dropdown
                    var newOption = new Option(clientData.c_name, response.client_id, true, true);
                    $('#supplier').append(newOption).trigger('change');
                    $('#c_add').val(clientData.c_add);
                    
                    setTimeout(() => closeModal('clientModal'), 1500);
                } else {
                    alert('Failed to save client: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr) {
                alert('Error saving client: ' + (xhr.responseText || 'Unknown error'));
            },
            complete: function() {
                $btn.removeClass('btn-loading').html(originalHtml);
            }
        });
    });
    
    $('#saveBank').click(function() {
        var $btn = $(this);
        var originalHtml = $btn.html();
        
        var bankData = {
            bname: $('#new_bank_name').val().trim(),
            ac: $('#new_account_number').val().trim(),
            ifsc: $('#new_bank_code').val().trim(),
            account_name: $('#new_account_name').val().trim()
        };
        
        // Clear errors
        $('.error-text').text('');
        $('.form-control-modern').removeClass('error');
        
        // Validation
        var isValid = true;
        if (!bankData.bname) {
            $('#bank_name_error').text('Bank name is required');
            $('#new_bank_name').addClass('error');
            isValid = false;
        }
        if (!bankData.ac) {
            $('#account_number_error').text('Account number is required');
            $('#new_account_number').addClass('error');
            isValid = false;
        }
        if (!bankData.ifsc) {
            $('#bank_code_error').text('Bank code is required');
            $('#new_bank_code').addClass('error');
            isValid = false;
        }
        if (!bankData.account_name) {
            $('#account_name_error').text('Account name is required');
            $('#new_account_name').addClass('error');
            isValid = false;
        }
        
        if (!isValid) return;
        
        $btn.addClass('btn-loading').html('<div class="spinner"></div> Saving...');
        
        $.ajax({
            url: base_url + '/proinv/savebank',
            method: 'POST',
            dataType: 'json',
            data: bankData,
            success: function(response) {
                if (response && response.success) {
                    $('#bankSuccessMessage').text('Bank saved successfully!').show();
                    
                    var newOption = new Option(bankData.bname + ' - ' + bankData.ac, response.bank_id, true, true);
                    $('#bank_id').append(newOption).trigger('change');
                    
                    setTimeout(() => closeModal('bankModal'), 1500);
                } else {
                    alert('Failed to save bank: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr) {
                alert('Error saving bank: ' + (xhr.responseText || 'Unknown error'));
            },
            complete: function() {
                $btn.removeClass('btn-loading').html(originalHtml);
            }
        });
    });
    
    $('#saveSignature').click(function() {
        var $btn = $(this);
        var originalHtml = $btn.html();
        
        var signatureName = $('#new_signature_name').val().trim();
        var signatureFile = $('#new_signature_file')[0].files[0];
        var setAsDefault = $('#set_as_default').is(':checked');
        
        // Clear errors
        $('.error-text').text('');
        $('.form-control-modern').removeClass('error');
        
        var isValid = true;
        if (!signatureName) {
            $('#signature_name_error').text('Signature name is required');
            $('#new_signature_name').addClass('error');
            isValid = false;
        }
        if (!signatureFile) {
            $('#signature_file_error').text('Please select a signature file');
            $('#new_signature_file').addClass('error');
            isValid = false;
        }
        
        if (!isValid) return;
        
        $btn.addClass('btn-loading').html('<div class="spinner"></div> Saving...');
        
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
                    $('#signatureSuccessMessage').text('Signature saved successfully!').show();
                    
                    var newOption = new Option(signatureName, response.signature_id, true, true);
                    $('#signature_id').append(newOption).trigger('change');
                    
                    setTimeout(() => closeModal('signatureModal'), 1500);
                } else {
                    alert('Failed to save signature: ' + (response.message || 'Unknown error'));
                }
            },
            error: function(xhr) {
                alert('Error saving signature: ' + (xhr.responseText || 'Unknown error'));
            },
            complete: function() {
                $btn.removeClass('btn-loading').html(originalHtml);
            }
        });
    });
    
    function clearAllForms() {
        // Clear client form
        $('#new_client_name, #new_client_address, #new_client_mobile, #new_client_country, #new_client_gst, #new_client_email').val('');
        $('#new_client_type, #new_client_user_type').val('');
        $('#new_client_country').val('Uganda');
        
        // Clear bank form
        $('#new_bank_name, #new_account_number, #new_bank_code, #new_account_name').val('');
        
        // Clear signature form
        $('#new_signature_name, #new_signature_file').val('');
        $('#set_as_default').prop('checked', false);
        
        // Clear all errors
        $('.error-text').text('');
        $('.form-control-modern').removeClass('error');
        $('.success-message').hide();
    }
    
    // Add/Remove rows
    $(document).on('click', '.add', function() {
        rowCount++;
        var html = '<tr class="datarow">';
        html += '<td><input class="itemRow" type="checkbox"></td>';
        html += '<td><input type="text" name="item_code[]" id="productCode_' + rowCount + '" value="' + rowCount + '" class="form-control"></td>';
        html += '<td>';
        html += '<div class="item-input-wrapper">';
        html += '<input type="text" name="item_name[]" id="productName_' + rowCount + '" class="form-control item_name" placeholder="Type item description..." onchange="saveItemIfNew(this.value, ' + rowCount + ')">';
        html += '<div class="item-suggestions" id="suggestions_' + rowCount + '"></div>';
        html += '</div>';
        html += '</td>';
        // html += '<td><input type="text" name="item_desc[]" id="productDesc_' + rowCount + '" class="form-control item_desc"></td>';
        html += '<td><input type="number" name="item_quantity[]" id="quantity_' + rowCount + '" min="1" value="1" class="form-control quantity"></td>';
        html += '<td><input type="text" name="unit[]" id="unit_' + rowCount + '" value="Kgs" class="form-control unit" placeholder="Kgs"></td>';
        html += '<td><input type="number" name="price[]" id="price_' + rowCount + '" class="form-control price"></td>';
        html += '<td>';
        html += '<select name="vat_status[]" id="vat_status_' + rowCount + '" class="form-control vat_status">';
        html += '<option value="taxable">Vat (18%)</option>';
        html += '<option value="exempt">Exempt</option>';
        html += '</select>';
        html += '</td>';
        html += '<td><input type="number" name="total[]" id="total_' + rowCount + '" class="form-control total" readonly></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>';
        html += '</tr>';
        $('#item_table tbody').append(html);
    });
    
    $(document).on('click', '.remove', function() { 
        $(this).closest('tr').remove(); 
        calculateTotals(); 
    });
    
    $(document).on('input', '.quantity, .price', function() {
        calculateRowTotal($(this).closest('tr'));
        calculateTotals();
    });
    
    $(document).on('change', '.vat_status', function() {
        calculateRowTotal($(this).closest('tr'));
        calculateTotals();
    });
    
    function calculateRowTotal(row) {
        var quantity = parseFloat(row.find('.quantity').val()) || 0;
        var price = parseFloat(row.find('.price').val()) || 0;
        var vatStatus = row.find('.vat_status').val();
        
        var subtotal = quantity * price;
        var vatAmount = 0;
        var total = subtotal;
        
        if (vatStatus === 'taxable') {
            var vatRate = 18;
            vatAmount = (subtotal * vatRate) / 100;
            total = subtotal + vatAmount;
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
            var vatStatus = row.find('.vat_status').val();
            
            var rowSubtotal = quantity * price;
            var rowVatAmount = 0;
            var rowTotal = rowSubtotal;
            
            if (vatStatus === 'taxable') {
                var vatRate = 18;
                rowVatAmount = (rowSubtotal * vatRate) / 100;
                rowTotal = rowSubtotal + rowVatAmount;
            }
            
            totalSubtotal += rowSubtotal;
            totalVatAmount += rowVatAmount;
            totalAmount += rowTotal;
        });
        
        $('#subTotal').val(totalSubtotal.toFixed(2));
        $('#taxAmount').val(totalVatAmount.toFixed(2));
        $('#totalAftertax').val(totalAmount.toFixed(2));
    }
    
    // Form submission with retry mechanism
    $('#proformaForm').submit(function(e) {
        e.preventDefault();
        var isValid = true;
        var retryCount = 0;
        var maxRetries = 3;
        
        $('.error').removeClass('error');
        $('[id$="_error"]').text('');
        
        if (!$('#supplier').val()) { 
            $('#supplier').addClass('error'); 
            $('#supplier_error').text('Please select a client'); 
            isValid = false; 
        }
        
        var hasItems = false;
        $('.item_name').each(function() { 
            if ($(this).val()) { 
                hasItems = true; 
                return false; 
            } 
        });
        if (!hasItems) { 
            isValid = false; 
            alert('At least one item is required'); 
        }
        
        $('.datarow').each(function() {
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
        
        if (!$('#bank_id').val()) { 
            $('#bank_error').text('Please select a bank'); 
            isValid = false; 
        }
        
        if (!isValid) { 
            $('#main-error-message').text('Please correct the errors and try again.'); 
            return; 
        }
        
        function submitForm() {
            $('#submitbtn').prop('disabled', true).val('Updating...');
            var formData = new FormData($('#proformaForm')[0]);
            
            // Get orderid from URL
            var url = window.location.href;
            var orderId = url.substring(url.lastIndexOf('/') + 1);
            formData.append('orderid', orderId);
            
            $.ajax({
                url: base_url + '/proinv/updateproinv/' + orderId, 
                type: 'POST', 
                data: formData, 
                contentType: false, 
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response && response.success) {
                        var message = 'Proforma Invoice updated successfully!';
                        
                        // Check if invoice ID was changed due to conflict
                        if (response.invid && response.original_invid && response.invid !== response.original_invid) {
                            message += '\n\nNote: Invoice ID was automatically changed from ' + response.original_invid + ' to ' + response.invid + ' to avoid conflicts.';
                        }
                        
                        alert(message);
                        
                        if (response.orderid) { 
                            window.open(base_url + '/proinv/printproinv?orderid=' + response.orderid, '_blank'); 
                        }
                        location.reload();
                    } else { 
                        alert('Error: ' + (response.message || 'Failed to update invoice')); 
                        $('#submitbtn').prop('disabled', false).val('Update Invoice');
                    }
                },
                error: function(xhr, status, error) { 
                    retryCount++;
                    
                    // Check if it's a database conflict error and we haven't exceeded max retries
                    if (retryCount < maxRetries && (xhr.status === 500 || xhr.status === 409)) {
                        console.log('Retrying submission, attempt ' + retryCount + ' of ' + maxRetries);
                        $('#submitbtn').val('Retrying... (' + retryCount + '/' + maxRetries + ')');
                        
                        // Wait a bit before retrying
                        setTimeout(function() {
                            submitForm();
                        }, 1000 * retryCount); // Increasing delay with each retry
                    } else {
                        let errorMessage = 'An error occurred while updating';
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
                        alert('Error: ' + errorMessage + (retryCount >= maxRetries ? '\n\nMaximum retry attempts reached.' : '')); 
                        $('#submitbtn').prop('disabled', false).val('Update Invoice');
                    }
                }
            });
        }
        
        // Start the submission process
        submitForm();
    });

    // Load existing invoice data
    var url = window.location.href;
    var orderId = url.substring(url.lastIndexOf('/') + 1);
    if (orderId) {
        loadInvoiceData(orderId);
    }

    function loadInvoiceData(orderId) {
        $.ajax({
            url: base_url + '/proinv/editproinv/' + orderId,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response && response.records && response.records2) {
                    // Populate header fields
                    var inv = response.records2[0];
                    $('#invid').val(inv.invid);
                    
                    // Format date to yyyy-mm-dd for input[type=date]
                    var dateStr = inv.created;
                    if (dateStr) {
                        // Handle different date formats
                        if (dateStr.includes('-')) {
                            var dateParts = dateStr.split('-');
                            if (dateParts.length === 3) {
                                // If already in YYYY-MM-DD format, use as is
                                if (dateParts[0].length === 4) {
                                    $('#datepicker').val(dateStr);
                                } else {
                                    // If in DD-MM-YYYY format, convert to YYYY-MM-DD
                                    var formattedDate = dateParts[2] + '-' + dateParts[1] + '-' + dateParts[0];
                                    $('#datepicker').val(formattedDate);
                                }
                            }
                        }
                    }
                    
                    // Pre-select client
                    var clientOption = new Option(inv.c_name, inv.cid, true, true);
                    $('#supplier').append(clientOption).trigger('change');
                    $('#c_add').val(inv.c_add);
                    
                    // Pre-select bank
                    if (inv.bank_id) {
                        $('#bank_id').val(inv.bank_id).trigger('change');
                    }
                    
                    // Pre-select signature
                    if (inv.signature_id) {
                        $('#signature_id').val(inv.signature_id).trigger('change');
                    }
                    
                    // Populate terms
                    $('#validity_period').val(inv.validity_period || 90);
                    $('#delivery_period').val(inv.delivery_period || 4);
                    $('#payment_terms').val(inv.payment_terms || 'Payment must be within 30 working days after delivery');
                    
                    // Populate items table
                    response.records.forEach(function(item, index) {
                        rowCount++;
                        var html = '<tr class="datarow">';
                        html += '<td><input class="itemRow" type="checkbox"></td>';
                        html += '<td><input type="text" name="item_code[]" id="productCode_' + rowCount + '" value="' + (index + 1) + '" class="form-control"></td>';
                        html += '<td>';
                        html += '<div class="item-input-wrapper">';
                        html += '<input type="text" name="item_name[]" id="productName_' + rowCount + '" value="' + (item.item_name || '') + '" class="form-control item_name" placeholder="Type item description..." onchange="saveItemIfNew(this.value, ' + rowCount + ')">';
                        html += '<div class="item-suggestions" id="suggestions_' + rowCount + '"></div>';
                        html += '</div>';
                        html += '</td>';
                        html += '<td><input type="number" name="item_quantity[]" id="quantity_' + rowCount + '" min="1" value="' + (item.quantity || 1) + '" class="form-control quantity"></td>';
                        html += '<td><input type="text" name="unit[]" id="unit_' + rowCount + '" value="' + (item.unit || 'Kgs') + '" class="form-control unit" placeholder="Kgs"></td>';
                        html += '<td><input type="number" name="price[]" id="price_' + rowCount + '" value="' + (item.price || 0) + '" class="form-control price"></td>';
                        html += '<td>';
                        html += '<select name="vat_status[]" id="vat_status_' + rowCount + '" class="form-control vat_status">';
                        html += '<option value="taxable" ' + (item.vat_status === 'taxable' ? 'selected' : '') + '>Vat (18%)</option>';
                        html += '<option value="exempt" ' + (item.vat_status === 'exempt' ? 'selected' : '') + '>Exempt</option>';
                        html += '</select>';
                        html += '</td>';
                        html += '<td><input type="number" name="total[]" id="total_' + rowCount + '" value="' + (item.total || 0) + '" class="form-control total" readonly></td>';
                        html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td>';
                        html += '</tr>';
                        $('#item_table tbody').append(html);
                    });
                    
                    // Populate totals
                    $('#subTotal').val(inv.subtotal || 0);
                    $('#taxAmount').val(inv.taxamount || 0);
                    $('#totalAftertax').val(inv.totalamount || 0);
                    
                    // Recalculate to ensure consistency
                    calculateTotals();
                } else {
                    console.error('Invalid response format:', response);
                    alert('Failed to load invoice data - invalid response format.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                alert('Failed to load invoice data: ' + error);
            }
        });
    }
});

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
</script>

</body>
</html>