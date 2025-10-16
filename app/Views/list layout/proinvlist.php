<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EMAX | Proforma Invoice List</title>
  <link rel="icon" type="image/jpeg" href="<?= base_url(); ?>/Emax_logo.jpg">

<?= $this->include('Include/links.php');?>

<style type="text/css">
  img {
    image-rendering: -webkit-optimize-contrast !important;
  }
  
  /* Modern Filter Card */
  .filter-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: none;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border-left: 4px solid #3c8dbc;
  }
  
  .filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    gap: 20px;
    flex-wrap: wrap;
  }
  
  .filter-title {
    color: #2c3e50;
    font-size: 18px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
  }
  
  .filter-title i {
    color: #3c8dbc;
    font-size: 20px;
  }
  
  .create-invoice-btn {
    background: linear-gradient(135deg, #00c853 0%, #00e676 100%);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    white-space: nowrap;
  }
  
  .create-invoice-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 200, 83, 0.3);
    color: white;
    text-decoration: none;
  }
  
  .create-invoice-btn i {
    font-size: 16px;
  }
  
  .filter-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    align-items: end;
  }
  
  .filter-group {
    display: flex;
    flex-direction: column;
  }
  
  .filter-group label {
    font-weight: 600;
    color: #34495e;
    margin-bottom: 8px;
    font-size: 14px;
  }
  
  .filter-group .form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 10px 15px;
    transition: all 0.3s ease;
    font-size: 14px;
  }
  
  .filter-group .form-control:focus {
    border-color: #3c8dbc;
    box-shadow: 0 0 0 3px rgba(60, 141, 188, 0.1);
  }
  
  .filter-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-start;
  }
  
  .btn-filter, .btn-clear {
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .btn-filter {
    background: linear-gradient(135deg, #3c8dbc 0%, #5bc0de 100%);
    color: white;
  }
  
  .btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(60, 141, 188, 0.3);
  }
  
  .btn-clear {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    color: white;
  }
  
  .btn-clear:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(243, 156, 18, 0.3);
  }
  
  /* Results Info */
  .results-info {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: none;
    border-radius: 8px;
    padding: 12px 18px;
    color: #155724;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 25px;
  }
  
  .invoice-table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
  }
  
  .invoice-table table {
    width: 100%;
    margin: 0;
  }
  
  .invoice-table thead {
    background: linear-gradient(135deg, #3c8dbc 0%, #5bc0de 100%);
  }
  
  .invoice-table thead th {
    color: white;
    font-weight: 600;
    padding: 15px 20px;
    border: none;
    text-align: left;
  }
  
  .invoice-table tbody tr {
    transition: all 0.2s ease;
    cursor: pointer;
  }
  
  .invoice-table tbody tr:hover {
    background: #f8f9fa;
  }
  
  .invoice-table tbody td {
    padding: 15px 20px;
    border-bottom: 1px solid #e9ecef;
    color: #495057;
    vertical-align: middle;
  }
  
  .invoice-table tbody tr:last-child td {
    border-bottom: none;
  }
  
  /* Action Dropdown */
  .action-dropdown {
    position: relative;
    display: inline-block;
  }

  .action-trigger {
    background: transparent;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
  }

  .action-trigger:hover {
    background: #f8f9fa;
    color: #495057;
  }

  .action-trigger i {
    font-size: 18px;
  }

  .action-menu {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    border: 1px solid #e9ecef;
    min-width: 180px;
    z-index: 1000;
    display: none;
    margin-top: 4px;
    overflow: hidden;
  }

  .action-menu.show {
    display: block;
    animation: dropdownFadeIn 0.2s ease;
  }

  @keyframes dropdownFadeIn {
    from {
      opacity: 0;
      transform: translateY(-8px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .action-menu-item {
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    color: #495057;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
  }

  .action-menu-item:hover {
    background: #f8f9fa;
  }

  .action-menu-item i {
    width: 18px;
    font-size: 16px;
    color: #6c757d;
  }

  .action-menu-item.print-action:hover i {
    color: #17a2b8;
  }

  .action-menu-item.download-action:hover i {
    color: #28a745;
  }

  .action-menu-item.edit-action:hover i {
    color: #007bff;
  }

  .action-menu-item.delete-action {
    border-top: 1px solid #e9ecef;
    color: #dc3545;
  }

  .action-menu-item.delete-action:hover {
    background: #ffebee;
  }

  .action-menu-item.delete-action i {
    color: #dc3545;
  }
  
  /* Enhanced Pagination */
  .pagination-wrapper {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-top: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    text-align: center;
  }
  
  .pagination {
    display: inline-flex;
    gap: 5px;
  }
  
  .pagination li {
    list-style: none;
  }
  
  .pagination .page-link {
    padding: 8px 12px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    color: #495057;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .pagination .page-item.active .page-link {
    background: #3c8dbc;
    border-color: #3c8dbc;
    color: white;
  }
  
  .pagination .page-link:hover:not(.active) {
    background: #f8f9fa;
    border-color: #3c8dbc;
    color: #3c8dbc;
  }
  
  /* Active Filters */
  .active-filters {
    margin-top: 15px;
    display: none;
  }
  
  .filter-tag {
    display: inline-block;
    background: linear-gradient(135deg, #3c8dbc 0%, #5bc0de 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    margin: 4px;
    font-size: 12px;
    font-weight: 600;
  }
  
  .filter-tag .remove-filter {
    margin-left: 8px;
    cursor: pointer;
    color: #fff;
    opacity: 0.8;
    font-weight: bold;
  }
  
  .filter-tag .remove-filter:hover {
    opacity: 1;
  }
  
  /* Loading State */
  .loading-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
  }
  
  .loading-state i {
    color: #3c8dbc;
    margin-bottom: 15px;
  }
  
  .loading-state p {
    color: #6c757d;
    font-weight: 600;
    margin: 0;
  }
  
  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
  }
  
  .empty-state i {
    font-size: 48px;
    color: #6c757d;
    margin-bottom: 20px;
  }
  
  .empty-state h3 {
    color: #495057;
    margin-bottom: 10px;
  }
  
  .empty-state p {
    color: #6c757d;
    margin: 0;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .filter-header {
      flex-direction: column;
      align-items: stretch;
    }
    
    .create-invoice-btn {
      width: 100%;
      justify-content: center;
    }
    
    .filter-row {
      grid-template-columns: 1fr;
    }
    
    .invoice-table {
      overflow-x: auto;
    }
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
        Proforma Invoice List
        <small>Manage and filter your invoices</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Proforma Invoice List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Enhanced Filter Section -->
      <div class="filter-card">
        <div class="filter-header">
          <div class="filter-title">
            <i class="fa fa-filter"></i>
            Smart Filters
          </div>
          <a href="<?= base_url('/proinv/genproinv'); ?>" class="create-invoice-btn">
            <i class="fa fa-plus"></i>
            <span>New Invoice</span>
          </a>
        </div>
        
        <form id="filterForm">
          <div class="filter-row">
            
            <!-- Select Client -->
            <div class="filter-group">
              <label for="client">Client:</label>
              <select name="client" id="client" class="form-control select2" style="width:100% !important;">
                <option value="">All Clients</option>
              </select>
            </div>
            
            <!-- Select Product -->
            <div class="filter-group">
              <label for="product">Product:</label>
              <select name="product" id="product" class="form-control select2" style="width:100% !important;">
                <option value="">All Products</option>
              </select>
            </div>
            
            <!-- Date From -->
            <div class="filter-group">
              <label for="date_from">From Date:</label>
              <input type="date" name="date_from" id="date_from" class="form-control">
            </div>
            
            <!-- Date To -->
            <div class="filter-group">
              <label for="date_to">To Date:</label>
              <input type="date" name="date_to" id="date_to" class="form-control">
            </div>
            
            <!-- Filter Actions -->
            <div class="filter-actions">
              <button type="button" id="applyFilters" class="btn-filter">
                <i class="fa fa-search"></i>
                Apply Filters
              </button>
              <button type="button" id="clearFilters" class="btn-clear">
                <i class="fa fa-refresh"></i>
                Clear All
              </button>
            </div>
            
          </div>
          
          <!-- Active Filters Display -->
          <div class="active-filters" id="activeFilters">
            <strong>Active Filters:</strong>
            <div id="filterTags"></div>
          </div>
          
        </form>
      </div>

      <!-- Results Info -->
      <div class="results-info" id="resultsInfo" style="display: none;">
        <i class="fa fa-info-circle"></i>
        <span id="resultsText"></span>
      </div>

      <!-- List View -->
      <div class="invoice-table">
        <table>
          <thead>
            <tr>
              <th>Invoice ID</th>
              <th>Client</th>
              <th>Location</th>
              <th>Product</th>
              <th>Total Amount</th>
              <th>Date</th>
              <th style="text-align: center;">Actions</th>
            </tr>
          </thead>
          <tbody id="invoiceTableBody">
            <!-- Table rows will be populated here -->
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="pagination-wrapper">
        <nav aria-label="Page navigation">
          <ul id="pagination" class="pagination"></ul>
        </nav>
      </div>
      
    </section>
    
  </div>

<?= $this->include('Include/footer.php');?>
<?= $this->include('Include/settings.php');?>

<script>
  var base_url = "<?= base_url(); ?>";
</script>

<script>
  
// Global variables to store current filter selections
let currentFilters = {
  client: '',
  product: '',
  date_from: '',
  date_to: ''
};
let currentPage = 1;

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
  if (!e.target.closest('.action-dropdown')) {
    document.querySelectorAll('.action-menu').forEach(menu => {
      menu.classList.remove('show');
    });
  }
});

// Function to generate action dropdown HTML
function getActionDropdown(orderid) {
  return `
    <div class="action-dropdown">
      <button class="action-trigger" onclick="toggleActionMenu(event, this)">
        <i class="fa fa-ellipsis-v"></i>
      </button>
      <div class="action-menu">
        <button class="action-menu-item print-action" onclick="printInvoice(event, '${orderid}')">
          <i class="fa fa-print"></i>
          <span>Print</span>
        </button>
        <button class="action-menu-item download-action" onclick="downloadInvoice(event, '${orderid}')">
          <i class="fa fa-download"></i>
          <span>Download PDF</span>
        </button>        
        <a href="editproinv?orderid=${orderid}" class="action-menu-item edit-action" onclick="event.stopPropagation()">
          <i class="fa fa-pencil"></i>
          <span>Edit</span>
        </a>
        <button class="action-menu-item delete-action" onclick="deleteInvoice(event, '${orderid}')">
          <i class="fa fa-trash"></i>
          <span>Delete</span>
        </button>
      </div>
    </div>
  `;
}

// Toggle action menu
function toggleActionMenu(event, button) {
  event.preventDefault();
  event.stopPropagation();
  
  // Close all other menus
  document.querySelectorAll('.action-menu').forEach(menu => {
    if (menu !== button.nextElementSibling) {
      menu.classList.remove('show');
    }
  });
  
  // Toggle current menu
  button.nextElementSibling.classList.toggle('show');
}

// Print invoice
function printInvoice(event, orderid) {
  event.preventDefault();
  event.stopPropagation();
  
  // Close dropdown
  event.target.closest('.action-menu').classList.remove('show');
  
  // Open print page in new window
  window.open(base_url + '/proinv/printproinv?orderid=' + orderid, '_blank');
}

// Download invoice as PDF - Fixed version
function downloadInvoice(event, orderid) {
  event.preventDefault();
  event.stopPropagation();
  
  // Close dropdown
  event.target.closest('.action-menu').classList.remove('show');
  
  // Show loading notification
  Swal.fire({
    title: 'Preparing Download...',
    text: 'Your invoice is being generated',
    icon: 'info',
    allowOutsideClick: false,
    showConfirmButton: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });
  
  // Create a temporary link for download
  const downloadUrl = base_url + '/proinv/downloadpdf?orderid=' + orderid;
  
  // Try using fetch first to check if the request is successful
  fetch(downloadUrl, {
    method: 'GET',
    headers: {
      'Accept': 'application/pdf',
      'Content-Type': 'application/pdf'
    }
  })
  .then(response => {
    console.log('Response status:', response.status);
    console.log('Response headers:', response.headers);
    
    if (!response.ok) {
      // If response is not ok, try to parse as JSON for error message
      return response.text().then(text => {
        try {
          const errorData = JSON.parse(text);
          throw new Error(errorData.message || 'Download failed');
        } catch (e) {
          throw new Error('Server error: ' + response.status + ' - ' + text);
        }
      });
    }
    
    // Check if response is actually a PDF
    const contentType = response.headers.get('content-type');
    if (!contentType || !contentType.includes('application/pdf')) {
      return response.text().then(text => {
        console.log('Non-PDF response:', text);
        try {
          const errorData = JSON.parse(text);
          throw new Error(errorData.message || 'Invalid response format');
        } catch (e) {
          throw new Error('Expected PDF but got: ' + contentType);
        }
      });
    }
    
    return response.blob();
  })
  .then(blob => {
    // Close loading message
    Swal.close();
    
    // Create blob URL and trigger download
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.style.display = 'none';
    a.href = url;
    
    // Generate filename
    const filename = 'Proforma_Invoice_' + orderid + '.pdf';
    a.download = filename;
    
    document.body.appendChild(a);
    a.click();
    
    // Cleanup
    setTimeout(() => {
      window.URL.revokeObjectURL(url);
      document.body.removeChild(a);
    }, 100);
    
    // Show success message
    Swal.fire({
      title: 'Downloaded!',
      text: 'Invoice downloaded successfully',
      icon: 'success',
      timer: 2000,
      showConfirmButton: false
    });
  })
  .catch(error => {
    console.error('Download error details:', error);
    
    Swal.fire({
      title: 'Download Failed',
      text: error.message || 'Could not download the invoice. Please try again.',
      icon: 'error',
      confirmButtonText: 'OK',
      footer: 'Check console for more details'
    });
  });
}

// Delete invoice
function deleteInvoice(event, orderid) {
  event.preventDefault();
  event.stopPropagation();
  
  // Close dropdown
  event.target.closest('.action-menu').classList.remove('show');
  
  Swal.fire({
    title: 'Are you sure?',
    text: "This invoice will be deleted permanently!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!',
    allowOutsideClick: false        
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: base_url + '/proinv/delete/' + orderid,
        type: 'POST',
        dataType: 'json'
      })
      .done(function(response) {
        Swal.fire({
          title: 'Deleted!',
          text: response.message,
          icon: 'success',
          timer: 2000,
          showConfirmButton: false
        });
        loadInvoices(currentPage);
      })
      .fail(function() {
        Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
      });
    }
  });
}

