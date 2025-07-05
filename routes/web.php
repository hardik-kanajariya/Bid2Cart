<?php

use App\Http\Controllers\Ads;
use App\Http\Controllers\Auction;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\Brand as ControllersBrand;
use App\Http\Controllers\Category;
use App\Http\Controllers\History;
use App\Http\Controllers\Invoice;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ManageBids;
use App\Http\Controllers\Products;
use App\Http\Controllers\Settings;
use App\Http\Controllers\Store;
use App\Http\Controllers\Support;
use App\Http\Controllers\User;
use App\Mail\DummyMail;
use App\Mail\EmailVerify;
use App\Models\Auction as ModelsAuction;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin'], function () {

    // Testing Routes -----------------------------------------------------------

    Route::get('/mail', function () {
        return view('mails.result');
    });

    Route::get('/login/{provider}', [SocialController::class, 'redirect']);
    Route::get('/login/{provider}/callback', [SocialController::class, 'callback']);

    // Mail Testing
    Route::get('/mail-testing', function () {
        return view('mails.forgot-password');
        // Mail::to('joniwi8897@haboty.com')->send(new DummyMail());
        // if (Mail::failures()) {
        //     return response('Sorry! Please try again latter');
        // } else {
        //     return response('Great! Successfully send in your mail');
        // }
        // Mail::to('joniwi8897@haboty.com')->send(new EmailVerify('MyUserName', 'joniwi8897@haboty.com'));
        // if (Mail::failures()) {
        //     return response('Sorry! Please try again latter');
        // } else {
        //     return response('Great! Successfully send in your mail');
        // }
    });

    // Testing Routes Ends Here -------------------------------------------------------

    // Admin Authentication Routes
    Route::get('login', [Authentication::class, 'viewAdminLogin']);
    Route::post('0Auth2/login', [Authentication::class, 'adminLogin']);
    Route::get('/logout', [Authentication::class, 'adminLogout']);


    // Routes for Production Mails Sending & getting Response
    Route::get('/verify/mail/{key}/{hash}', [MailController::class, 'verifyMail']);

    Route::group(['middleware' => 'adminLogin'], function () {

        // Dashboard Function [Index Function]
        Route::get('/', function () {
            $productsCount = Product::all()->count();
            $userCount = ModelsUser::all()->count();
            $auctionCount = ModelsAuction::all()->count();
            $data = compact('productsCount', 'userCount', 'auctionCount');
            return view('welcome')->with($data);
        });

        // Category Routes
        Route::get('/category', [Category::class, 'viewCategory']);
        Route::post('/add-new-category', [Category::class, 'addNewCategory']);
        Route::post('/update-category', [Category::class, 'updateCategory']);
        Route::get('/delete-category/{id}/{img}', [Category::class, 'deleteCategory']);

        // Auction Handling Routes
        Route::get('/auctions', [Auction::class, 'viewAuction'])->name('view-auction-schedule');
        Route::get('/auctions/add/schedule', [Auction::class, 'viewScheduleAuction'])->name('schedule-new-auction');
        Route::post('/auctions/add/schedule', [Auction::class, 'addAuctionSchedule'])->name('schedule-new-auction');
        Route::post('/auctions/schedule/update', [Auction::class, 'updateAuctionSchedule'])->name('schedule-update');
        Route::get('/auctions/schedule/delete/{id}', [Auction::class, 'deleteSchedule']);
        Route::get('/auctions/status/{id}/{status}', [Auction::class, 'updateScheduleStatus']);

        // Routes for Managing Products
        Route::get('/auctions/products', [Products::class, 'viewProducts']);
        Route::get('/auctions/add/product', [Products::class, 'viewAddProduct']);
        Route::post('/auctions/add/product', [Products::class, 'addProduct'])->name('add-new-product');
        Route::get('/product/{productid}/{productname}', [ManageBids::class, 'viewProductBidHistory']);
        Route::get('/auction/product/update/{id}/{title}', [Products::class, 'viewUpdateProduct']);
        Route::post('/auction/product/update', [Products::class, 'updateProduct'])->name('update-product');
        Route::get('/auction/product/delete/{id}', [Products::class, 'deleteProduct']);
        Route::get('/auction/product/update/gallery/{id}/{title}', [Products::class, 'viewUpdateGallery']);
        Route::post('/update/gallery', [Products::class, 'updateGallery']);

        // Brand management Routes
        Route::get('/auctions/brands', [ControllersBrand::class, 'viewBrands']);
        Route::post('/insert/brand', [ControllersBrand::class, 'insertBrand']);
        Route::post('/update/brand', [ControllersBrand::class, 'updateBrand']);
        Route::get('/delete/brand/{id}', [ControllersBrand::class, 'deleteBrand']);

        // Store management Routes
        Route::get('/auctions/stores', [Store::class, 'viewStores']);
        Route::get('/auctions/stores/new', [Store::class, 'viewAddStores']);
        Route::get('/auctions/stores/update/{id}/{name}', [Store::class, 'viewUpdateStore']);
        Route::get('/auctions/stores/delete/{id}', [Store::class, 'deleteStore']);
        Route::post('/auctions/stores/new', [Store::class, 'addNewStores']);
        Route::post('/auctions/stores/update/{id}', [Store::class, 'updateStore']);
        Route::get('/auctions/stores/status/{id}/{status}', [Store::class, 'updateStoreStatus']);

        // Invoice-ads management Routes
        Route::get('/auctions/invoice-ads', [Ads::class, 'viewAds']);
        Route::post('/insert/ads', [Ads::class, 'insertNewAdvertisement']);
        Route::post('/update/ads', [Ads::class, 'updateNewAdvertisement']);
        Route::get('/auctions/ads/status/{id}/{status}', [Ads::class, 'updateAdsStatus']);
        Route::get('/delete/ads/{id}/{image}', [Ads::class, 'deleteAds']);

        // Settings Routes
        Route::get('/settings', [Settings::class, 'viewSettings']);
        Route::post('/settings/invoice', [Settings::class, 'updateInvoiceSettings']);
        Route::post('/settings/{update}', [Settings::class, 'updateSettings']);

        // User Management Routes
        Route::get('/users', [User::class, 'viewUser']);
        Route::get('/users/update/{id}/{stt}', [User::class, 'updateStatus']);
        Route::get('/users/{id}/{name}', [User::class, 'viewManageUser']);

        // Request Routes
        Route::get('/request/contact', [Support::class, 'viewContact']);
        Route::get('/request/contact/{id}/{stt}', [Support::class, 'updateContact']);
        Route::get('/request/supports', [Support::class, 'viewSupportRequest']);
        Route::get('/request/supports/{sid}/{pid}/{username}', [Support::class, 'viewManageSupportRequest']);
        Route::post('/request/supports/reply', [Support::class, 'replyUser']);
        Route::get('/request/pickup', [Support::class, 'viewPickups']);
        Route::get('/request/pickup/status/{pid}/{status}', [Support::class, 'managePickups']);

        // Routes For Invoices
        Route::get('/invoice/all', [Invoice::class, 'viewInvoices']);
        Route::get('/invoice/delete/{id}', [Invoice::class, 'deleteInvoices']);
        Route::get('/invoice/companies', [Invoice::class, 'viewBrandInvoice']);
        Route::get('/brand/invoice/delete/{id}', [Invoice::class, 'deleteBrandInvoice']);
    });
});
