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

    /**
     * Generate a unique invoice ID with conflict checking
     */
    private function generateUniqueInvoiceId($db, $maxRetries = 10) {
        if (date('m') > 3) {
            $year = date('y') . "-" . (date('y') + 1);
        } else {
            $year = (date('y') - 1) . "-" . date('y');
        }

        for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
            // Get current count of invoices for this year
            $datalogger = "SELECT COUNT(*) as count FROM protest2 WHERE invid LIKE 'PI/$year/%'";
            $stmt = $db->query($datalogger);
            $row = $stmt->getRow();

            // Determine the invoice number
            if ($row && $row->count > 0) {
                $nextNumber = $row->count + 1;
                $proposedId = "PI/" . $year . "/" . sprintf('%04d', $nextNumber);
            } else {
                // No records found, start from 0001
                $proposedId = "PI/" . $year . "/0001";
            }

            // Check if this ID already exists (race condition check)
            $checkQuery = "SELECT COUNT(*) as count FROM protest2 WHERE invid = ?";
            $checkStmt = $db->query($checkQuery, [$proposedId]);
            $checkRow = $checkStmt->getRow();

            if ($checkRow && $checkRow->count == 0) {
                // ID is unique, return it
                return $proposedId;
            }

            // ID exists, wait a tiny bit and try again
            usleep(10000); // 10ms delay
        }

        // If we've exhausted retries, use timestamp-based ID as fallback
        $timestamp = time();
        return "PI/" . $year . "/" . sprintf('%04d', $timestamp % 10000);
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

        // Generate unique invoice ID
        $value = $this->generateUniqueInvoiceId($db);

        // Return the generated invoice ID (you can return it as JSON or any format you prefer)
        //return $this->response->setJSON(['invoice_id' => $value]);
    
    // If it's an AJAX request, return JSON
    if ($this->request->isAJAX()) {
        //return $this->response->setJSON(['invoice_id' => $value]);
    }

    // Load bank data for dropdown
    $bankModel = new \App\Models\Bank_model();
    $banks = $bankModel->findAll();
    
    // Load user signatures for dropdown
    $userSignatureModel = new \App\Models\User_signature_model();
    $userSignatures = $userSignatureModel->getUserSignatures($session->get('user_id'));
    
    return view('layout/genproinv',[
        'invoice_id' => $value,
        'banks' => $banks,
        'userSignatures' => $userSignatures
    ]);      
    //return view('layout/genpurchaseinvoice.php');
}




public function editproinv($orderid = null)
    {
        if ($this->request->getMethod() === 'get' || $this->request->isAJAX()) {
            
            // Get orderid from URL parameter or GET request
            $edit_id = $orderid ?: $this->request->getGet('orderid');
            
            if (!$edit_id) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Order ID is required'
                    ]);
                }
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }

            $this->crudModel3 = new Protest_model();
            $records = $this->crudModel3->where('orderid', $edit_id)->findAll();

            $this->crudModel4 = new Protest_model2();
            $builder = $this->crudModel4->db->table('protest2');
            $builder->select('protest2.*, client.c_name, client.c_add');
            $builder->join('client', 'protest2.cid = client.cid', 'inner');
            $builder->where('protest2.orderid', $edit_id);
            $records2 = $builder->get()->getResultArray();

            // Get banks and signatures for the form
            $bankModel = new \App\Models\Bank_model();
            $banks = $bankModel->findAll();
            
            $signatureModel = new \App\Models\User_signature_model();
            $userSignatures = $signatureModel->where('user_id', session()->get('user_id'))->findAll();
            
            // If it's an AJAX request, return JSON
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'records' => $records,
                    'records2' => $records2,
                ]);
            }
            
            $data = [
                'records' => $records,
                'records2' => $records2,
                'banks' => $banks,
                'userSignatures' => $userSignatures,
            ];

            return view('edit layout/editproinv', $data);
        }
        
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

