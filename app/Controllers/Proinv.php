<?php

namespace App\Controllers;

use App\Models\Purchaseinv_model;


use App\Models\Purchaseinv_model2;

use App\Models\Protest_model2;
use App\Models\Protest_model;

use App\Models\Client_model;

use App\Models\Product_model;
 // Ensure you have the correct namespace for your model
use CodeIgniter\Controller;

use CodeIgniter\Database\Database;
use App\Models\Admin_model;
use App\Models\Bank_model;

class Proinv extends Controller
{
    protected $crudModel;

    public function __construct()
    {
        $this->crudModel = new Protest_model(); // Load model
        helper(['url', 'navigation', 'session_safe']);
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function genproinv()
  {


    $db = \Config\Database::connect();

    $session = session(); 

    if ($session->has('user_id')) {
            //echo "User ID: " . $session->get('user_id');
        } else {
            return redirect()->to(base_url().'/login');
        }

            
        if (date('m') > 3) {
            $year = date('y') . "-" . (date('y') + 1);
        } else {
            $year = (date('y') - 1) . "-" . date('y');
        }

        $date = date('Y-m-d');


        // Simple query to get the next invoice ID
        $datalogger = "SELECT COUNT(*) as count FROM protest2 WHERE invid LIKE 'PI/$year/%'";
        
        // Execute the query
        $stmt = $db->query($datalogger);
        $row = $stmt->getRow();

        // Determine the invoice number
        if ($row && $row->count > 0) {
            $nextNumber = $row->count + 1;
            $value = "PI/" . $year . "/" . sprintf('%04d', $nextNumber);
        } else {
            // No records found, start from 0001
            $value = "PI/" . $year . "/0001";
        }

        // Return the generated invoice ID (you can return it as JSON or any format you prefer)
        //return $this->response->setJSON(['invoice_id' => $value]);
    
    // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {
        //return $this->response->setJSON(['invoice_id' => $value]);
    }

    // Load bank data for dropdown
    $bankModel = new \App\Models\Bank_model();
    $banks = $bankModel->findAll();
    
    return view('layout/genproinv',[
        'invoice_id' => $value,
        'banks' => $banks
    ]);      
    //return view('layout/genpurchaseinvoice.php');
}




public function editproinv()
    {
        if ($this->request->getMethod() === 'get' || $this->request->isAJAX()) {  // Corrected to use $this->request->isAJAX()

          
            
        $edit_id = $this->request->getGet('orderid');  // Corrected to use $this->request->getGet()

        $this->crudModel3 = new Protest_model();
     
       $records = $this->crudModel3-> where ('orderid',$edit_id)->findAll();


       $this->crudModel4 = new Protest_model2();
     
        $builder = $this->crudModel4->db->table('protest2'); // Assuming 'quote2' is your table
        $builder->select('protest2.*, client.c_name,client.c_add'); // Select all columns from quote2 and c_name from client
        $builder->join('client', 'protest2.cid = client.cid', 'inner'); // Perform inner join
        $builder->where('protest2.orderid', $edit_id); // Add where 
        $records2 = $builder->get()->getResultArray(); // Fetch the result as an array

          
          // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {

           return $this->response->setJSON([
        'records' => $records,
        'records2' => $records2,
    ]);
}
    

    $data = [
        'records' => json_encode($records),
        'records2' => json_encode($records2),
    ];

    return view('edit layout/editproinv', $data);
    }
}



