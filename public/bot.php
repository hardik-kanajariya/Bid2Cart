<pre>
<?php
$start_time = microtime(true);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Importing PHPMAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Importing HTML2PDF
use Spipu\Html2Pdf\Html2Pdf;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Create an instance; passing `true` enables exceptions

$mail = new PHPMailer(true);

// Connecting with database
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'bid2cart';
$conn = mysqli_connect($server, $username, $password, $database);

// SMTP Server settings
$mail->isSMTP(); // Send using SMTP
$mail->Host       = 'smtp.hostinger.com'; // Set the SMTP server to send through
$mail->SMTPAuth   = true; // Enable SMTP authentication
$mail->Username   = 'support@bid2cart.sudbury.me'; // SMTP username
$mail->Password   = 'support@Bid2cart'; // SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
$mail->Port = 465;
$mail->isHTML(true); //Set email format to HTML
$mail->Subject = 'Bid2Cart Winners Invoice';
$mail->setFrom('support@bid2cart.sudbury.me', 'Bid2Cart Auction House');

// Log tracking
$logs = array();

// Getting server URl
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']
=== 'on' ? "https" : "http") .
"://" . $_SERVER['HTTP_HOST'];
array_push($logs, date('d/m/Y h:i:s a', time()) . "|  server url: " . $url);

// Global variables
$invoice_logo = "https://as1.ftcdn.net/v2/jpg/03/05/98/36/1000_F_305983642_2Xbbv0GJrtkRULOkRc8i8QgJcCMVFkJ8.jpg";
$invoice_row = '';
$bid_start = '';
$bid_end = '';

// Getting Current Active Auctions Id
array_push($logs, date('d/m/Y h:i:s a', time()) . "|  fetching auction id");
$aid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `auction` WHERE `status` = 'active'"));