// Function to load invoices based on current filters and page
function loadInvoices(page = 1) {
    currentPage = page;
    
    // Show loading state
    $('#invoiceTableBody').html(`
        <tr>
            <td colspan="7" class="text-center">
                <div class="loading-state">
                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                    <p>Loading invoices...</p>
                </div>
            </td>
        </tr>
    `);
    
    $.ajax({
        url: base_url + '/proinv/showprodata',
        type: 'GET',
        data: { 
          page: page,
          client: currentFilters.client,
          product: currentFilters.product,
          date_from: currentFilters.date_from,
          date_to: currentFilters.date_to
        },
        dataType: 'json',
        success: function(response) {
            if (response.invoices && Array.isArray(response.invoices)) {
                // Sort invoices by created date (latest first)
                response.invoices.sort(function(a, b) {
                    const dateA = new Date(a.created);
                    const dateB = new Date(b.created);
                    
                    if (dateA.getTime() !== dateB.getTime()) {
                        return dateB - dateA;
                    }
                    
                    return (b.invid || '').localeCompare(a.invid || '');
                });
                
                populateListView(response.invoices);
                updatePagination(response.total_records, response.results_per_page, response.current_page);
                updateResultsInfo(response.total_records, response.current_page, response.results_per_page);
            } else {
                showEmptyState();
                $('#pagination').empty();
                updateResultsInfo(0);
            }
        },
        error: function(xhr, status, error) {
            showErrorState();
            $('#pagination').empty();
        } 
    });
}

