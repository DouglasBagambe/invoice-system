<?php 

?>

<html>
<head>
<title>Proforma Invoice</title>
<?= $this->include('Include/links.php');?>

<style type="text/css">
body {
  background: rgb(204,204,204); 
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 10px;
  font-size: 12px;
}

page {
  background: white;
  display: block;
  margin: 0 auto;
  margin-bottom: 0.5cm;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  padding: 0;
  width: 21cm;
  min-height: 29.7cm;
  position: relative;
}

/* CRITICAL: Force all colors to print exactly as displayed */
@media print {
  body, page {
    margin: 0;
    box-shadow: 0;
    background: white !important;
    padding: 0;
  }
  
  /* FORCE ALL COLORS TO PRINT - This is the key fix */
  *, *:before, *:after {
    -webkit-print-color-adjust: exact !important;
    color-adjust: exact !important;
    print-color-adjust: exact !important;
  }
  
  /* Ensure all table elements print with exact colors */
  table, th, td, tr {
    -webkit-print-color-adjust: exact !important;
    color-adjust: exact !important;
    print-color-adjust: exact !important;
  }
  
  /* Remove browser headers and footers completely */
  @page {
    margin: 0.3in 0.3in 0.3in 0.3in;
    size: A4;
  }
  
  /* Hide print button */
  #printButton {
    display: none !important;
  }
  
  /* Make main container use full page */
  .main-container {
    padding: 0px 15px 15px 15px !important;
    margin: 0 !important;
  }
}

.main-container {
  padding: 25px;
  position: relative;
  height: calc(100vh - 50px);
}

.main-border {
  border: 2px solid #000;
  padding: 0px 20px 20px 20px;
  position: relative;
  min-height: calc(100% - 40px);
  height: auto;
}

.profoma-label {
  position: absolute;
  top: -12px;
  left: 50%;
  transform: translateX(-50%);
  background: white;
  padding: 0 15px;
  font-size: 14px;
  font-weight: bold;
  color: #000;
  border: 1px solid #000;
}

/* Header Section */
.header-section {
  width: 100%;
  margin-bottom: 10px;
  background: #fff;
  /* padding: 0 10px; */
  display: flex;
  align-items: center;
}

.company-logo {
  width: 150px;
  height: 120px;
  margin-right: 15px;
  margin-top: 5px;
  flex-shrink: 0;
  background: #fff !important;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.company-details {
  flex: 1;
  margin-right: 20px;
  border-bottom: 4px solid #000;
}

.company-name {
  font-size: 2em;
  font-weight: bold;
  color: #000 !important;
  margin-bottom: 3px;
  letter-spacing: 0.5px;
  font-family: 'Times New Roman', Times, serif;
}

.company-description {
  font-size: 11px;
  color: #000 !important;
  margin-bottom: 3px;
  line-height: 1.3;
  font-weight: normal;
}

.company-contact {
  font-size: 10px;
  color: #000 !important;
  line-height: 1.3;
  font-weight: normal;
}

.proforma-info {
  text-align: right;
  font-size: 12px;
  white-space: nowrap;
  color: #000 !important;
  font-weight: normal;
  border-bottom: 4px solid #000;
}

.proforma-info div {
  margin-bottom: 2px;
}

/* Quotation Table - FIXED COLORS */
.quotation-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  font-size: 12px;
}