if ($aid) {
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  auction id fetched and its not null");
    $aid = $aid['aid'];
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  auction id is " . $aid);

    // Getting All Products Data
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Fetching product data");
    $result = mysqli_query($conn, "SELECT * FROM `product` WHERE auction_id = $aid");
    while ($data = mysqli_fetch_assoc($result)) {
        // Getting Product Id and checking if this id is exist in BidHistory or not
        $pid = $data['prd_id'];
        $brand_name = $data['brand_name'];
        $product_name = $data['title'];
        $bid_start = date("Y-m-d h:i:sa", strtotime($data['start_time']));
        $bid_end = date("Y-m-d h:i:sa", strtotime($data['end_time']));
        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  counting total products in bid history");
        $count = mysqli_query($conn, "SELECT COUNT(product_id) AS 'data' FROM bid_history WHERE product_id = $pid;");
        $count = mysqli_fetch_assoc($count);
        if ($count['data'] > 0) {
            // Getting Latest Record
            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Fetching Max Bid amount using product id: $pid");
            $max_amount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(amount) as winning_bid FROM `bid_history` WHERE product_id = '$pid';"));
            $max_amount = $max_amount['winning_bid'];
            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Fetching Winners Bid Details using max bid amount: $max_amount");
            $latestBid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `bid_history` WHERE amount = '$max_amount';"));
            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Winners bid details fetched successfully");
            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  user id is " . $latestBid['user_id']);
            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  bidder is " . $latestBid['bidder']);
            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  product id is " . $latestBid['product_id']);
            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  bid status is " . $latestBid['status']);
            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  winning amount is " . $max_amount);

            // Insert Records into results Table
            $user_id = $latestBid['user_id'];
            $product_id = $latestBid['product_id'];
            $status = $latestBid['status'];
            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  started inserting records into results");
            if (mysqli_query($conn, "INSERT INTO `results` (`auction_id`, `user_id`, `product_id`, `result`, `created_at`, `updated_at`) VALUES ('$aid', '$user_id', '$product_id', '$status', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP());")) {
                echo "Results Inserted";
                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  records inserted into records table");

                // Insert invoice record
                $auction_id = $aid;
                // Getting Store Id
                $store_id = '1';
                // Getting Brand Id
                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  fetching brand id");
                $bid = mysqli_fetch_assoc(mysqli_query($conn, "select * from `brands` where brand_name = '$brand_name'"));
                $brand_id = $bid['id'];
                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  brand id is $brand_id");
                // Getting last invoice number
                // $lastInvoiceNumber = mysqli_fetch_assoc(mysqli_query($conn, "SELECT invoice_number from invoice order by invoice_number DESC LIMIT 1"));
                $invoice_number = 'HB2C-' . time(); // HB2C -> Store Code
                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  invoice number generated : $invoice_number");

                // Getting users details
                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  fetching user details");
                $userDetails  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from users WHERE userid = '$user_id'"));
                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  user details fetched");
                $first_name = $userDetails['first_name'];
                $last_name = $userDetails['last_name'];
                $fullname = $userDetails['first_name'] . ' ' . $userDetails['last_name'];
                $user_email = $userDetails['email'];
                $phone = $userDetails['phone'];
                $username = $userDetails['username'];

                // Getting invoice Ads
                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  fetching invoice ads");
                $random_ad_id = array();
                $ads_result = mysqli_query($conn, "SELECT * from invoice_ads where status = 'active'");
                if ($ads_result) {
                    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  invoice ads fetched");
                    while ($adid = mysqli_fetch_assoc($ads_result)) {
                        array_push($random_ad_id, $adid['id']);
                    }
                    // Getting random invoice Ads
                    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  getting random ad from invoice ads");
                    $random_ad_id = $random_ad_id[rand(0, count($random_ad_id) - 1)];
                    $invoice_ads  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from invoice_ads where id = '$random_ad_id'"));
                    $ad_image = $_SERVER['DOCUMENT_ROOT'] . '/uploads/advertisements/' . $invoice_ads['image'];
                    $ad_link = $invoice_ads['link'];
                    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  started inserting records into invoice table");
                    $sql = "INSERT INTO `invoice` (aid, uid, pid, sid, bid, invoice_number, product_name, winning_amount, first_name, last_name, username, created_at, updated_at) VALUES('$aid', '$user_id', '$product_id', '$store_id', '$brand_id', '$invoice_number', '$product_name', '$max_amount', '$first_name', '$last_name', '$username', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())";

                    if (mysqli_query($conn, $sql)) {
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  invoice record inserted");
                        // Getting invoice Settings
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  fetching invoice tax and b2c fee details");
                        $i_settings  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from invoice_settings where id = '1'"));
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  tax and B2C fee details fetched");
                        $tax = $i_settings['tax'];
                        $b2c_fee = $i_settings['b2c_fee'];
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  tax = $tax and B2C fee is $b2c_fee");

                        // Getting Invoice Details from database using userid and auction id
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  fetching invoice rows");
                        $invoice_rows_result = mysqli_query($conn, "SELECT * FROM invoice WHERE aid = '$aid' AND uid = '$user_id'");

                        $invoice_total = 0;
                        $i = 1;
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  invoice rows fetched");
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  generating PDF and email invoice rows");
                        while ($invoice_rows = mysqli_fetch_assoc($invoice_rows_result)) {
                            $pname = $invoice_rows['product_name'];
                            $max_amount = $invoice_rows['winning_amount'];
                            $tax_amount = ((int)$max_amount * $tax) / 100;
                            $b2c_amount = ((int)$max_amount * $b2c_fee) / 100;
                            $product_total = (int)$max_amount + $tax_amount + $b2c_amount;

                            // Generating Rows for PDFs
                            $invoice_row .= "<tr style='text-align: center;'>
                                                    <td style='width: 10px;'>$i</td>
                                                    <td style='width: 150px;'>$pname</td>
                                                    <td>$max_amount</td>
                                                    <td>$tax_amount</td>
                                                    <td>$b2c_amount</td>
                                                    <td>$product_total</td></tr>";
                            $invoice_total = $invoice_total + $product_total;
                            $i++;
                        }

                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  rows generated");

                        // Generating invoice PDF
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  generating invoice pdf");
                        $html2pdf = new Html2Pdf();
                        $htmlPDF = '<page><!-- PDF Styling --><style> table { border-collapse: collapse; width: 100%; font-size: 14px; margin-top: 10px; } .left { float: left; } td.w-10 { width: 10%; } td.w-40 { width: 40%; } td.w-100 { width: 100%; } td.w-33 { width: 33%; } table, td, th { border: 2px solid #000; } th { font-weight: normal; text-align: center; padding: 5px 5px 0px 5px; background-repeat: repeat-x; height: 25px; font-size: 16px; font-weight: bold; border: 1px solid #000; } td { padding: 16px 3px 3px 3px; border: 1px solid #000; } @frame footer { -pdf-frame-content: footerContent; bottom: 2cm; margin-left: 1cm; margin-right: 1cm; border: none !important; }</style><!-- Logo and Title --><div class="row"> <div class="col-12"> <img src="' . $invoice_logo . '" style="align:left; display:inline;" height="100" width="100" /> <h3 class="text-center po" align="right" style="text-transform: uppercase;font-weight: bolder; color:#887d7d; margin-top:-100px;">Bid2Cart Invoice</h3> </div></div><!-- Header Details Table --><table class="table"> <thead> <tr> <th align="left" style="width: 50%">User Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th> <th align="right" style="width: 50%">Invoice Details</th> </tr> </thead> <tbody> <tr> <td> ' . $fullname . ' <br /> Username: ' . $username . ' <br /> Phone: ' . $phone . ' <br /> Email: ' . $user_email . ' <br /> </td> <td align="right"> Invoice Date: ' . date("d/m/Y") . ' <br /> Invoice No. : ' . $invoice_number . ' <br /> Auction start: ' . $bid_start . ' <br /> Auction end: ' . $bid_end . ' <br /> </td> </tr> </tbody></table><table class="table table-bordered" style=" border: 1px solid;"> <thead> <tr style="text-align: center; border: 1px solid;"> <th style="text-align: center;">#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> <th style="width: 25%" style="text-align: center;"> Product Name#&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th> <th style="text-align: center;"> Bid price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> <th style="text-align: center;">Tax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> <th style="text-align: center;">B2C Fee&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> <th style="text-align: center;">Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th> </tr> </thead> <tbody> <!-- Invoice Row --> ' . $invoice_row . ' <!-- Invoice Total Row --> <tr> <td colspan="4"></td> <td>Due Amount</td> <td>' . $invoice_total . '</td> </tr> </tbody></table><!-- Terms & Conditions --><div class="row"> <div class="col-lg-12"> <h4>Terms & Conditions</h4> <ol> <li>Payment Terms: 30 days from delivery</li> <li>Enter this order in accordance with the prices, terms, delivery method, and specifications listed above.</li> <li>Please notify us immediately if you are unable to ship as specified.</li> </ol> </div></div><br><br><br><!-- Advertisement Image --><table width="30%" style="float: left; text-align: center; border: none;" align="left"> <tbody width="30%" style="border: none;"> <tr> <td style="border: none;"> <a href="' . $ad_link . '"> <img src="' . $ad_image . '" width="720" height="90" /> </a> </td> </tr> </tbody></table><!-- PDf footer [Company Details] --><page_footer> <div class="page_footer" style="border: none"> <div> <div style="width: 100%; text-align: center; color:#758DA6"> Bid2Cart Auction House, some address,pin-76XXXX, phone:9000000XXX <br /> www.bid2cart.ca </div> </div> </div></page_footer></page>';
                        $html2pdf->writeHTML($htmlPDF);
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  PDF written successfully");
                        ob_clean();
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  PDF buffer cleared");
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  generating pdf name");
                        $pdf = $username . '_' . $invoice_number . '_' . time() . '.pdf';
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  generated PDF name is : $pdf");
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Saving invoice pdf to server storage");
                        $html2pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/invoice/$pdf", 'f');
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  PDF stored successfully");
                        // Inserting PDF To invoice Details
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  inserting pdf to invoice records");
                        if (mysqli_query($conn, "UPDATE `invoice` SET `pdf` = '$pdf', `invoice_total` = '$invoice_total' WHERE `invoice_number` = '$invoice_number'")) {
                            // Add user invoice attachments
                            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  invoice records updated successfully");
                            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  removing products from users watchlist...");
                            // Deleting Products from watchlist
                            if (mysqli_query($conn, "DELETE FROM `watch_list` WHERE product_id = '$product_id'")) {
                                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  product removed from users watchlist");
                            } else {
                                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  product removing failed due to : " . mysqli_error($conn));
                            }

                            // Updating product End time
                            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Updating Product End Time...");
                            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Auction id is $auction_id");
                            if (mysqli_query($conn, "UPDATE `product` SET `end_time` = CURRENT_TIMESTAMP(), `auction_status` = 'expired' WHERE `auction_id` = '$auction_id';")) {
                                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Product End time updated...");
                                // Setting Running Auction status to Completed
                                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  updating auction status...");
                                 if (mysqli_query($conn, "UPDATE `auction` SET status = 'done' WHERE status = 'active';")) {
                                     echo "Auction Status Changed";
                                     array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Auction status updated");
                                     array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Log tracing complete... for user $username");
                                     array_push($logs, date('d/m/Y h:i:s a', time()) . "|  -----------------------------------------------");
                                 } else {
                                     echo "Auction Status is not changed";
                                     array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Auction status is failed to update");
                                 }
                            } else {
                                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Product End Time is not updated Error: " . mysqli_error($conn));
                            }
                        } else {
                            echo "Invoice pdf Generated but failed to insert into database";
                            array_push($logs, date('d/m/Y h:i:s a', time()) . "|  pdf generated but failed to insert it into database");
                        }
                    } else {
                        echo 'Invoice not Generated';
                        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Invoice not generated");
                    }
                } else {
                    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  invoice ads fetching failed: " . mysqli_error($conn));
                }
            } else {
                echo "Something went wrong Results not inserted";
                array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Something went wrong Results not inserted");
            }
        } else {
            echo $data['title'] . " is not available in History <br>";
            array_push($logs, date('d/m/Y h:i:s a', time()) . ' ' . $data['title'] . " Product id =>[ $pid ]<= is not available in History");
        }
    }
} else {
    echo "No Auctions are Active, so invoice can not be generated";
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  No Auctions are Active, so invoice can not be generated");
}

