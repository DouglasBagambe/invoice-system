<?php

namespace App\Models;

use CodeIgniter\Model;

class Protest_model2 extends Model
{
    protected $table = 'protest2'; // Specify your table name
    //protected $primaryKey = 'invid'; // Specify your primary key column

    protected $allowedFields = ['invid','cid', 'orderid', 'totalitems','subtotal','taxrate','taxamount','totalamount','created','bank_id','signature_path','validity_period','delivery_period','payment_terms','notes']; // Specify allowed fields

    // Optionally, you can define validation rules
    // protected $validationRules = [
    //     'name'  => 'required|string',
    //     'email' => 'required|valid_email',
    //     'city'  => 'required|string',
    // ];

    // // Optionally, you can define custom validation messages
    // protected $validationMessages = [
    //     'name' => [
    //         'required' => 'The name field is required.',
    //         'string'   => 'The name field must be a string.',
    //     ],
    //     'email' => [
    //         'required'    => 'The email field is required.',
    //         'valid_email' => 'The email address is not valid.',
    //     ],
    //     'city' => [
    //         'required' => 'The city field is required.',
    //         'string'   => 'The city field must be a string.',
    //     ],
    // ];

    /**
     * Insert a record into the database
     *
     * @param array $data - Data to be inserted
     * @return boolean - Success or failure of the operation
     */
    
    public function saverecords(array $data)
    {
        return $this->insert($data); // Insert data into the table
    }

    /**
     * Update a specific record by primary key
     *
     * @param int $id - Primary key of the record to be updated
     * @param array $data - Data to be updated
     * @return boolean - Success or failure of the update operation
     */
   public function updaterecord($orderid, array $updateData)
    {
        //return $this->update($id, $data); // Update data in the table
        $this->db->table('protest2')->where('orderid', $orderid)->update($updateData);

    }


    public function deleterecord(string $id)
{
    $builder = $this->db->table('protest2');
    $builder->delete(['orderid' => $id]);

    // Check if any rows were affected (deleted) and return true if successful
    return $this->db->affectedRows() > 0;
}


    
    public function getFinancialYears()
{
    return $this->db->table('protest2')  // Specify the table to query from
                    ->select("CASE 
                                WHEN MONTH(created) >= 4 
                                THEN CONCAT(YEAR(created), '-', YEAR(created) + 1) 
                                ELSE CONCAT(YEAR(created) - 1, '-', YEAR(created)) 
                              END AS financial_year")
                    ->groupBy("financial_year")  // Group by financial year
                    ->orderBy('financial_year', 'DESC')
                    ->get()
                    ->getResult(); // Fetches the results as an array of objects
}


public function getprotest($startyear = null, $endyear = null, $client = null, $product = null, $limit, $offset)
{
    // Use a subquery to get concatenated item names
    $itemSubquery = "(SELECT GROUP_CONCAT(item_name SEPARATOR ', ') 
                      FROM protest 
                      WHERE protest.orderid = protest2.orderid) as item_name";

    $builder = $this->db->table('protest2')
                        ->select("protest2.*, client.c_name, client.c_add, $itemSubquery")
                        ->join('client', 'protest2.cid = client.cid', 'left');

    // Check if year parameters are provided, otherwise show all invoices
    if ($startyear && $endyear) {
        $builder->where('protest2.created >=', "$startyear-04-01")
                ->where('protest2.created <=', "$endyear-03-31");
    }

    // Apply client filter only if a client is selected
    if ($client) {
        $builder->where('protest2.cid', $client);
    }

    // Apply product filter only if a product (item_name) is selected
    if ($product) {
        // Use EXISTS subquery for product filtering
        $builder->where("EXISTS (SELECT 1 FROM protest WHERE protest.orderid = protest2.orderid AND protest.item_name = '$product')");
    }

    // Apply limit and offset for pagination
    $result = $builder->limit($limit, $offset)
                   ->orderBy('protest2.created', 'DESC')
                   ->get()
                   ->getResult();

    // Process each result to handle empty item names and location extraction
    foreach ($result as $row) {
        // Handle case where no items exist for this invoice
        if (empty($row->item_name) || is_null($row->item_name)) {
            $row->item_name = 'No items';
        }

        // Extract location from address
        if (!empty($row->c_add)) {
            $addressParts = explode(',', $row->c_add);
            $row->location = trim(end($addressParts));
        } else {
            $row->location = 'No address';
        }
    }

    return $result;
}


public function countAllInvoices($startyear = null, $endyear = null, $client = null, $product = null)
{
    $builder = $this->db->table('protest2')
                        ->join('client', 'protest2.cid = client.cid', 'left');

    // Apply date range filters only if year is specified
    if ($startyear && $endyear) {
        $builder->where('protest2.created >=', "$startyear-04-01")
                ->where('protest2.created <=', "$endyear-03-31");
    }

    // Apply client filter
    if ($client) {
        $builder->where('protest2.cid', $client);
    }

    // Apply product filter using EXISTS subquery
    if ($product) {
        $builder->where("EXISTS (SELECT 1 FROM protest WHERE protest.orderid = protest2.orderid AND protest.item_name = '$product')");
    }

    // Return the count of unique rows
    return $builder->countAllResults();
}


public function insertItems(array $items) {
        // Using insertBatch for batch insert to improve performance
        return $this->insertBatch($items);
    }



