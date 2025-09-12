<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EMAX | Advanced form elements</title>
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
  
  .filter-title {
    color: #2c3e50;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  
  .filter-title i {
    color: #3c8dbc;
    font-size: 20px;
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
  
  /* View Toggle */
  .view-controls {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
  }
  
  .view-toggle {
    display: flex;
    background: #f8f9fa;
    border-radius: 10px;
    padding: 4px;
    border: 2px solid #e9ecef;
  }
  
  .view-btn {
    padding: 10px 16px;
    border: none;
    background: transparent;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
  }
  
  .view-btn.active {
    background: #3c8dbc;
    color: white;
    box-shadow: 0 2px 8px rgba(60, 141, 188, 0.2);
  }
  
  .view-btn:hover:not(.active) {
    background: #e9ecef;
    color: #495057;
  }
  
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
  }
  
  /* Enhanced Card View */
  .card-view .invoice-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: none;
    overflow: hidden;
    margin-bottom: 20px;
    height: 320px; /* Fixed height for consistent card sizing */
    display: flex;
    flex-direction: column;
  }
  
  .card-view .invoice-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  }
  
  .clickable-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    background-color: #f8f9fa;
  }
  
  .clickable-row:hover {
    background-color: #f8f9fa;
  }
  
  .card-view .invoice-card .card-header {
    background: linear-gradient(135deg, #3c8dbc 0%, #5bc0de 100%);
    color: white;
    padding: 15px 20px;
    border-bottom: none;
  }
  
  .card-view .invoice-card .card-header h3 {
    margin: 0;
    font-weight: 700;
    font-size: 16px;
  }
  
  .card-view .invoice-card .card-body {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  
  .card-view .invoice-info {
    margin-bottom: 15px;
    flex: 1;
    overflow: hidden;
  }
  
  .card-view .invoice-info p {
    margin: 6px 0;
    font-size: 13px;
    color: #495057;
    line-height: 1.4;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  .card-view .invoice-info strong {
    color: #2c3e50;
    font-weight: 600;
  }
  
  .card-view .card-actions {
    display: flex;
    gap: 8px;
    justify-content: center;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
    flex-shrink: 0;
    margin-top: auto;
  }
  
  .card-view .btn-action {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  
  /* Card View Grid */
  .card-view .row {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin: 0;
  }
  
  .card-view .col-md-4 {
    width: 100%;
    padding: 0;
  }

  /* List View */
  .list-view {
    display: none;
  }
  
  .list-view.active {
    display: block;
  }

  /* Card View */
  .card-view {
    display: none;
  }
  
  .card-view.active {
    display: block;
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
  
  .table-actions {
    display: flex;
    gap: 8px;
  }
  
  .table-actions .btn-action {
    padding: 4px 8px;
    border: none;
    border-radius: 4px;
    font-size: 11px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  
  .btn-print {
    background: #17a2b8;
    color: white;
  }
  
  .btn-print:hover {
    background: #138496;
    color: white;
  }
  
  .btn-edit {
    background: #007bff;
    color: white;
  }
  
  .btn-edit:hover {
    background: #0056b3;
    color: white;
  }
  
  .btn-delete {
    background: #dc3545;
    color: white;
  }
  
  .btn-delete:hover {
    background: #c82333;
    color: white;
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
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .filter-row {
      grid-template-columns: 1fr;
    }
    
    .view-controls {
      flex-direction: column;
      align-items: stretch;
    }
    
    .view-toggle {
      width: 100%;
      justify-content: center;
    }
    
    .invoice-table {
      overflow-x: auto;
    }
    
    .card-view .row {
      grid-template-columns: 1fr;
    }
    
    .card-view .col-md-4 {
      width: 100%;
    }
    
    .card-view .invoice-card {
      height: 280px;
    }
  }
  
  @media (min-width: 769px) and (max-width: 1200px) {
    .card-view .row {
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
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
        <div class="filter-title">
          <i class="fa fa-filter"></i>
          Smart Filters
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

      <!-- View Controls -->
      <div class="view-controls">
        <div class="results-info" id="resultsInfo" style="display: none;">
          <i class="fa fa-info-circle"></i>
          <span id="resultsText"></span>
        </div>
        
        <div class="view-toggle">
          <button class="view-btn active" id="listViewBtn">
            <i class="fa fa-list"></i>
          </button>
          <button class="view-btn" id="cardViewBtn">
            <i class="fa fa-th-large"></i>
          </button>
        </div>
      </div>

      <!-- List View -->
      <div class="list-view active" id="listView">
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
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="invoiceTableBody">
              <!-- Table rows will be populated here -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Card View -->
      <div class="card-view" id="cardView">
        <div class="row" id="tinvoices">
          <!-- Invoice cards will be loaded here -->
        </div>
      </div>

      <!-- Pagination -->
      <div class="pagination-wrapper">
        <nav aria-label="Page navigation">
          <ul id="pagination" class="pagination"></ul>
        </nav>
      </div>
      
    </section>

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
let currentView = 'list'; // 'list' or 'card'

// Function to load invoices based on current filters and page
function loadInvoices(page = 1) {
    currentPage = page;
    
    // Show loading state
    if (currentView === 'list') {
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
    } else {
        $('#tinvoices').html(`
            <div class="col-md-12">
                <div class="loading-state">
                    <i class="fa fa-spinner fa-spin fa-3x"></i>
                    <p>Loading invoices...</p>
                </div>
            </div>
        `);
    }
    
    console.log("Loading invoices for page: " + page);
    console.log("Current filters:", currentFilters);
    
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
            console.log("Response received:", response);
            if (response.invoices && Array.isArray(response.invoices)) {
                // Sort invoices by created date (latest first) as additional safety
                response.invoices.sort(function(a, b) {
                    const dateA = new Date(a.created);
                    const dateB = new Date(b.created);
                    
                    // First sort by date (latest first)
                    if (dateA.getTime() !== dateB.getTime()) {
                        return dateB - dateA;
                    }
                    
                    // If dates are the same, sort by invoice ID (highest first)
                    return (b.invid || '').localeCompare(a.invid || '');
                });
                
                console.log("Sorted invoices:", response.invoices.map(inv => ({id: inv.invid, created: inv.created})));
                
                if (currentView === 'list') {
                    populateListView(response.invoices);
                } else {
                    populateCardView(response.invoices);
                }

                // Update pagination and results info
                updatePagination(response.total_records, response.results_per_page, response.current_page);
                updateResultsInfo(response.total_records, response.current_page, response.results_per_page);
            } else {
                showEmptyState();
                $('#pagination').empty();
                updateResultsInfo(0);
            }
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
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
            <tr class="clickable-row" data-orderid="${invoice.orderid}" style="cursor: pointer;">
                <td><strong>${invoice.invid}</strong></td>
                <td>${invoice.c_name}</td>
                <td>${invoice.location}</td>
                <td>${invoice.item_name}</td>
                <td><strong>${invoice.totalamount}</strong></td>
                <td>${invoice.created}</td>
                <td>
                    <div class="table-actions">
                        <button class="btn-action btn-print" data-orderid="${invoice.orderid}" title="Print Invoice">
                            <i class="fa fa-print"></i> Print
                        </button>
                        <a href="editproinv?orderid=${invoice.orderid}" class="btn-action btn-edit" title="Edit Invoice">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <button class="btn-action btn-delete" data-id="${invoice.orderid}" title="Delete Invoice">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>
        `;
        tableBody.append(row);
    });
}

function populateCardView(invoices) {
    $('#tinvoices').empty();

    invoices.forEach(function(invoice) {
        // Truncate long text to prevent card overflow
        const truncateText = (text, maxLength = 20) => {
            return text && text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
        };

        const card = `
            <div class="col-md-4">
                <div class="invoice-card clickable-card" data-orderid="${invoice.orderid}" style="cursor: pointer;">
                    <div class="card-header">
                        <h3>${invoice.invid || 'N/A'}</h3>
                    </div>
                    <div class="card-body">
                        <div class="invoice-info">
                            <p><strong>Client:</strong> ${truncateText(invoice.c_name || 'N/A', 25)}</p>
                            <p><strong>Location:</strong> ${truncateText(invoice.location || 'N/A', 25)}</p>
                            <p><strong>Product:</strong> ${truncateText(invoice.item_name || 'N/A', 25)}</p>
                            <p><strong>Total Amount:</strong> ${invoice.totalamount || 'N/A'}</p>
                            <p><strong>Invoice Date:</strong> ${invoice.created || 'N/A'}</p>
                        </div>
                        <div class="card-actions">
                            <button class="btn-action btn-print" data-orderid="${invoice.orderid}" title="Print Invoice">
                                <i class="fa fa-print"></i> Print
                            </button>
                            <a href="editproinv?orderid=${invoice.orderid}" class="btn-action btn-edit" title="Edit Invoice">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                            <button class="btn-action btn-delete" data-id="${invoice.orderid}" title="Delete Invoice">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('#tinvoices').append(card);
    });
}

function showEmptyState() {
    const emptyHTML = `
        <div class="col-md-12">
            <div class="empty-state">
                <i class="fa fa-file-text-o"></i>
                <h3>No Invoices Found</h3>
                <p>No invoices match your current filter criteria. Try adjusting your filters or clearing them to see all invoices.</p>
            </div>
        </div>
    `;
    
    if (currentView === 'list') {
        $('#invoiceTableBody').html(`
            <tr>
                <td colspan="7">
                    ${emptyHTML}
                </td>
            </tr>
        `);
    } else {
        $('#tinvoices').html(emptyHTML);
    }
}

function showErrorState() {
    const errorHTML = `
        <div class="col-md-12">
            <div class="empty-state">
                <i class="fa fa-exclamation-triangle" style="color: #dc3545;"></i>
                <h3>Error Loading Invoices</h3>
                <p>There was a problem loading the invoices. Please try again later.</p>
            </div>
        </div>
    `;
    
    if (currentView === 'list') {
        $('#invoiceTableBody').html(`
            <tr>
                <td colspan="7">
                    ${errorHTML}
                </td>
            </tr>
        `);
    } else {
        $('#tinvoices').html(errorHTML);
    }
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

    // View Toggle Functionality
    $('#listViewBtn').click(function() {
        if (currentView !== 'list') {
            currentView = 'list';
            $('.view-btn').removeClass('active');
            $(this).addClass('active');
            
            $('#cardView').removeClass('active');
            $('#listView').addClass('active');
            
            // Reload data for list view
            loadInvoices(currentPage);
        }
    });

    $('#cardViewBtn').click(function() {
        if (currentView !== 'card') {
            currentView = 'card';
            $('.view-btn').removeClass('active');
            $(this).addClass('active');
            
            $('#listView').removeClass('active');
            $('#cardView').addClass('active');
            
            // Reload data for card view
            loadInvoices(currentPage);
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

    // Delete functionality
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var productId = $(this).data('id');

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
                    url: base_url + '/proinv/delete/' + productId,
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
    });

    // Clickable card/row functionality - navigate to print page
    $(document).on('click', '.clickable-card, .clickable-row', function(e) {
        // Don't trigger if clicking on action buttons or links
        if ($(e.target).closest('.card-actions, .table-actions, .btn-action, a').length > 0) {
            return;
        }
        
        const orderId = $(this).data('orderid');
        if (orderId) {
            window.open('printproinv?orderid=' + orderId, '_blank');
        }
    });

    // Print button functionality - trigger browser print dialog
    $(document).on('click', '.btn-print', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const orderId = $(this).data('orderid');
        if (orderId) {
            // Open print page in new window and trigger print dialog
            const printWindow = window.open('printproinv?orderid=' + orderId, '_blank');
            
            // Wait for the page to load, then trigger print
            printWindow.onload = function() {
                printWindow.print();
            };
        }
    });

    // Load initial invoices
    loadInvoices(1);
});

</script>

</body>
</html>