// Sending Mail to Winners
array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Getting invoice details for sending mail");
$result = mysqli_query($conn, "SELECT * FROM `invoice` WHERE `aid` = '$aid'");
while ($row = mysqli_fetch_assoc($result)) {
    array_push($logs, date('d/m/Y h:i:s a', time()) . "| Getting user details from invoice details");
    $user_id = $row['uid'];
    $invoice_number = $row['invoice_number'];
    $invoice_total = $row['invoice_total'];
    $pdf = $row['pdf'];

    // echo ($pdf);
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE userid = '$user_id'"));

    $username = $user['username'];
    $phone = $user['phone'];
    $user_email = $user['email'];
    // Sending Mail to user
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  ready to send email");
    $mail->addAddress($user_email, $username); // Add a recipient
    $mail->addAttachment($_SERVER['DOCUMENT_ROOT'] . "/invoice/$pdf");
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  PDF attached successfully : $pdf");
    $mail->Body    = '<!DOCTYPE html><html lang="en"><head itemscope="" itemtype="http://schema.org/WebSite"> <title itemprop="name">Bid2Cart Email Invoice</title> <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"> <style type="text/css"> body { margin-top: 20px; background: #eee; } /*Invoice*/ .invoice .top-left { font-size: 65px; color: #3ba0ff; } .invoice .top-right { text-align: right; padding-right: 20px; } .invoice .table-row { margin-left: -15px; margin-right: -15px; margin-top: 25px; } .invoice .payment-info { font-weight: 500; } .invoice .table-row .table>thead { border-top: 1px solid #ddd; } .invoice .table-row .table>thead>tr>th { border-bottom: none; } .invoice .table>tbody>tr>td { padding: 8px 20px; } .invoice .invoice-total { margin-right: -10px; font-size: 16px; } .invoice .last-row { border-bottom: 1px solid #ddd; } @media(max-width:575px) { .invoice .top-left, .invoice .top-right, .invoice .payment-details { text-align: center; } .invoice .from, .invoice .to, .invoice .payment-details { float: none; width: 100%; text-align: center; margin-bottom: 25px; } .invoice p.lead, .invoice .from p.lead, .invoice .to p.lead, .invoice .payment-details p.lead { font-size: 22px; } .invoice .btn { margin-top: 10px; } } @media print { .invoice { width: 900px; height: 800px; } } </style> <body> <div class="container bootstrap snippets bootdeys"> <div class="row"> <div class="col-sm-12"> <div class="panel panel-default invoice" id="invoice"> <div class="panel-body"> <div class="row"> <div class="col-sm-6 top-left">Bid2Cart</div> <div class="col-sm-6 top-right"> <h3 class="marginright">' . $invoice_number . '</h3> <span class="marginright">' . date('d/m/Y') . '</span> </div> </div> <hr> <div class="row"> <div class="col-xs-6 to"> <p class="lead marginbottom">To : ' . $username . '</p> <p>425 Market Street</p> <p>Suite 2200, San Francisco</p> <p>California, 94105</p> <p>Phone: ' . $phone . '</p> <p>Email: ' . $user_email . '</p> </div> <div class="col-xs-6 text-right payment-details"> <p class="lead marginbottom payment-info">Invoice details</p> <p>Total Amount: ' . $invoice_total . '</p> <p>Auction Start: ' . $bid_start . '</p> <p>Auction End: ' . $bid_end . '</p> </div> </div> <div class="row table-row"> <table class="table table-striped"> <thead> <tr> <th class="text-center" style="width:5%">#</th> <th style="width:50%">Product Name</th> <th class="text-right" style="width:15%">Bid Price</th> <th class="text-right" style="width:15%">B2C Fee</th> <th class="text-right" style="width:15%">Tax</th> <th class="text-right" style="width:15%">Total</th> </tr> </thead> <tbody>' . $invoice_row . '</tbody> </table> </div> <div class="row"> <div class="col-xs-12 margintop text-center"> <a href="' . $ad_link . '"> <img alt="advertisement" src="' . $ad_image . '"/> </a></div> </div> <div class="row"> <div class="col-xs-6 margintop"> <p class="lead marginbottom">THANK YOU!</p> </div> <div class="col-xs-6 text-right pull-right invoice-total"> <p>Total : $' . $invoice_total . '</p> </div> </div> <div class="row"> <div class="col-xs-6 margintop"> <p class="lead marginbottom">Terms & Conditions</p> <li>Conditions 1</li> <li>Conditions 2</li> <li>Conditions 3</li> </div> <div class="col-xs-6 text-right pull-right invoice-total"> <p>To get above listed products please Agree to this invoice</p> <a href="" class="btn btn-success">Agree to this Invoice</a> </div> </div> </div> </div> </div> </div> </div> </body></html>';
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  sending mail to user...");
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  user email is $user_email");
    try {
        $mail->send();
        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Mail sent successfully");
        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Removing Recipients...");
        $mail->ClearAllRecipients();
        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Removing Attachments...");
        $mail->ClearAttachments();
        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  **********************************************");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        array_push($logs, date('d/m/Y h:i:s a', time()) . "|  **********************************************");
    }
}


// If Manually Winners announced
if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['manual'] == 'true') {
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  results declared manually...");

    // calculating script execution time
    $end_time = microtime(true);
    $execution_time = ($end_time - $start_time);
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Time taken to execute job is $execution_time sec");

    // Inserting log records
    $job_number = 'JOB-' . time();
    $record = json_encode($logs);
    if (mysqli_query($conn, "INSERT INTO logs (auction_code, job_number, record, created_at, updated_at) VAlUES ('$aid', '$job_number', '$record', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())")) {
        header("Location: $url/settings");
    } else {
        echo 'Logs not inserted ' . mysqli_error($conn);
    }
} else {
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  results declared by cron job...");
    // Calculating script execution time
    $end_time = microtime(true);
    $execution_time = ($end_time - $start_time);
    array_push($logs, date('d/m/Y h:i:s a', time()) . "|  Time taken to execute job is $execution_time sec");

    // Inserting Log Records
    $job_number = 'JOB-' . time();
    $record = json_encode($logs);
    mysqli_query($conn, "INSERT INTO logs (auction_code, job_number, record, created_at, updated_at) VAlUES ('$aid', '$job_number', '$record', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())");
    echo "Results declared by Cron job";
}