function populateListView(invoices) {
    const tableBody = $('#invoiceTableBody');
    tableBody.empty();

    invoices.forEach(function(invoice) {
        const row = `
            <tr class="clickable-row" data-orderid="${invoice.orderid}">
                <td><strong>${invoice.invid}</strong></td>
                <td>${invoice.c_name}</td>
                <td>${invoice.location}</td>
                <td>${invoice.item_name}</td>
                <td><strong>${invoice.totalamount}</strong></td>
                <td>${invoice.created}</td>
                <td style="text-align: center;">
                    ${getActionDropdown(invoice.orderid)}
                </td>
            </tr>
        `;
        tableBody.append(row);
    });
}

function showEmptyState() {
    const emptyHTML = `
        <tr>
            <td colspan="7">
                <div class="empty-state">
                    <i class="fa fa-file-text-o"></i>
                    <h3>No Invoices Found</h3>
                    <p>No invoices match your current filter criteria. Try adjusting your filters or clearing them to see all invoices.</p>
                </div>
            </td>
        </tr>
    `;
    $('#invoiceTableBody').html(emptyHTML);
}

function showErrorState() {
    const errorHTML = `
        <tr>
            <td colspan="7">
                <div class="empty-state">
                    <i class="fa fa-exclamation-triangle" style="color: #dc3545;"></i>
                    <h3>Error Loading Invoices</h3>
                    <p>There was a problem loading the invoices. Please try again later.</p>
                </div>
            </td>
        </tr>
    `;
    $('#invoiceTableBody').html(errorHTML);
}

