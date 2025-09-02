<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Advanced form elements</title>

<?= $this->include('Include/links.php');?>

 
<style type="text/css">
  img {
    image-rendering: -webkit-optimize-contrast !important;
  }
  
  .filter-card {
    background: #f9f9f9;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .filter-title {
    color: #3c8dbc;
    font-weight: 600;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  
  .filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: end;
  }
  
  .filter-group {
    flex: 1;
    min-width: 200px;
  }
  
  .filter-actions {
    display: flex;
    gap: 10px;
    align-items: end;
  }
  
  .btn-filter {
    background: linear-gradient(45deg, #3c8dbc, #5bc0de);
    border: none;
    color: white;
    padding: 8px 20px;
    border-radius: 4px;
    transition: all 0.3s;
  }
  
  .btn-filter:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  }
  
  .btn-clear {
    background: #f39c12;
    border: none;
    color: white;
    padding: 8px 20px;
    border-radius: 4px;
    transition: all 0.3s;
  }
  
  .btn-clear:hover {
    background: #e67e22;
    transform: translateY(-1px);
  }
  
  .active-filters {
    margin-top: 10px;
    display: none;
  }
  
  .filter-tag {
    display: inline-block;
    background: #3c8dbc;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    margin: 2px;
    font-size: 12px;
  }
  
  .filter-tag .remove-filter {
    margin-left: 8px;
    cursor: pointer;
    color: #fff;
    opacity: 0.8;
  }
  
  .filter-tag .remove-filter:hover {
    opacity: 1;
  }
  
  .results-info {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    border-radius: 4px;
    padding: 10px 15px;
    margin-bottom: 15px;
    color: #155724;
  }
  
  @media (max-width: 768px) {
    .filter-row {
      flex-direction: column;
    }
    
    .filter-group {
      width: 100%;
    }
    
    .filter-actions {
      width: 100%;
      justify-content: flex-start;
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

      <div class="row">
        <div class="col-xs-12">
          
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
                  <button type="button" id="applyFilters" class="btn btn-filter">
                    <i class="fa fa-search"></i> Filter
                  </button>
                  <button type="button" id="clearFilters" class="btn btn-clear">
                    <i class="fa fa-refresh"></i> Clear
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

        </div>
      </div>

      <!-- Results Info -->
      <div class="row" id="resultsInfo" style="display: none;">
        <div class="col-xs-12">
          <div class="results-info">
            <i class="fa fa-info-circle"></i>
            <span id="resultsText"></span>
          </div>
        </div>
      </div>

      <!-- Invoice Cards -->
      <div class="row">
        <div class="col-md-12">
          <div class="content-panel">
            <div id="tinvoices" name="tinvoices" class="row">
              <!-- Invoices will be loaded here -->
            </div>

            <!-- Pagination -->
            <div class="page" style="text-align: center;">
              <nav aria-label="Page navigation example">
                <ul id="pagination" class="pagination"></ul>
              </nav>
            </div>
          </div>
        </div>
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

// Function to load invoices based on current filters and page
function loadInvoices(page = 1) {
    currentPage = page;
    
    // Show loading state
    $('#tinvoices').html('<div class="col-md-12 text-center"><i class="fa fa-spinner fa-spin fa-3x"></i><p>Loading invoices...</p></div>');
    
    console.log("Loading invoices for page: " + page);
    
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
                $('#tinvoices').empty();

                response.invoices.forEach(function(invoice) {
                    var html = `
                        <div class="col-md-4" id="example1">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">${invoice.invid}</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <strong><p align="center" style="color:black;">${invoice.c_name}</p></strong>
                                        <p align="center"><strong>Location:</strong> ${invoice.location}</p>
                                        <p align="center"><strong>Item name:</strong> ${invoice.item_name}</p>
                                        <p align="center"><strong>Total Bill:</strong> ${invoice.totalamount}</p>
                                        <p align="center"><strong>Invoice Dated:</strong> ${invoice.created}</p>
                                        <br/>
                                        <div class="text-center">
                                            <a href="printproinv?orderid=${invoice.orderid}" target="_blank" class="btn btn-info btn-xs">
                                                <i class="fa fa-print"></i> Print
                                            </a>
                                            <a href="editproinv?orderid=${invoice.orderid}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a class="btn btn-danger btn-xs" id="delete_product" data-id="${invoice.orderid}">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>`;
                    $('#tinvoices').append(html);
                });

                // Update pagination and results info
                updatePagination(response.total_records, response.results_per_page, response.current_page);
                updateResultsInfo(response.total_records, response.current_page, response.results_per_page);
            } else {
                $('#tinvoices').html('<div class="col-md-12 text-center"><div class="alert alert-info"><i class="fa fa-info-circle"></i> No invoices found matching your criteria.</div></div>');
                $('#pagination').empty();
                updateResultsInfo(0);
            }
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
            $('#tinvoices').html('<div class="col-md-12 text-center"><div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error loading invoices. Please try again.</div></div>');
            $('#pagination').empty();
        } 
    });
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

    // Delete functionality
    $(document).on('click', '#delete_product', function(e) {
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

    // Load initial invoices
    loadInvoices(1);
});

</script>

</body>
</html>