public function updateproinv()
{
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

        $this->crudModel4 = new Protest_model2(); // Load model
        $this->crudModel = new Protest_model(); // Load model

        $orderid = $this->request->getPost('orderid');

        $invid = $this->request->getPost('invid');
        $supplier = $this->request->getPost('supplier');
        $datepicker = $this->request->getPost('datepicker');
        $subtotal = $this->request->getPost('subTotal');
        $taxrate = $this->request->getPost('taxRate');
        $taxamount = $this->request->getPost('taxAmount');
        $totalaftertax = $this->request->getPost('totalAftertax');

        $itemNames = $this->request->getPost('item_name'); // Array
        $itemDescs = $this->request->getPost('item_desc'); // Array
        $hsn = $this->request->getPost('hsn'); // Array
        $quantities = $this->request->getPost('item_quantity'); // Array
        $prices = $this->request->getPost('price'); // Array
        $totals = $this->request->getPost('total'); // Array

         $dateParts = explode('-', $datepicker);
    if (count($dateParts) === 3) {
        $formattedDate = (new \DateTime("{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}"))->format('Y-m-d');
    } else {
        throw new \Exception('Invalid date format');
    }

        // Prepare data for updating main invoice
        $updateData = [
            'invid' => $invid,
            'cid' => $supplier,
            'totalitems' => count($itemNames),
            'subtotal' => $subtotal,
            'taxrate' => $taxrate,
            'taxamount' => $taxamount,
            'totalamount' => $totalaftertax,
            'created' => $formattedDate
        ];

        $itemData = [];
        if (!empty($itemNames) && is_array($itemNames)) {
            for ($i = 0; $i < count($itemNames); $i++) {
                if (!empty($itemNames[$i])) {
                    $itemData[] = [
                        'orderno'=> null,
                        'orderid' => $orderid,
                        'item_name' => $itemNames[$i],
                        'item_desc' => !empty($itemDescs[$i]) ? $itemDescs[$i] : null,
                        'hsn' => (isset($hsn[$i]) && !empty($hsn[$i])) ? $hsn[$i] : (8443 + $i),
                        'quantity' => !empty($quantities[$i]) ? $quantities[$i] : null,
                        'price' => !empty($prices[$i]) ? $prices[$i] : null,
                        'total' => !empty($totals[$i]) ? $totals[$i] : null,
                    ];
                }
            }
        }

        // Update the main invoice
        $mainUpdate = $this->crudModel4->updaterecord(['orderid' => $orderid], $updateData);
        
        // Always update items by deleting old and inserting new
        $this->crudModel->deleterecord($orderid);
        $itemsInsert = $this->crudModel->insertBatch($itemData);

        if ($mainUpdate && $itemsInsert) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Proforma Invoice updated successfully!',
                'orderid' => $orderid,
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update invoice.',
            ]);
        }
    }
    
    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
}


// In your get_next_id controller method
public function get_next_id()
{
    try {
        // Your logic to get the next ID
        $next_id = $this->crudModel->get_last_cid(); // Adjust this line based on your logic
        return $this->response->setJSON(['next_id' => $next_id]);
    } catch (Exception $e) {
        log_message('error', 'Failed to get next ID: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to fetch next ID.']);
    }
}



public function getclient()
{
    $this->crudModel2 = new Client_model();
    
    // Handle single client request
    $clientId = $this->request->getGet('client_id');
    if ($clientId) {
        $client = $this->crudModel2->find($clientId);
        if ($client) {
            return $this->response->setJSON([[
                'id' => $client['cid'],
                'text' => $client['c_name'],
                'c_add' => $client['c_add']
            ]]);
        }
    }
    
    $categoryName = $this->request->getGet('category_name');
    $results = [];

    if ($categoryName) {
        // Use a LIKE query with wildcards for partial matching
        $clients = $this->crudModel2
                        ->like('c_name', $categoryName, 'both') // 'both' allows matches from any part of the string
                        ->findAll();
    } else {
        // If no specific category name is provided, retrieve all clients
        $clients = $this->crudModel2->findAll();
    }

    // Format the results for Select2
    foreach ($clients as $client) {
        $results[] = [
            'id' => $client['cid'],
            'text' => $client['c_name'],
            'c_add' => $client['c_add']
        ];
    }

    return $this->response->setJSON($results);
    
}