function updatePagination(totalRecords, resultsPerPage, currentPage) {
    const totalPages = Math.max(1, Math.ceil(totalRecords / resultsPerPage));
    const pagination = $('#pagination');
    pagination.empty();

    if (totalPages <= 1) return;

    // Previous button
    if (currentPage > 1) {
        pagination.append(`
            <li class="page-item">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(${currentPage - 1});">
                    <i class="fa fa-chevron-left"></i> Prev
                </a>
            </li>
        `);
    }

    // Page numbers with smart truncation
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (startPage > 1) {
        pagination.append(`<li class="page-item"><a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(1);">1</a></li>`);
        if (startPage > 2) {
            pagination.append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
        }
    }

    for (let i = startPage; i <= endPage; i++) {
        let active = (i === currentPage) ? 'active' : '';
        pagination.append(`
            <li class="page-item ${active}">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(${i});">${i}</a>
            </li>
        `);
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            pagination.append(`<li class="page-item disabled"><span class="page-link">...</span></li>`);
        }
        pagination.append(`<li class="page-item"><a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(${totalPages});">${totalPages}</a></li>`);
    }

    // Next button
    if (currentPage < totalPages) {
        pagination.append(`
            <li class="page-item">
                <a class="page-link" href="#" onclick="event.preventDefault(); loadInvoices(${currentPage + 1});">
                    Next <i class="fa fa-chevron-right"></i>
                </a>
            </li>
        `);
    }
}

