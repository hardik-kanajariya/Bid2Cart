<pre>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Importing HTML2PDF
use Spipu\Html2Pdf\Html2Pdf;

// Load Composer's autoloader
require '../vendor/autoload.php';

// Connecting with database
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'auction';
$conn = mysqli_connect($server, $username, $password, $database);
$invoice_logo = "https://as1.ftcdn.net/v2/jpg/03/05/98/36/1000_F_305983642_2Xbbv0GJrtkRULOkRc8i8QgJcCMVFkJ8.jpg";

// Getting server URl
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']
    === 'on' ? "https" : "http") .
    "://" . $_SERVER['HTTP_HOST'];

if ($_GET['brand']) {
    $brand_name = $_GET['brand'];
    // Getting Auction details
    $auction = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `auction` WHERE status = 'active'"));
    $aid = $auction['aid'];
    $bid_start = $auction['start_date'] . ' ' . $auction['start_time'];
    $bid_end = $auction['end_date'] . ' ' . $auction['end_time'];

    // getting invoice settings
    $i_settings  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from invoice_settings where id = '1'"));
    $tax = $i_settings['tax'];
    $b2c_fee = $i_settings['b2c_fee'];
    // generating invoice
    $result = mysqli_query($conn, "SELECT * FROM product where brand_name = '$brand_name' AND auction_id = '$aid'");
    $total_brand_products = mysqli_num_rows($result);
    $product_with_no_bids = 0;
    $i = 1;
    $user_total_products = 0;
    $user_total_purchase = 0;
    $user_total_sell = 0;
    $user_tax_amount = 0;
    $user_b2c_amount = 0;
    $user_total = 0;
    // Final total variables
    $total_purchase = 0;
    $total_sells = 0;
    $total_tax = 0;
    $total_b2c_fee = 0;
    $invoice_row = '';
    while ($row = mysqli_fetch_assoc($result)) {
        print_r($row);
        // fetching product details
        $pid = $row['prd_id'];
        $invoice_number = strtoupper($brand_name) . '-' . time();

        // getting username from bidhistory
        $bid_history_data = mysqli_query($conn, "SELECT * FROM bid_history WHERE product_id = '$pid'");
        while ($bhd = mysqli_fetch_assoc($bid_history_data)) {
            $username = $bhd['bidder'];

            // Get user wise total products
            $user_total_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bid_history WHERE bidder = '$username'"));

            // get products from bidder
            $total_details = mysqli_query($conn, "SELECT * FROM bid_history WHERE bidder = '$username' AND product_id = '$pid' ORDER BY created_at DESC LIMIT 1");
            while ($td = mysqli_fetch_assoc($total_details)) {
                $total_product_id = $td['product_id'];
                $product_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM product where prd_id = '$total_product_id' AND auction_id = '$aid'"));
                $user_total_purchase = $user_total_purchase + $product_data['purchase_price'];
                $user_total_sell = $user_total_sell + $product_data['current_bid'];

                $user_tax_amount = $user_tax_amount + (($product_data['current_bid'] * $tax) / 100);
                $user_b2c_amount = $user_b2c_amount + (($product_data['current_bid'] * $b2c_fee) / 100);

                $user_total = $user_total + $user_total_purchase + $user_total_sell + $user_tax_amount + $user_b2c_amount;

                // getting final total
                $total_purchase = $total_purchase + $user_total_purchase;
                $total_sells = $total_sells + $user_total_sell;
                $total_tax = $total_tax + $user_tax_amount;
                $total_b2c_fee = $total_b2c_fee + $user_b2c_amount;
            }

            $invoice_row .= "<tr style='text-align: center;'>
                                <td>$i</td>
                                <td>$username</td>
                                <td>$user_total_products</td>
                                <td>$user_total_purchase</td>
                                <td>$user_total_sell</td>
                                <td>$user_tax_amount</td>
                                <td>$user_b2c_amount</td>
                                <td>$user_total</td>
                            </tr>";
                            $i++;
        }

        if ($current_bid == 1) {
            $product_with_no_bids++;
        }
    }

    $html2pdf = new Html2Pdf();
    $htmlPDF = '<page> <!-- PDF Styling --> <style> table { border-collapse: collapse; width: 100%; font-size: 14px; margin-top: 10px; } .left { float: left; } td.w-10 { width: 10%; } td.w-40 { width: 40%; } td.w-100 { width: 100%; } td.w-33 { width: 33%; } table, td, th { border: 2px solid #000; } th { font-weight: normal; text-align: center; padding: 5px 5px 0px 5px; background-repeat: repeat-x; height: 25px; font-size: 16px; font-weight: bold; border: 1px solid #000; } td { padding: 16px 3px 3px 3px; border: 1px solid #000; } @frame footer { -pdf-frame-content: footerContent; bottom: 2cm; margin-left: 1cm; margin-right: 1cm; border: none !important; } </style><!-- Logo and Title --> <div class="row"> <div class="col-12"> <img src="' . $invoice_logo . '" style="align:left; display:inline;" height="100" width="100" /> <h3 class="text-center po" align="right" style="text-transform: uppercase;font-weight: bolder; color:#887d7d; margin-top:-100px;">Brand Invoice </h3> </div> </div><!-- Header Details Table --> <table class="table"> <thead> <tr> <th align="left" style="width: 50%">Brand Details</th> <th align="right" style="width: 50%">Invoice Details</th> </tr> </thead> <tbody> <tr> <td>Brand Name: ' . $brand_name . ' <br> Total Products: ' . $total_brand_products . ' <br> Product with no bids: ' . $product_with_no_bids . '</td> <td align="right"> Invoice Date: ' . date("d/m/Y") . ' <br /> Invoice No. : ' . $invoice_number . ' <br /> Auction start: ' . $bid_start . ' <br /> Auction end: ' . $bid_end . ' <br /> </td> </tr> </tbody> </table> <table class="table table-bordered" style=" border: 1px solid;"> <thead> <tr style="text-align: center; border: 1px solid;"> <th style="text-align: center;">#</th> <th style="text-align: center;">username</th> <th style="text-align: center;">Total products</th> <th style="text-align: center;">Total Purchase price</th> <th style="text-align: center;">Total Sell Price</th> <th style="text-align: center;">Tax</th> <th style="text-align: center;">B2C Fee</th> <th style="text-align: center;">Total</th> </tr> </thead> <tbody> <!-- Invoice Row --> ' . $invoice_row . ' <!-- Invoice Total Row --> <tr> <td colspan="7">Total Purchase: </td> <td>' . $total_purchase . '</td> </tr> <tr> <td colspan="7">Total Sell: </td> <td>' . $total_sells . '</td> </tr> <tr> <td colspan="7">Total Tax: </td> <td>' . $total_tax . '</td> </tr> <tr> <td colspan="7">Total B2C Fee: </td> <td>' . $total_b2c_fee . '</td> </tr> </tbody> </table> <!-- PDf footer [Company Details] --> <page_footer> <div class="page_footer" style="border: none"> <div> <div style="width: 100%; text-align: center; color:#758DA6"> Bid2Cart Auction House, some address,pin-76XXXX, phone:9000000XXX <br /> www.bid2cart.ca </div> </div> </div> </page_footer></page>';
    $html2pdf->writeHTML($htmlPDF);
    ob_clean();
    $pdf = $brand_name . '_' . time() . '.pdf';
    $html2pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/invoice/brand/$pdf", 'f');

    // Inserting record into Database
    if (mysqli_query($conn, "INSERT INTO `brand_invoice` (`auction_id`, `brand_name`, `invoice_number`, `total_purchase`, `total_sells`, `total_tax`, `total_b2c_fee`, `profit`, `loss`, `pdf`, `created_at`, `updated_at`) VALUES ('$aid', '$brand_name', '$invoice_number', '$total_purchase', '$total_sells', '$total_tax', '$total_b2c_fee', '', '', '$pdf', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP());")) {
        header("Location: $url/invoice/brand/$pdf");
    } else {
        echo "unable to insert brand record into database: " . mysqli_error($conn);
    }
} else {
    echo "Invalid Request";
}