    public function updateBatch(?array $set = null, ?string $index = null, int $batchSize = 100, bool $returnSQL = true)
{
    $index ='orderid';  // Default to the primary key if not provided

    if (empty($set)) {
        return false; // No data to update
    }

    try {
        // Use 'purchaseinv2' as the table name
        return $this->db->table('protest2')->updateBatch($set, $index, $batchSize);
    } catch (\Exception $e) {
        log_message('error', 'UpdateBatch failed: ' . $e->getMessage());
        return false;
    }
}

public function printprodata($orderid)
{
    if (!$orderid) {
        return false; // Return false or handle the case where order ID is missing
    }

    $builder = $this->db->table('protest2');
    $builder->select('client.*, protest2.*');
    $builder->join('client', 'protest2.cid = client.cid', 'inner');
    $builder->where('protest2.orderid', $orderid);

    $query = $builder->get();
    return $query->getResultArray(); // Return the fetched data as an array
}

public function getInvoices($startDate = null, $endDate = null, $item = null, $customer = null, $ctype=null)
{

    $sql = "SELECT 
                ROW_NUMBER() OVER () AS id, 
                protest.item_name AS item, 
                protest2.invid AS `inv no`, 
                protest2.created AS `inv date`, 
                client.c_name AS client, 
                SUBSTRING_INDEX(client.c_add, ',', -1) AS location, 
                client.gst AS GST, 
                client.c_type AS c_type,
                protest2.subtotal AS subtotal, 
                protest2.taxrate AS taxrate, 
                protest2.taxamount AS taxamount, 
                protest2.totalamount AS totalamount 

            FROM protest2 
            INNER JOIN protest ON protest.orderid = protest2.orderid 
            INNER JOIN client ON protest2.cid = client.cid";

    // Add conditions dynamically
    $conditions = [];
    $params = [];



  if (!empty($customer)) {
        $conditions[] = "client.cid = ?";
        $params[] = $customer;
    }


    if (!empty($startDate) && !empty($endDate)) {
        $conditions[] = "protest2.created BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
    }

  
    //  if (!empty($ctype)) {
    //     $conditions[] = "client.u_type = ?";
    //     $params[] = $ctype;
    // }

    // Append conditions to SQL query
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    // Add GROUP BY clause
    $sql .= "GROUP BY protest.orderid";

//    echo $sql;

    // Execute the query
    $query = $this->db->query($sql, $params);

    //print_r($query);

    // Return the results
    return $query->getResult();
}

public function getItemreport($startDate = null, $endDate = null, $item = null)
{
    $sql = "
        SELECT 
            ROW_NUMBER() OVER () AS id,
            protest2.created, 
            protest.item_name AS item, 
            protest.item_desc AS description, 
            protest.hsn, 
            protest.price,
            protest.quantity, 
            protest.total AS subtotal, 
            protest2.taxrate, 
            protest2.taxamount,
            protest2.totalamount
 
        FROM 
            protest2 
        INNER JOIN 
            protest ON protest.orderid = protest2.orderid 
        INNER JOIN 
            products ON protest.item_name = products.name
    ";

    // Initialize conditions and parameters
    $conditions = [];
    $params = [];

    // Add date range condition
    if (!empty($startDate) && !empty($endDate)) {
        $conditions[] = "protest2.created BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
    }

    // Add item condition
    if (!empty($item)) {
        $conditions[] = "protest.item_name = ?";
        $params[] = $item;
    }

    // Ensure at least one condition is applied
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    } else {
        // No conditions provided; return an empty result
        return [];
    }

    //echo $sql;

    // Execute the query
    $query = $this->db->query($sql, $params);

    // Return the results
    return $query->getResult();
}

}