function updateResultsInfo(totalRecords, currentPage = 1, resultsPerPage = 10) {
    if (totalRecords > 0) {
        const start = ((currentPage - 1) * resultsPerPage) + 1;
        const end = Math.min(currentPage * resultsPerPage, totalRecords);
        $('#resultsText').text(`Showing ${start}-${end} of ${totalRecords} invoices`);
        $('#resultsInfo').show();
    } else {
        $('#resultsInfo').hide();
    }
}

function updateActiveFilters() {
    const filterTags = $('#filterTags');
    filterTags.empty();
    
    let hasFilters = false;

    Object.keys(currentFilters).forEach(key => {
        const value = currentFilters[key];
        if (value) {
            hasFilters = true;
            let displayValue = value;
            
            // Get display text for select fields
            if (key === 'client') {
                displayValue = $('#client option:selected').text();
            } else if (key === 'product') {
                displayValue = $('#product option:selected').text();
            }
            
            filterTags.append(`
                <span class="filter-tag">
                    ${key.replace('_', ' ')}: ${displayValue}
                    <span class="remove-filter" data-filter="${key}">&times;</span>
                </span>
            `);
        }
    });

    if (hasFilters) {
        $('#activeFilters').show();
    } else {
        $('#activeFilters').hide();
    }
}