public function updateproinv($orderid = null)
{
    // DEBUG: Log the start of the method
    error_log("=== UPDATE PROINV DEBUG START ===");
    error_log("Method: " . $this->request->getMethod());
    error_log("Is AJAX: " . ($this->request->isAJAX() ? 'YES' : 'NO'));
    error_log("Order ID from URL: " . ($orderid ?: 'NULL'));
    
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {
        
        $this->crudModel4 = new Protest_model2();
        $this->crudModel = new Protest_model();
        
        // Get orderid from URL parameter or POST data
        $orderid = $orderid ?: $this->request->getPost('orderid');
        
        error_log("Final Order ID: " . ($orderid ?: 'NULL'));
        
        if (!$orderid) {
            error_log("ERROR: No Order ID provided");
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Order ID is required'
            ]);
        }

        // Get form data and log everything
        $invid = $this->request->getPost('invid');
        $supplier = $this->request->getPost('supplier');
        $datepicker = $this->request->getPost('datepicker');
        
        error_log("Form Data:");
        error_log("- invid: " . ($invid ?: 'NULL'));
        error_log("- supplier: " . ($supplier ?: 'NULL'));
        error_log("- datepicker: " . ($datepicker ?: 'NULL'));
        
        // Convert date format using working version approach
        try {
            $date = new \DateTime($datepicker);
            $formattedDate = $date->format('Y-m-d');
            error_log("Formatted date: " . $formattedDate);
        } catch (Exception $e) {
            error_log("Date conversion error: " . $e->getMessage());
            $formattedDate = date('Y-m-d');
        }
        
        // Get item arrays
        $itemNames = $this->request->getPost('item_name');
        $itemDescs = $this->request->getPost('item_desc');
        $hsn = $this->request->getPost('hsn');
        $quantities = $this->request->getPost('item_quantity');
        $prices = $this->request->getPost('price');
        $vatRates = $this->request->getPost('vat_rate');
        $vatTypes = $this->request->getPost('vat_type');
        $vatStatuses = $this->request->getPost('vat_status');
        $totals = $this->request->getPost('total');
        
        error_log("Item Arrays:");
        error_log("- itemNames: " . print_r($itemNames, true));
        error_log("- quantities: " . print_r($quantities, true));
        error_log("- prices: " . print_r($prices, true));
        error_log("- vatStatuses: " . print_r($vatStatuses, true));
        
        // Get totals
        $subtotal = $this->request->getPost('subTotal');
        $taxamount = $this->request->getPost('taxAmount');
        $totalaftertax = $this->request->getPost('totalAftertax');
        
        error_log("Totals:");
        error_log("- subtotal: " . ($subtotal ?: 'NULL'));
        error_log("- taxamount: " . ($taxamount ?: 'NULL'));
        error_log("- totalaftertax: " . ($totalaftertax ?: 'NULL'));
        
        // Get additional fields
        $bank_id = $this->request->getPost('bank_id');
        $validity_period = $this->request->getPost('validity_period');
        $delivery_period = $this->request->getPost('delivery_period');
        $payment_terms = $this->request->getPost('payment_terms');
        $signature_id = $this->request->getPost('signature_id');
        
        error_log("Additional fields:");
        error_log("- bank_id: " . ($bank_id ?: 'NULL'));
        error_log("- validity_period: " . ($validity_period ?: 'NULL'));
        error_log("- delivery_period: " . ($delivery_period ?: 'NULL'));
        error_log("- payment_terms: " . ($payment_terms ?: 'NULL'));
        error_log("- signature_id: " . ($signature_id ?: 'NULL'));
        
        // Handle signature - get from database if signature_id is provided
        $signature_path = null;
        if ($signature_id) {
            try {
                $userSignatureModel = new \App\Models\User_signature_model();
                $signature = $userSignatureModel->find($signature_id);
                if ($signature) {
                    $signature_path = $signature['signature_path'];
                    error_log("Signature path: " . $signature_path);
                }
            } catch (Exception $e) {
                error_log("Signature error: " . $e->getMessage());
            }
        }
        
        // Prepare item data using working version approach
        $insertData = [];
        if (!empty($itemNames) && is_array($itemNames)) {
            for ($i = 0; $i < count($itemNames); $i++) {
                if (!empty($itemNames[$i])) {
                    // Calculate VAT amount for this item
                    $quantity = !empty($quantities[$i]) ? $quantities[$i] : 0;
                    $price = !empty($prices[$i]) ? $prices[$i] : 0;
                    $vatRate = !empty($vatRates[$i]) ? $vatRates[$i] : 18; // Default to 18%
                    $vatType = !empty($vatTypes[$i]) ? $vatTypes[$i] : 'exclusive';
                    $vatStatus = !empty($vatStatuses[$i]) ? $vatStatuses[$i] : 'taxable';
                    
                    $rowSubtotal = $quantity * $price;
                    $vatAmount = 0;
                    
                    // Calculate total for this item
                    $itemTotal = $quantity * $price;
                    if ($vatStatus === 'taxable' && $vatRate > 0) {
                        $vatAmount = ($itemTotal * $vatRate) / 100;
                        $itemTotal = $itemTotal + $vatAmount;
                    }
                    
                    $insertData[] = [
                        'orderid' => $orderid,
                        'item_name' => $itemNames[$i],
                        'item_desc' => !empty($itemDescs[$i]) ? $itemDescs[$i] : null,
                        'hsn' => !empty($hsn[$i]) ? $hsn[$i] : 8443, // Default HSN if not provided
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $itemTotal,
                    ];
                }
            }
        }
        
        error_log("Prepared insert data: " . print_r($insertData, true));
        
        // Prepare main invoice data using working version approach
        // Only include fields that exist in the database table
        $updateData = [
            'invid' => $invid,
            'cid' => $supplier,
            'totalitems' => count($itemNames),
            'subtotal' => $subtotal,
            'taxrate' => 0, // Not used anymore with per-item VAT
            'taxamount' => $taxamount,
            'totalamount' => $totalaftertax,
            'created' => $formattedDate,
        ];
        
        error_log("Prepared update data: " . print_r($updateData, true));
        
        // Update the main invoice
        error_log("Attempting to update main invoice...");
        error_log("Order ID for update: " . $orderid);
        error_log("Update data: " . print_r($updateData, true));
        
        // Check if the record exists first
        $existingRecord = $this->crudModel4->where('orderid', $orderid)->first();
        error_log("Existing record: " . print_r($existingRecord, true));
        
        if (!$existingRecord) {
            error_log("ERROR: No existing record found with orderid: " . $orderid);
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No existing invoice found with order ID: ' . $orderid
            ]);
        }
        
        $mainUpdate = $this->crudModel4->updaterecord($orderid, $updateData);
        error_log("Main update result: " . ($mainUpdate ? 'SUCCESS' : 'FAILED'));
        
        // Get the last query for debugging
        $lastQuery = $this->crudModel4->db->getLastQuery();
        error_log("Last query: " . $lastQuery);
        
        // Get database error if any
        $dbError = $this->crudModel4->db->error();
        if ($dbError['code'] != 0) {
            error_log("Database error: " . print_r($dbError, true));
        }
        
        // Always update items by deleting old and inserting new
        error_log("Deleting old items...");
        $deleteResult = $this->crudModel->deleterecord($orderid);
        error_log("Delete result: " . ($deleteResult ? 'SUCCESS' : 'FAILED'));
        
        error_log("Inserting new items...");
        $itemsInsert = $this->crudModel->insertBatch($insertData);
        error_log("Items insert result: " . ($itemsInsert ? 'SUCCESS' : 'FAILED'));

        if ($mainUpdate && $itemsInsert) {
            error_log("=== UPDATE SUCCESS ===");
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Proforma Invoice updated successfully!',
                'orderid' => $orderid,
                'invid' => $invid,
                'original_invid' => $invid
            ]);
        } else {
            error_log("=== UPDATE FAILED ===");
            error_log("Main update: " . ($mainUpdate ? 'SUCCESS' : 'FAILED'));
            error_log("Items insert: " . ($itemsInsert ? 'SUCCESS' : 'FAILED'));
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update invoice. Main: ' . ($mainUpdate ? 'OK' : 'FAILED') . ', Items: ' . ($itemsInsert ? 'OK' : 'FAILED'),
            ]);
        }
    }
    
    error_log("=== INVALID REQUEST METHOD ===");
    return $this->response->setJSON([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
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

public function saveclient()
{
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {
        $clientModel = new Client_model();
        
        // Get form data
        $c_name = $this->request->getPost('c_name');
        $c_add = $this->request->getPost('c_add');
        $mob = $this->request->getPost('mob');
        $country = $this->request->getPost('country');
        $gst = $this->request->getPost('gst');
        $email = $this->request->getPost('email');
        $c_type = $this->request->getPost('c_type');
        $u_type = $this->request->getPost('u_type');
        
        // Validate required fields - check for empty strings and null values
        if (empty($c_name) || empty($c_add) || empty($mob) || empty($c_type) || $u_type === null || $u_type === '') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Client name, address, mobile, client type, and user type are required'
            ]);
        }
        
        // Get next client ID
        $last_cid = $clientModel->get_last_cid();
        $next_cid = ($last_cid !== null) ? $last_cid + 1 : 1;
        
        // Prepare data for insertion
        $data = [
            'cid' => $next_cid,
            'c_name' => $c_name,
            'c_add' => $c_add,
            'mob' => $mob,
            'country' => $country ? $country : 'India',
            'gst' => $gst ? strtoupper($gst) : '',
            'email' => $email ? $email : '',
            'c_type' => $c_type,
            'u_type' => $u_type,
            'created' => date('Y-m-d')
        ];
        
        try {
            if ($clientModel->insert($data)) {
                $insertId = $clientModel->getInsertID();
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Client saved successfully',
                    'client_id' => $insertId
                ]);
                            } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to save client. Please try again.'
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