.quotation-table th {
  background-color: #E6E6FA !important;
  border: 1px solid #E6E6FA !important;
  padding: 8px;
  font-weight: bold;
  text-align: left;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

.quotation-table td {
  background-color: #E6E6FA !important;
  border: 1px solid #E6E6FA !important;
  padding: 12px;
  vertical-align: top;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

.quotation-table .quotation-header {
  width: 50%;
  border-right: 2px solid #fff !important;
}

.quotation-table .ship-header {
  width: 50%;
  text-align: right;
}

.quotation-table .company-name-cell {
  font-size: 16px;
  font-weight: bold;
  border-right: 2px solid #fff !important;
}

/* Items Table - FIXED COLORS */
.items-table {
  width: 100%;
  border-collapse: collapse;
  /* margin-bottom: 15px; */
  font-size: 12px;
}

.items-table th {
  background-color: #E6E6FA !important;
  border-right: 1px solid #000 !important;
  border-top: 1px solid #000 !important;
  border-left: 1px solid #000 !important;
  border-bottom: none;
  padding: 8px 6px;
  text-align: center;
  font-weight: bold;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

.items-table td {
  border-right: 1px solid #000 !important;
  border-top: 1px solid #000 !important;
  border-left: 1px solid #000 !important;
  border-bottom: none;
  padding: 8px 6px;
  color: #000 !important;
  background-color: white !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

.items-table th:nth-child(1), .items-table td:nth-child(1) { width: 5%; text-align: center; }
.items-table th:nth-child(2), .items-table td:nth-child(2) { width: 10%; text-align: center; }
.items-table th:nth-child(3), .items-table td:nth-child(3) { width: 10%; text-align: center; }
.items-table th:nth-child(4), .items-table td:nth-child(4) { width: 35%; text-align: left; }
.items-table th:nth-child(5), .items-table td:nth-child(5) { width: 20%; text-align: right; }
.items-table th:nth-child(6), .items-table td:nth-child(6) { width: 20%; text-align: right; }

/* Summary Table - FIXED COLORS */
.summary-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 12px;
  /* margin-bottom: 15px; */
  margin-bottom: 20px;
  border-bottom: 1px solid #000 !important
}

.summary-table td {
  padding: 10px;
  border-right: 1px solid #000 !important;
  border-top: 1px solid #000 !important;
  border-left: 1px solid #000 !important;
  border-bottom: 1px solid #000 !important
  background-color: white !important;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
  margin-bottom: 20px;
}

.summary-table .note-cell {
  width: 60%;
  vertical-align: top;
  border-right: 1px solid #000 !important;
}

.summary-table .totals-cell {
  width: 40%;
  padding: 0;
  border-left: none;
}

.totals-inner {
  display: table;
  width: 100%;
  height: 100%;
}

.total-row {
  display: table-row;
}

.total-label, .total-amount {
  display: table-cell;
  padding: 10px;
  /* border-bottom: 1px solid #000 !important; */
  vertical-align: middle;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

.total-label {
  text-align: right;
  width: 50%;
  border-right: 1px solid #000 !important;
}

.total-amount {
  text-align: right;
  width: 50%;
}

.total-row:last-child .total-label,
.total-row:last-child .total-amount {
  border-bottom: none;
}

.total-row:nth-child(2) .total-label,
.total-row:nth-child(2) .total-amount {
  border-bottom: 1px solid #000 !important
}

/* Amount in Words Table - FIXED COLORS */
.amount-words-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  font-size: 12px;
}

.amount-words-table td {
  border: 1px solid #000 !important;
  padding: 10px;
  background-color: white !important;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

.amount-words-table .words-cell {
  width: 60%;
  padding: 15px;
  vertical-align: top;
}

.amount-words-title {
  font-size: 14px;
  font-weight: bold;
  color: #000 !important;
  margin-bottom: 8px;
  display: block;
}

.amount-words-content {
  font-size: 13px;
  color: #000 !important;
  line-height: 1.4;
  margin-top: 8px;
}

.amount-words-table .grand-total-cell {
  width: 40%;
  padding: 0;
  font-weight: bold;
  text-align: center;
  vertical-align: middle;
}

.grand-total-content {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  height: 100%;
}

.grand-total-content2 {
  border-right: 1px solid #000 !important;
  padding-right: 10px;
  flex: 1;
  text-align: right;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  color: #000 !important;
}

.grand-total-amount {
  flex: 1;
  text-align: right;
  padding-left: 10px;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  color: #000 !important;
}

/* VAT Table - FIXED COLORS */
.vat-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  font-size: 12px;
}

.vat-table th {
  background-color: #E6E6FA !important;
  border: 1px solid #000 !important;
  padding: 6px;
  text-align: center;
  font-weight: bold;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

.vat-table td {
  border: 1px solid #000 !important;
  padding: 6px;
  text-align: center;
  background-color: white !important;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

/* Terms Table - FIXED COLORS */
.terms-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  font-size: 12px;
}

.terms-table th {
  background-color: #E6E6FA !important;
  border: 1px solid #E6E6FA !important;
  padding: 8px;
  text-align: left;
  font-weight: bold;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

.terms-table td {
  background-color: #E6E6FA !important;
  border: 1px solid #E6E6FA !important;
  padding: 10px;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

/* Bottom Section Table - FIXED COLORS */
.bottom-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 12px;
}

.bottom-table td {
  border: 1px solid #000 !important;
  padding: 20px;
  vertical-align: top;
  background-color: white !important;
  color: #000 !important;
  -webkit-print-color-adjust: exact !important;
  color-adjust: exact !important;
  print-color-adjust: exact !important;
}

.bank-cell {
  width: 70%;
}

.signature-cell {
  width: 30%;
  text-align: right;
}

.bank-details h4 {
  margin: 0 0 10px 0;
  font-size: 12px;
  font-weight: bold;
  color: #000 !important;
}

.bank-details div {
  margin-bottom: 3px;
  line-height: 1.4;
  color: #000 !important;
}

.payment-terms {
  margin-top: 20px;
}

.payment-terms h4 {
  margin: 0 0 8px 0;
  font-size: 12px;
  font-weight: bold;
  color: #000 !important;
}

.payment-terms div {
  color: #000 !important;
}

.signature-content {
  text-align: right;
  color: #000 !important;
}

.signature-line {
  margin: 40px 0 15px 0;
  text-align: center;
}

.signature-box {
  width: 120px;
  height: 50px;
  margin: 10px auto;
}
</style>

</head>
<body>
<page size="A4">
<?php if ((!$companyDetails) && (!$invDetails[0])): ?>
    <p>No company details available.</p>
<?php else: ?>

<div class="main-container">
<div class="main-border">
    
    <!-- <div class="profoma-label">Profoma</div> -->
    
    <!-- Header Section -->
    <div class="header-section">
        <div class="company-logo">
            <img src="data:image/jpeg;base64,<?= base64_encode(file_get_contents(ROOTPATH . 'public/dist/img/Emax_logo.jpg')); ?>" alt="Emax Logo" style="max-width: 100%; max-height: 100%; object-fit: contain; display: block;">
        </div>
        
        <div class="company-details">
            <div class="company-name">EMAX SUPPLIES & LOGISTICS LIMITED</div>
            <div class="company-description">
                Dealers in Printing & Stationery Supplies, Relief & Non Relief Items, Groceries &<br>
                Toiletries & General Supplies
            </div>
            <div class="company-contact">
                Email: emaxsuppliesandlogisticsltd@gmail.com&nbsp;&nbsp;&nbsp;&nbsp;Mobile: +256708519877, +256706377611
            </div>
        </div>
    </div>

    <!-- Quotation Table -->
    <table class="quotation-table">
        <tr>
            <th class="quotation-header">Quotation for</th>
            <th class="ship-header">Proforma Details</th>
        </tr>
        <tr>
            <td class="company-name-cell"><?= $invDetails[0]['c_name']; ?></td>
            <td style="text-align: right; padding-right: 20px;">
                <div style="margin-bottom: 8px;"><strong>Proforma #:</strong> <?= $invDetails[0]['invid']; ?></div>
                <div><strong>Date:</strong> <?= date("Y-m-d", strtotime($invDetails[0]['created'])); ?></div>
            </td>
        </tr>
    </table>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th>#</th>
                <th>QTY</th>
                <th>Units</th>
                <th>Item</th>
                <th>Unit Price (UGX)</th>
                <th>Total (UGX)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $cnt = 1;
            foreach ($itemDetails as $item): ?>
            <tr>
                <td><?= $cnt++; ?></td>
                <td><?= number_format($item['quantity'], 0); ?></td>
                <td><?= isset($item['unit']) ? $item['unit'] : 'Kgs' ?></td>
                <td><?= $item['item_name']; ?></td>
                <td><?= number_format($item['price'], 0); ?></td>
                <td><?= number_format($item['total'], 0); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Summary Table -->
    <table class="summary-table">
        <tr>
            <td class="words-cell">
                <div class="amount-words-title">Bill Amount in Words:</div>
                <div class="amount-words-content">
                    <?php 
                    helper('number_to_words_helper');
                    // Use the English (International) system for number to words
                    if (function_exists('digtoval_en')) {
                        echo ucfirst(digtoval_en($invDetails[0]['totalamount']));
                    } else {
                        // fallback: fix for lakh/crore to million
                        $amount = $invDetails[0]['totalamount'];
                        $fmt = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
                        echo ucfirst($fmt->format($amount)) . " Ugandan shillings";
                    }
                    ?>
                </div>
            </td>
            <td class="totals-cell">
                <div class="totals-inner">
                    <div class="total-row" style="border-bottom: 1px solid #000 !important;">
                        <div class="total-label"><strong>Sub Total</strong></div>
                        <div class="total-amount"><strong><?= number_format($invDetails[0]['subtotal'], 0); ?></strong></div>
                    </div>
                    <div class="total-row">
                        <div class="total-label">VAT (<?= number_format($invDetails[0]['taxrate'], 2); ?>%) 
                            <?php 
                            $vatType = isset($invDetails[0]['vat_type']) ? $invDetails[0]['vat_type'] : 'exclusive';
                            echo $vatType === 'inclusive' ? '(Inclusive)' : '(Exclusive)';
                            ?>
                        </div>
                        <div class="total-amount"><?= number_format($invDetails[0]['taxamount'], 0); ?></div>
                    </div>
                    <div class="total-row">
                        <div class="total-label"><strong>Grand Total</strong></div>
                        <div class="total-amount"><strong><?= number_format($invDetails[0]['totalamount'], 0); ?></strong></div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Amount in Words and Grand Total Table -->
    <!-- <table class="amount-words-table">
        <tr>
            <td class="words-cell">
                <div class="amount-words-title">Bill Amount in Words:</div>
                <div class="amount-words-content">
                    <?php 
                    helper('number_to_words_helper');
                    // Use the English (International) system for number to words
                    if (function_exists('digtoval_en')) {
                        echo ucfirst(digtoval_en($invDetails[0]['totalamount']));
                    } else {
                        // fallback: fix for lakh/crore to million
                        $amount = $invDetails[0]['totalamount'];
                        $fmt = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
                        echo ucfirst($fmt->format($amount)) . " Ugandan shillings";
                    }
                    ?>
                </div>
            </td>
            <td class="grand-total-cell">
                <div class="grand-total-content">
                    <div class="grand-total-content2">Grand Total</div>
                    <div class="grand-total-amount"><?= number_format($invDetails[0]['totalamount'], 0); ?></div>
                </div>
            </td>
        </tr>
    </table> -->

    <!-- VAT Table -->
    <table class="vat-table">
        <thead>
            <tr>
                <th>VAT Status</th>
                <th>Taxable Amount</th>
                <th>Rate</th>
                <th>Tax Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php 
                    if ($invDetails[0]['taxrate'] > 0) {
                        $vatType = isset($invDetails[0]['vat_type']) ? $invDetails[0]['vat_type'] : 'exclusive';
                        echo 'Taxable (' . ucfirst($vatType) . ')';
                    } else {
                        echo 'Exempt';
                    }
                    ?>
                </td>
                <td><?= number_format($invDetails[0]['subtotal'], 0); ?></td>
                <td><?= number_format($invDetails[0]['taxrate'], 2); ?>%</td>
                <td><?= number_format($invDetails[0]['taxamount'], 0); ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Terms & Conditions Table -->
    <table class="terms-table">
        <thead>
            <tr>
                <th>Terms & Conditions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Validity Period:</strong> <?= isset($invDetails[0]['validity_period']) ? $invDetails[0]['validity_period'] : '90' ?> Days<br>
                    <strong>Delivery Period: Delivery is within</strong> <?= isset($invDetails[0]['delivery_period']) ? $invDetails[0]['delivery_period'] : '4' ?> days after LPO
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Bottom Section Table -->
    <table class="bottom-table">
        <tr>
            <td class="bank-cell">
                <div class="bank-details">
                    <h4>Bank details</h4>
                    <div>Bank Name: <strong><?= isset($bankDetails[0]) ? $bankDetails[0]['bname'] : 'EQUITY BANK UGANDA LIMITED' ?></strong></div>
                    <div>Account Number: <strong><?= isset($bankDetails[0]) ? $bankDetails[0]['ac'] : '1004201798242' ?></strong></div>
                    <div>Bank Code: <strong><?= isset($bankDetails[0]) ? $bankDetails[0]['ifsc'] : 'EQBLUGKAXXX' ?></strong></div>
                    <div>Account Name: <strong><?= isset($bankDetails[0]['account_name']) ? $bankDetails[0]['account_name'] : 'Emax Supplies & Logistics Limited' ?></strong></div>
                </div>
                
                                  <div class="payment-terms">
                      <h4>Payment Terms</h4>
                      <div><?= isset($invDetails[0]['payment_terms']) ? $invDetails[0]['payment_terms'] : 'Payment must be within 30 working days after delivery' ?></div>
                  </div>
            </td>
            <td class="signature-cell">
                <div class="signature-content">
                    <div><strong>Signed-By:</strong></div>
                    <div class="signature-line">
                        <?php if (isset($invDetails[0]['signature_path']) && !empty($invDetails[0]['signature_path'])): ?>
                            <img src="data:image/jpeg;base64,<?= base64_encode(file_get_contents(ROOTPATH . $invDetails[0]['signature_path'])); ?>" alt="Signature" style="max-width: 120px; max-height: 50px; border: 1px solid #000;">
                        <?php else: ?>
                            <div class="signature-box" style="width: 120px; height: 50px; border: 1px solid #000; margin: 10px auto;"></div>
                        <?php endif; ?>
                    </div>
                    <div>
                        <strong>On Behalf of <?= isset($companyDetails['c_name']) ? $companyDetails['c_name'] : 'EMAX SUPPLIES & LOGISTICS LIMITED' ?></strong>
                    </div>
                </div>
            </td>
        </tr>
    </table>

</div>
</div>

<?php endif; ?>
</page>

<!-- Print Button (only visible on screen) -->
<div id="printButton" style="position: fixed; top: 10px; right: 10px; z-index: 1000;">
    <button onclick="printInvoice()" style="background: #2c5aa0; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
        🖨️ Print Invoice
    </button>
</div>

<script>
  var base_url = "<?= base_url(); ?>";
  
  function printInvoice() {
    // Hide the print button before printing
    document.getElementById('printButton').style.display = 'none';
    
    // Print the page
    window.print();
    
    // Show the print button again after print dialog closes
    setTimeout(function() {
      document.getElementById('printButton').style.display = 'block';
    }, 1000);
  }
  
  // Auto-hide print button when printing
  window.addEventListener('beforeprint', function() {
    document.getElementById('printButton').style.display = 'none';
  });
  
  window.addEventListener('afterprint', function() {
    document.getElementById('printButton').style.display = 'block';
  });
</script>

</body>
</html>