// Initialize page
$(document).ready(function() {
    
    // Initialize Select2 for Client
    $('#client').select2({
        placeholder: "Select a client",
        allowClear: true,
        ajax: {
            url: base_url + "/proinv/getclient",
            type: "GET",
            dataType: "json",
            delay: 250,
            data: function(params) {
                return {
                    category_name: params.term || ''
                };
            },
            processResults: function(data) {
                return { results: data };
            },
            cache: true
        }
    });

    // Initialize Select2 for Product
    $('#product').select2({
        placeholder: "Select a product",
        allowClear: true,
        ajax: {
            url: base_url + "/proinv/getproducts",
            type: "GET",
            dataType: "json",
            delay: 250,
            data: function(params) {
                return {
                    category_name: params.term || ''
                };
            },
            processResults: function(data) {
                if (!Array.isArray(data) || data.length === 0) {
                    return { results: [] };
                }
                
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id || item.name,
                            text: item.name || item.text
                        };
                    })
                };
            },
            cache: true
        }
    });

    // Apply filters button
    $('#applyFilters').click(function() {
        currentFilters.client = $('#client').val() || '';
        currentFilters.product = $('#product').val() || '';
        currentFilters.date_from = $('#date_from').val() || '';
        currentFilters.date_to = $('#date_to').val() || '';
        
        updateActiveFilters();
        loadInvoices(1);
    });

    // Clear filters button
    $('#clearFilters').click(function() {
        currentFilters = {
            client: '',
            product: '',
            date_from: '',
            date_to: ''
        };
        
        $('#filterForm')[0].reset();
        $('#client').val('').trigger('change');
        $('#product').val('').trigger('change');
        
        updateActiveFilters();
        loadInvoices(1);
    });

    // Remove individual filter tags
    $(document).on('click', '.remove-filter', function() {
        const filterKey = $(this).data('filter');
        currentFilters[filterKey] = '';
        
        // Clear the form field
        $('#' + filterKey).val('').trigger('change');
        
        updateActiveFilters();
        loadInvoices(1);
    });

    // Auto-apply filters on enter key
    $('#filterForm input').keypress(function(e) {
        if (e.which == 13) {
            $('#applyFilters').click();
            return false;
        }
    });

    // Clickable row functionality - navigate to print page
    $(document).on('click', '.clickable-row', function(e) {
        // Don't trigger if clicking on action dropdown
        if ($(e.target).closest('.action-dropdown, .action-menu').length > 0) {
            return;
        }
        
        const orderId = $(this).data('orderid');
        if (orderId) {
            window.open(base_url + '/proinv/printproinv?orderid=' + orderId, '_blank');
        }
    });

    // Load initial invoices
    loadInvoices(1);
});

</script>

</body>
</html>