public function savebank()
{
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {
        $bankModel = new Bank_model();
        
        // Get form data
        $bname = $this->request->getPost('bname');
        $ac = $this->request->getPost('ac');
        $ifsc = $this->request->getPost('ifsc');
        $account_name = $this->request->getPost('account_name');
        
        // Validate required fields
        if (!$bname || !$ac || !$ifsc) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Bank name, account number, and bank code are required'
            ]);
        }
        
        // Use account_name as branch if provided, otherwise use a default
        $branch = $account_name ? $account_name : 'Main Branch';
        
        $data = [
            'bname' => $bname,
            'ac' => $ac,
            'ifsc' => $ifsc,
            'branch' => $branch
        ];
        
        try {
            if ($bankModel->insert($data)) {
                $insertId = $bankModel->getInsertID();
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Bank details saved successfully',
                    'bank_id' => $insertId
                ]);
            } else {
                $errors = $bankModel->errors();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save bank details: ' . implode(', ', $errors)
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    
    return $this->response->setJSON([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}

public function proreport(){



        return view('report/proforma_report');
    }


   public function loadInvoices()
  {
    // Retrieve GET parameters

    $daterange= $this->request->getGet('date')?? '';

             // Split the date range using the '-' separator
    $dates = explode(' - ', $daterange);

    // Check if two dates are present
    if (count($dates) == 2) {
        $startDate = date('Y-m-d', strtotime(trim($dates[0]))); // Convert to Y-m-d format
        $endDate = date('Y-m-d', strtotime(trim($dates[1])));   // Convert to Y-m-d format
    } else {
        $startDate = $endDate = null; // If date range is invalid, set both to null
    }
      

    //$item = $this->request->getGet('item_name');
    //$customer = $this->request->getGet('client');
     $customer = is_numeric($this->request->getGet('client')) ? $this->request->getGet('client') : null;

     //$ctype-$this->request->getGet('ctype');   
        $ctype = $this->request->getPost('ctype') ?? 'null';

    // Call the model function
    $this->crudModel = new Protest_model2();

    $invoices = $this->crudModel->getInvoices($startDate, $endDate,null, $customer,$ctype);

    $totalSubtotal = 0;
    $totalTaxAmount = 0;
    $totalAmount = 0;

    // Loop through each invoice and calculate totals
    foreach ($invoices as $invoice) {
        $totalSubtotal += $invoice->subtotal;
        $totalTaxAmount += $invoice->taxamount;
        $totalAmount += $invoice->totalamount;
    }

    // Create the result array with totals
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($invoices),
        "iTotalDisplayRecords" => count($invoices),
        "aaData" => $invoices,
        "totalSubtotal" => $totalSubtotal,
        "totalTaxAmount" => $totalTaxAmount,
        "totalAmount" => $totalAmount
    ];



    //print_r($invoices);

    // Check if data exists
    if (!empty($invoices)) {
        $response = [
            'success' => true,
            'data' => $results,
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'No invoices found for the selected filters.',
        ];
    }

    // Return the response as JSON
    return $this->response->setJSON($results);
}

public function loaditems()
  {

    $daterange = $this->request->getGet('date') ?? '';

    // Initialize date variables
    $startDate = $endDate = null;

    // Split and process the date range
    if (!empty($daterange)) {
        $dates = explode(' - ', $daterange);
        if (count($dates) == 2) {
            $startDate = date('Y-m-d', strtotime(trim($dates[0])));
            $endDate = date('Y-m-d', strtotime(trim($dates[1])));
        }
    }

    // Get the item name from GET request
    $item = $this->request->getGet('item') ?? null;
    

    // Call the model function
    $this->crudModel = new Protest_model2();

    $invoices = $this->crudModel->getItemreport($startDate, $endDate,$item);



    // Initialize totals
    $totalSubtotal = 0;
    $totalTaxAmount = 0;
    $totalAmount = 0;
    $totalQuantity = 0;
    $totalPrice = 0;
    // Loop through each invoice and calculate totals
    foreach ($invoices as $invoice) {
        $totalPrice += $invoice->price;
        $totalQuantity += $invoice->quantity;
        $totalSubtotal += $invoice->subtotal;
         $totalTaxAmount += $invoice->taxamount;
        $totalAmount += $invoice->totalamount;
    }


    // Create the result array with totals
    $results = [
        "sEcho" => 1,
        "iTotalRecords" => count($invoices),
        "iTotalDisplayRecords" => count($invoices),
        "aaData" => $invoices,
        "totalPrice" => $totalPrice,
        "totalQuantity" => $totalQuantity,
        "totalSubtotal" => $totalSubtotal,
        "totalTaxAmount" => $totalTaxAmount,
        "totalAmount" => $totalAmount
    ];



    //print_r($invoices);

    // Check if data exists
    if (!empty($invoices)) {
        $response = [
            'success' => true,
            'data' => $results,
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'No invoices found for the selected filters.',
        ];
    }

    // Return the response as JSON
    return $this->response->setJSON($results);
}


     public function proitemreport(){
        return view('report/proitem_report');
    }
    
public function getproducts()
{
    $this->crudModel3 = new Product_model();
    $categoryName = $this->request->getGet('category_name');
    $results = [];

    if ($categoryName) {
        // Use a LIKE query with wildcards for partial matching
        $products = $this->crudModel3
                        ->like('name', $categoryName, 'both')
                        ->findAll();
    } else {
        // If no specific category name is provided, retrieve all products (limit to reasonable number)
        $products = $this->crudModel3->findAll(50); // Limit to 50 items for performance
    }

    // Format the results for Select2 - CRITICAL: Use 'id' and 'text' for Select2
    foreach ($products as $row) {
        $results[] = [
            'id' => $row['name'], // Use product name as the value (this is what gets selected)
            'text' => $row['name'], // This is what's displayed in the dropdown
            'hsn' => $row['hsn'], // Additional data for HSN
            'description' => $row['description'] // Additional data for description
        ];
    }

    // Always return JSON for AJAX requests
    return $this->response->setJSON($results);
}
public function getproducthsn()
{
    $this->crudModel3 = new Product_model();
    
    // Get the product ID from the request
    $productId = $this->request->getGet('q'); // Adjust to match your AJAX request parameter name
    
    $results = [];

    if ($productId) {
        // Query to fetch the HSN code for the specific product by its ID
        $product = $this->crudModel3->where('name', $productId)->first();

        if ($product) {
            // Return the HSN code if the product is found
            $results['hsn'] = $product['hsn'];
        } else {
            $results['hsn'] = ''; // If no product is found, return an empty value
        }
    } else {
        $results['hsn'] = ''; // No product ID provided, return an empty value
    }

    // Log the SQL query for debugging (optional)
    //log_message('debug', $this->crudModel3->getLastQuery());

    // Return the response as JSON
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }

    // Fallback: empty response if not an AJAX request
    return $this->response->setJSON($results);
}