public function savesignature()
{
    if ($this->request->getMethod() === 'post' || $this->request->isAJAX()) {
        $signatureModel = new \App\Models\User_signature_model();
        
        // Get form data
        $signature_name = $this->request->getPost('signature_name');
        $set_as_default = $this->request->getPost('set_as_default');
        $signature_file = $this->request->getFile('signature_file');
        
        // Validate required fields
        if (empty($signature_name) || !$signature_file || !$signature_file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Signature name and file are required'
            ]);
        }
        
        // Generate unique filename
        $newName = $signature_file->getRandomName();
        $signature_file->move(WRITEPATH . 'uploads/signatures/', $newName);
        
        // If setting as default, unset other defaults first
        if ($set_as_default) {
            $signatureModel->where('user_id', session()->get('user_id'))
                          ->set(['is_default' => 0])
                          ->update();
        }
        
        $data = [
            'user_id' => session()->get('user_id'),
            'signature_name' => $signature_name,
            'signature_path' => 'uploads/signatures/' . $newName,
            'is_default' => $set_as_default ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            if ($signatureModel->insert($data)) {
                $insertId = $signatureModel->getInsertID();
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Signature saved successfully',
                    'signature_id' => $insertId
                ]);
            } else {
                $errors = $signatureModel->errors();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save signature: ' . implode(', ', $errors)
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

public function checkitem()
{
    if ($this->request->getMethod() === 'get' || $this->request->isAJAX()) {
        $item_name = $this->request->getGet('item_name');
        
        if (empty($item_name)) {
            return $this->response->setJSON([
                'exists' => false,
                'message' => 'Item name is required'
            ]);
        }
        
        $productModel = new \App\Models\Product_model();
        $exists = $productModel->where('name', $item_name)->first();
        
        return $this->response->setJSON([
            'exists' => $exists ? true : false,
            'message' => $exists ? 'Item exists' : 'Item does not exist'
        ]);
    }
    
    return $this->response->setJSON([
        'exists' => false,
        'message' => 'Invalid request method'
    ]);
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
                'message' => 'Item name is required',
                'debug_data' => $allPostData
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
    // Get the selected client and product from request
    $selectedClient = $this->request->getVar('client');
    $selectedProduct = $this->request->getVar('product');
    
    // Pagination logic
    $results_per_page = 20; // Number of results per page
    $page = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1; // Current page
    $offset = ($page - 1) * $results_per_page;

    // Load the model
    $protest_model2 = new Protest_model2();

    // Fetch all data - no year filtering, ordered by created date (latest first)
    $invoices = $protest_model2->getprotest(
        null,  // No year filtering
        null,  // No year filtering
        $selectedClient, 
        $selectedProduct, 
        $results_per_page, 
        $offset
    );

    // Count total number of records for pagination
    $total_records = $protest_model2->countAllInvoices(
        null,  // No year filtering
        null,  // No year filtering
        $selectedClient, 
        $selectedProduct
    );

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
        $db = \Config\Database::connect();
        
        // Get form data
        $originalInvid = $this->request->getPost('invid');
        $supplier = $this->request->getPost('supplier');
        $datepicker = $this->request->getPost('datepicker');
        
        // Generate a unique invoice ID to avoid conflicts
        $invid = $this->generateUniqueInvoiceId($db);
        
        // Convert date format using working version approach
        $date = new \DateTime($datepicker);
        $formattedDate = $date->format('Y-m-d');
        
        // Get item arrays
        $itemNames = $this->request->getPost('item_name');
        $itemDescs = $this->request->getPost('item_desc');
        $hsn = $this->request->getPost('hsn');
        $quantities = $this->request->getPost('item_quantity');
        $prices = $this->request->getPost('price');
        $vatRates = $this->request->getPost('vat_rate');
        $vatTypes = $this->request->getPost('vat_type');
        $vatStatuses = $this->request->getPost('vat_status');
        $totals = $this->request->getPost('total');
        
        // Get totals
        $subtotal = $this->request->getPost('subTotal');
        $taxamount = $this->request->getPost('taxAmount');
        $totalaftertax = $this->request->getPost('totalAftertax');
        
        // Get additional fields
        $bank_id = $this->request->getPost('bank_id');
        $validity_period = $this->request->getPost('validity_period');
        $delivery_period = $this->request->getPost('delivery_period');
        $payment_terms = $this->request->getPost('payment_terms');
        $signature_id = $this->request->getPost('signature_id');
        
        // Handle signature - get from database if signature_id is provided
        $signature_path = null;
        if ($signature_id) {
            $userSignatureModel = new \App\Models\User_signature_model();
            $signature = $userSignatureModel->find($signature_id);
            if ($signature) {
                $signature_path = $signature['signature_path'];
            }
        }
        
        // Generate unique order ID
        $orderid = uniqid();
        
        // Prepare item data using working version approach
        $insertData = [];
        if (!empty($itemNames) && is_array($itemNames)) {
            for ($i = 0; $i < count($itemNames); $i++) {
                if (!empty($itemNames[$i])) {
                    // Calculate VAT amount for this item
                    $quantity = !empty($quantities[$i]) ? $quantities[$i] : 0;
                    $price = !empty($prices[$i]) ? $prices[$i] : 0;
                    $vatRate = !empty($vatRates[$i]) ? $vatRates[$i] : 0;
                    $vatType = !empty($vatTypes[$i]) ? $vatTypes[$i] : 'exclusive';
                    $vatStatus = !empty($vatStatuses[$i]) ? $vatStatuses[$i] : 'taxable';
                    
                    $subtotal = $quantity * $price;
                    $vatAmount = 0;
                    
                    if ($vatStatus === 'taxable' && $vatRate > 0) {
                        if ($vatType === 'exclusive') {
                            $vatAmount = ($subtotal * $vatRate) / 100;
                        } else {
                            // VAT inclusive - extract VAT from total
                            $total = $subtotal;
                            $vatAmount = $total - ($total / (1 + ($vatRate / 100)));
                        }
                    }
                    
                    $insertData[] = [
                        'orderid' => $orderid,
                        'item_name' => $itemNames[$i],
                        'item_desc' => !empty($itemDescs[$i]) ? $itemDescs[$i] : null,
                        'hsn' => !empty($hsn[$i]) ? $hsn[$i] : 8443, // Default HSN if not provided
                        'quantity' => $quantity,
                        'price' => $price,
                        'vat_rate' => $vatRate,
                        'vat_type' => $vatType,
                        'vat_status' => $vatStatus,
                        'vat_amount' => $vatAmount,
                        'total' => !empty($totals[$i]) ? $totals[$i] : null,
                    ];
                }
            }
        }
        
        // Prepare main invoice data using working version approach
        $insertData2 = [];
        $insertData2[] = [
            'invid' => $invid,
            'cid' => $supplier,
            'orderid' => $orderid,
            'totalitems' => count($itemNames),
            'subtotal' => $subtotal,
            'taxrate' => 0, // Not used anymore with per-item VAT
            'taxamount' => $taxamount,
            'totalamount' => $totalaftertax,
            'created' => date('Y-m-d H:i:s'),
            'bank_id' => $bank_id,
            'validity_period' => $validity_period,
            'delivery_period' => $delivery_period,
            'payment_terms' => $payment_terms,
            'signature_path' => $signature_path,
        ];
        
        // Insert data using working version approach
        if ($this->crudModel->insertBatch($insertData) && $this->crudModel4->insertBatch($insertData2)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Proforma Invoice Data Inserted!',
                'orderid' => $orderid,
                'invid' => $invid, // Return the actual invoice ID used
                'original_invid' => $originalInvid, // Return original ID for reference
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to insert data.',
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

            

            $created = $this->request->getPost('created');

            // Convert the input date to DateTime object
            $date = new \DateTime($created);

            // Format the date to Y-m-d (MySQL compatible format)
            $formattedDate = $date->format('Y-m-d');

            $cid=$this->request->getPost('cid');



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