public function saveitem()
{
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {
        $productModel = new Product_model();
        
        // Get form data
        $itemName = $this->request->getPost('item_name');
        $hsn = $this->request->getPost('hsn');
        $description = $this->request->getPost('description');
        
        // Validate required fields
        if (!$itemName) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Item name is required'
            ]);
        }
        
        // Check if item already exists
        $existingItem = $productModel->where('name', $itemName)->first();
        if ($existingItem) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Item with this name already exists'
            ]);
        }
        
        // Prepare data for insertion
        $data = [
            'name' => $itemName,
            'hsn' => $hsn ? $hsn : (8443 + time() % 1000), // Auto-generate unique HSN
            'description' => $description ? $description : '',
            'p_type' => 'General', // Default product type
            'created' => date('Y-m-d')
        ];
        
        try {
            // Insert the item
            if ($productModel->insert($data)) {
                $insertId = $productModel->getInsertID();
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Item saved successfully',
                    'item_id' => $insertId
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save item'
                ]);
            }
        } catch (Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
    
    return $this->response->setJSON([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}

public function showprodata()
{
    // Get the selected year from request, if any
    $selectedYear = $this->request->getVar('year');
    $selectedClient = $this->request->getVar('client');
    $selectedProduct = $this->request->getVar('product');
    
    // Initialize start and end year variables
    $startyear = null;
    $endyear = null;
    
    // Only apply year filtering if a specific year is selected
    if ($selectedYear !== null && $selectedYear !== '') {
        // Fix: Correct substring extraction for financial year format "XX-YY"
        $startyear = substr($selectedYear, 0, 2);  // Get first 2 characters
        $endyear = substr($selectedYear, 3, 2);   // Get last 2 characters (skip the dash)
    }
    // If no year is selected, don't apply any year filtering (show all records)

    // Initialize filters array
    $filters = [];

    // Build the filters for client and product
    if ($selectedClient !== null && $selectedClient !== '') {
        $filters['client'] = $selectedClient;
    }

    if ($selectedProduct !== null && $selectedProduct !== '') {
        $filters['product'] = $selectedProduct;
    }

    // Pagination logic
    $results_per_page = 20; // Number of results per page
    $page = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1; // Current page
    $offset = ($page - 1) * $results_per_page;

    // Load the model
    $protest_model2 = new Protest_model2();

    // Fetch filtered data - pass null for years if no specific year selected
    $invoices = $protest_model2->getprotest(
        $startyear, 
        $endyear, 
        $selectedClient, 
        $selectedProduct, 
        $results_per_page, 
        $offset
    );

    // Log the query for debugging
    log_message('debug', $protest_model2->db->getLastQuery()->getQuery());

    // Count total number of records for pagination
    $total_records = $protest_model2->countAllInvoices(
        $startyear, 
        $endyear, 
        $selectedClient, 
        $selectedProduct
    );

    // Log the total record count query for debugging
    log_message('debug', $protest_model2->db->getLastQuery()->getQuery());

    // Prepare data to return
    $data = [
        'invoices' => $invoices,
        'total_records' => $total_records,
        'results_per_page' => $results_per_page,
        'current_page' => $page
    ];

    // Return data as JSON if it's an AJAX request
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($data);
    }

    // Load the view for non-AJAX requests
    return view('list layout/proinvlist', $data);
}



public function getyear()
{
    // Load the model
    $this->crudModel5 = new Protest_model2();

    // Retrieve all dynamically generated financial years
    $records = $this->crudModel5->getFinancialYears();

    // Initialize an array to store results in the format Select2 expects
    $results = [];

    foreach ($records as $row) {
        $results[] = [
            'id' => $row->financial_year, // Unique identifier
            'text' => $row->financial_year // Display text for Select2
        ];
    }

    // Return JSON response for AJAX
    if ($this->request->isAJAX()) {
        return $this->response->setJSON($results);
    }
}

// public function savebank()
// {
//     if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {
//         $bankModel = new Bank_model();
        
//         $data = [
//             'bname' => $this->request->getPost('bname'),
//             'ac' => $this->request->getPost('ac'),
//             'ifsc' => $this->request->getPost('ifsc'),
//             'account_name' => $this->request->getPost('account_name'),
//             'created_at' => date('Y-m-d H:i:s')
//         ];
        
//         if ($bankModel->insert($data)) {
//             return $this->response->setJSON([
//                 'success' => true,
//                 'message' => 'Bank details saved successfully',
//                 'bank_id' => $bankModel->getInsertID()
//             ]);
//         } else {
//             return $this->response->setJSON([
//                 'success' => false,
//                 'message' => 'Failed to save bank details'
//             ]);
//         }
//     }
// }

public function insert() {
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {
        
        $this->crudModel4 = new Protest_model2();
        $this->crudModel = new Protest_model();
        
        // Get form data
        $invid = $this->request->getPost('invid');
        $supplier = $this->request->getPost('supplier');
        $datepicker = $this->request->getPost('datepicker');
        $notes = $this->request->getPost('notes');
        
        // Convert date format from dd-mm-yyyy to yyyy-mm-dd
        $dateParts = explode('-', $datepicker);
        if (count($dateParts) === 3) {
            $formattedDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid date format'
            ]);
        }
        
        // Get item arrays
        $itemNames = $this->request->getPost('item_name');
        $itemDescs = $this->request->getPost('item_desc');
        $hsn = $this->request->getPost('hsn') ?: []; // HSN is optional, default to empty array
        $quantities = $this->request->getPost('item_quantity');
        $units = $this->request->getPost('unit');
        $prices = $this->request->getPost('price');
        $totals = $this->request->getPost('total');
        
        // Get totals
        $subtotal = $this->request->getPost('subTotal');
        $taxrate = $this->request->getPost('taxRate');
        $taxamount = $this->request->getPost('taxAmount');
        $totalaftertax = $this->request->getPost('totalAftertax');
        
        // Get additional fields
        $bank_id = $this->request->getPost('bank_id');
        $validity_period = $this->request->getPost('validity_period');
        $delivery_period = $this->request->getPost('delivery_period');
        $payment_terms = $this->request->getPost('payment_terms');
        
        // Handle signature upload
        $signature_path = null;
        $signature = $this->request->getFile('signature');
        if ($signature && $signature->isValid() && !$signature->hasMoved()) {
            $newName = $signature->getRandomName();
            $signature->move(ROOTPATH . 'public/uploads/signatures/', $newName);
            $signature_path = 'public/uploads/signatures/' . $newName;
        }
        
        // Generate unique order ID
        $orderid = uniqid();
        
        // Validate required fields
        if (!$supplier || !$itemNames || empty(array_filter($itemNames))) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please select a client and add at least one item'
            ]);
        }
        
        // Prepare item data
        $insertData = [];
        if (!empty($itemNames) && is_array($itemNames)) {
            for ($i = 0; $i < count($itemNames); $i++) {
                if (!empty($itemNames[$i])) {
                    $insertData[] = [
                        'orderid' => $orderid,
                        'item_name' => $itemNames[$i],
                        'item_desc' => !empty($itemDescs[$i]) ? $itemDescs[$i] : null,
                        'hsn' => (isset($hsn[$i]) && !empty($hsn[$i])) ? $hsn[$i] : (8443 + $i),
                        'quantity' => !empty($quantities[$i]) ? $quantities[$i] : null,
                        'unit' => !empty($units[$i]) ? $units[$i] : 'Kgs',
                        'price' => !empty($prices[$i]) ? $prices[$i] : null,
                        'total' => !empty($totals[$i]) ? $totals[$i] : null,
                    ];
                }
            }
        }
        
        // Prepare main invoice data
        $insertData2 = [
            'invid' => $invid,
            'cid' => $supplier,
            'orderid' => $orderid,
            'totalitems' => count($insertData),
            'subtotal' => $subtotal,
            'taxrate' => $taxrate,
            'taxamount' => $taxamount,
            'totalamount' => $totalaftertax,
            'bank_id' => $bank_id,
            'validity_period' => $validity_period,
            'delivery_period' => $delivery_period,
            'payment_terms' => $payment_terms,
            'signature_path' => $signature_path,
            'notes' => $notes,
            'created' => $formattedDate
        ];
        
        // Insert data
        try {
            // Log data being inserted for debugging
            log_message('debug', 'Insert Data (Items): ' . json_encode($insertData));
            log_message('debug', 'Insert Data2 (Main): ' . json_encode($insertData2));
            
            // First insert item details
            $itemInsertResult = $this->crudModel->insertBatch($insertData);
            if (!$itemInsertResult) {
                $errors = $this->crudModel->errors();
                log_message('error', 'Item insert failed: ' . json_encode($errors));
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save invoice items: ' . json_encode($errors),
                ]);
            }
            
            // Then insert main invoice data
            $mainInsertResult = $this->crudModel4->insert($insertData2);
            if (!$mainInsertResult) {
                $errors = $this->crudModel4->errors();
                log_message('error', 'Main invoice insert failed: ' . json_encode($errors));
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save main invoice data: ' . implode(', ', $errors),
                ]);
            }
            
            // Log success for debugging
            log_message('debug', 'Invoice created successfully with orderid: ' . $orderid);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Proforma Invoice created successfully!',
                'orderid' => $orderid,
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Exception in invoice insert: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage(),
            ]);
        }
    }
    
    return $this->response->setJSON([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
    

public function delete($id)
{
    // Log the ID to confirm it's correct
    log_message('debug', 'Deleting record with ID: ' . $id);

    // Ensure the request is AJAX
    if ($this->request->isAJAX() || $this->request->getMethod() === 'post') {
        // Load both models
        $this->crudModel = new Protest_model();   // Assuming you have a model for purchaseinv
        $this->crudModel4 = new Protest_model2(); // Model for purchaseinv2

        // Delete the record from both models
        $deleteFromFirstModel = $this->crudModel->deleterecord($id);

        // $lastQuery = $this->crudModel->getLastQuery(); // Ensure this retrieves the last executed query
        //     echo $lastQuery;




        $deleteFromSecondModel = $this->crudModel4->deleterecord($id);

        // $lastQuery2 = $this->crudModel4->getLastQuery(); // Ensure this retrieves the last executed query
        //                     echo $lastQuery2;

        // Log or output the results to ensure they are as expected
//error_log("Delete from first model: " . var_export($deleteFromFirstModel, true));
//error_log("Delete from second model: " . var_export($deleteFromSecondModel, true));
//var_dump($deleteFromSecondModel);
//var_dump($deleteFromSecondModel); 

          // Verify the deletion results
    if ($deleteFromFirstModel && $deleteFromSecondModel) {
        return $this->response->setJSON([
            'res' => 'success',
            'message' => 'Record deleted successfully from both models.'
        ]);
    } else {
        return $this->response->setJSON([
            'res' => 'error',
            'message' => 'Failed to delete the record in both models.'
        ]);
    }
}

return $this->response->setStatusCode(400)->setJSON([
    'res' => 'error',
    'message' => 'Invalid request.'
]);
}





    public function edit()
    {
        if ($this->request->getMethod() === 'get' || $this->request->isAJAX()) {  // Corrected to use $this->request->isAJAX()

        $edit_id = $this->request->getGet('edit_id');  // Corrected to use $this->request->getGet()

        if ($post = $this->crudModel->single_entry($edit_id)) {
            $data = array('res' => "success", 'post' => $post);
        } else {
            $data = array('res' => "error", 'message' => "Failed to fetch data");
        }

        return $this->response->setJSON($data);  // Return JSON response
    } else {
        return $this->response->setJSON([
            'res' => 'error',
            'message' => 'No direct script access allowed'
        ]);
    }
}

public function update() {

    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {

            
            log_message('debug', 'Request data: ' . print_r($this->request->getGet(), true)); 

            $created = $this->request->getPost('created');

            // Convert the input date to DateTime object
            $date = new \DateTime($created);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d');

            $cid=$this->request->getPost('cid');

            log_message('debug', 'CID: ' . $cid); // Log the cid value


            // Prepare data for insertion
            $data = [
               
                'c_name'   => $this->request->getPost('c_nameedit'),
                'c_add'    => $this->request->getPost('c_addedit'),
                'mob'      => $this->request->getPost('fullno2'),
                'country' => $this->request->getPost('fulldetails2'),    
                'gst'      => $this->request->getPost('gstedit'),
                'email'      => $this->request->getPost('email1'),
                'c_type'   => $this->request->getPost('ctypeedit'),
                //'created'  => $formattedDate,
            ];

            //print_r($data);


        //log_message('debug', 'Update Data: ' . print_r($data, true)); 

             //print_r($data);   
            // Attempt to save the record
            $response = $this->crudModel->updaterecord($cid, $data);

             //print_r($response);

            if ($response) {
                //print_r($response);
                // Return success response in JSON format
                return $this->response->setJSON([
                    'res' => 'success',
                    'message' => 'Records updated successfully.',
                //'redirect' => base_url('/client/manageclients'), 
                ]);
                
            } else {
                //print_r($response);
                // Return error response if insertion fails
                return $this->response->setJSON([
                    'res' => 'error',
                    'message' => 'Insert failed.'
                ]);
            }
       
    } else {

        // If not a valid request, return an error
        return $this->response->setJSON([
            'res' => 'error',
            'message' => 'Invalid Request'
        ]);
    }
}

public function printproinv(){
         $orderid = $this->request->getGet('orderid');
         helper('number_to_words_helper');

    if (!$orderid) {
        return view('errors/custom_error', ['message' => 'Order ID is missing.']);
    }

    $this->adminModel = new Admin_model();
    
    $companyDetails = $this->adminModel->first();


    $this->crudModel = new Protest_model();
    $this->crudModel2 = new Protest_model2();
    $this->crudModel3 = new Bank_model();
    //$this->crudModel4 = new Delivery_model();


    $invDetails =$this->crudModel2-> printprodata($orderid);

        //$invid = $invDetails[0]['invid'];

     //$deliveryDetails = $this ->crudModel4-> getdeliverydata($invid);


    $itemDetails = $this->crudModel->fetchitemdata($orderid);

    // Fetch the specific bank selected for this invoice
    $selectedBankId = isset($invDetails[0]['bank_id']) ? $invDetails[0]['bank_id'] : null;
    if ($selectedBankId) {
        $bankDetails = $this->crudModel3->where('bid', $selectedBankId)->findAll();
    } else {
        // Fallback to default bank if none selected
        $bankDetails = $this->crudModel3->findAll();
    }

    // if (empty($taxinvData)) {
    //     return view('errors/custom_error', ['message' => 'No data found for the given Order ID.']);
    // }

    //print_r($companyDetails);
    //print_r($invid);
    //print_r($deliveryDetails);
    //print_r($invDetails);
    //print_r($itemDetails);
    //print_r($bankDetails);
    //return view('print/print quote', ['quoteDetails' => $quoteData]);
        return view('print/print proinv',['companyDetails' => $companyDetails,
                                           'invDetails' => $invDetails,
                                           'itemDetails' =>$itemDetails,
                                            'bankDetails'=> $bankDetails]);
    }
    
}
?>