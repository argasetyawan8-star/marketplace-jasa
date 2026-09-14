<?php

use Illuminate\Support\Facades\Route;

// --------------------------------------------------------------------------
// Admin Controllers
// --------------------------------------------------------------------------

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CommissionController as AdminCommissionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;

// --------------------------------------------------------------------------
// Client Controllers
// --------------------------------------------------------------------------

use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\FavoriteController as ClientFavoriteController;
use App\Http\Controllers\Client\MessageController as ClientMessageController;
use App\Http\Controllers\Client\OfferController as ClientOfferController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\DeliveryController as ClientDeliveryController;

// --------------------------------------------------------------------------
// Freelancer Controllers
// --------------------------------------------------------------------------

use App\Http\Controllers\Freelancer\DashboardController as FreelancerDashboardController;
use App\Http\Controllers\Freelancer\DeliveryController as FreelancerDeliveryController;
use App\Http\Controllers\Freelancer\MessageController as FreelancerMessageController;
use App\Http\Controllers\Freelancer\OfferController as FreelancerOfferController;
use App\Http\Controllers\Freelancer\OrderController as FreelancerOrderController;
use App\Http\Controllers\Freelancer\ProfileController as FreelancerProfileController;
use App\Http\Controllers\Freelancer\ServiceController as FreelancerServiceController;
use App\Http\Controllers\Freelancer\WalletController as FreelancerWalletController;
use App\Http\Controllers\Freelancer\WithdrawalController as FreelancerWithdrawalController;

// --------------------------------------------------------------------------
// Marketplace Controllers
// --------------------------------------------------------------------------

use App\Http\Controllers\Marketplace\CategoryController;
use App\Http\Controllers\Marketplace\FreelancerController;
use App\Http\Controllers\Marketplace\HomeController;
use App\Http\Controllers\Marketplace\SearchController;
use App\Http\Controllers\Marketplace\ServiceController;

// --------------------------------------------------------------------------
// Other Controllers
// --------------------------------------------------------------------------

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Marketplace
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [HomeController::class, 'index']
)->name('marketplace.home');

Route::get(
    '/search',
    [SearchController::class, 'index']
)->name('marketplace.search');

Route::get(
    '/category/{slug}',
    [CategoryController::class, 'show']
)->name('marketplace.category');

Route::get(
    '/service/{slug}',
    [ServiceController::class, 'show']
)->name('marketplace.service');


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'show']
    )->name('profile.show');

    Route::get(
        '/profile/edit',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::put(
        '/profile/password',
        [ProfileController::class, 'updatePassword']
    )->name('password.update');

    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Client
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [ClientDashboardController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders',
            [ClientOrderController::class, 'index']
        )->name('orders.index');

        Route::post(
            '/orders',
            [ClientOrderController::class, 'store']
        )->name('orders.store');

        Route::get(
            '/orders/{order}/checkout',
            [ClientOrderController::class, 'checkout']
        )->name('orders.checkout');

        Route::get(
            '/orders/{order}',
            [ClientOrderController::class, 'show']
        )->name('orders.show');

        


        /*
        |--------------------------------------------------------------------------
        | Payment
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/orders/{order}/payment/token',
            [PaymentController::class, 'token']
        )->name('orders.payment.token');


        /*
        |--------------------------------------------------------------------------
        | Favorites
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/favorites',
            [ClientFavoriteController::class, 'index']
        )->name('favorites.index');

        Route::post(
            '/favorites/{service}',
            [ClientFavoriteController::class, 'store']
        )->name('favorites.store');

        Route::delete(
            '/favorites/{service}',
            [ClientFavoriteController::class, 'destroy']
        )->name('favorites.destroy');


        /*
        |--------------------------------------------------------------------------
        | Messages
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages',
            [ClientMessageController::class, 'index']
        )->name('messages.index');

        Route::get(
            '/messages/{conversation}',
            [ClientMessageController::class, 'show']
        )->name('messages.show');

        Route::post(
            '/messages/{conversation}',
            [ClientMessageController::class, 'store']
        )->name('messages.store');

        Route::post(
            '/messages/start/{service}',
            [ClientMessageController::class, 'start']
        )->name('messages.start');


        /*
        |--------------------------------------------------------------------------
        | Offers
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/offers/{offer}/accept',
            [ClientOfferController::class, 'accept']
        )->name('offers.accept');

        Route::post(
            '/offers/{offer}/reject',
            [ClientOfferController::class, 'reject']
        )->name('offers.reject');


        /*
        |--------------------------------------------------------------------------
        | Delivery
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders/{order}/delivery',
            [ClientDeliveryController::class, 'show']
        )->name('orders.delivery.show');

        Route::post(
            '/deliveries/{delivery}/approve',
            [ClientDeliveryController::class, 'approve']
        )->name('deliveries.approve');

        Route::post(
            '/deliveries/{delivery}/revision',
            [ClientDeliveryController::class, 'requestRevision']
        )->name('deliveries.revision');

        Route::get('/orders/{order}/delivery', [\App\Http\Controllers\Client\DeliveryController::class, 'show'])
            ->name('delivery.show');

        Route::post('/orders/{order}/delivery/approve', [\App\Http\Controllers\Client\DeliveryController::class, 'approve'])
            ->name('delivery.approve');

        Route::post('/orders/{order}/delivery/revision', [\App\Http\Controllers\Client\DeliveryController::class, 'revision'])
            ->name('delivery.revision');


            /*
        |--------------------------------------------------------------------------
        | Review
        |--------------------------------------------------------------------------
        *//*
        |--------------------------------------------------------------------------
        | Delivery
        |--------------------------------------------------------------------------
        */

            Route::get('/orders/{order}/review', [\App\Http\Controllers\Client\ReviewController::class, 'create'])
                ->name('reviews.create');

            Route::post('/orders/{order}/review', [\App\Http\Controllers\Client\ReviewController::class, 'store'])
                ->name('reviews.store');
    });


/*
|--------------------------------------------------------------------------
| Freelancer
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:freelancer'])
    ->prefix('freelancer')
    ->name('freelancer.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [FreelancerDashboardController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/profile',
            [FreelancerProfileController::class, 'show']
        )->name('profile.show');

        Route::get(
            '/profile/edit',
            [FreelancerProfileController::class, 'edit']
        )->name('profile.edit');

        Route::patch(
            '/profile',
            [FreelancerProfileController::class, 'update']
        )->name('profile.update');


        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/services',
            [FreelancerServiceController::class, 'index']
        )->name('services.index');

        Route::get(
            '/services/create',
            [FreelancerServiceController::class, 'create']
        )->name('services.create');

        Route::post(
            '/services',
            [FreelancerServiceController::class, 'store']
        )->name('services.store');

        Route::get(
            '/services/{service}',
            [FreelancerServiceController::class, 'show']
        )->name('services.show');

        Route::get(
            '/services/{service}/edit',
            [FreelancerServiceController::class, 'edit']
        )->name('services.edit');

        Route::patch(
            '/services/{service}',
            [FreelancerServiceController::class, 'update']
        )->name('services.update');

        Route::delete(
            '/services/{service}',
            [FreelancerServiceController::class, 'destroy']
        )->name('services.destroy');


        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders',
            [FreelancerOrderController::class, 'index']
        )->name('orders.index');

        Route::get(
            '/orders/{order}',
            [FreelancerOrderController::class, 'show']
        )->name('orders.show');


        /*
        |--------------------------------------------------------------------------
        | Delivery
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/orders/{order}/delivery',
            [FreelancerDeliveryController::class, 'store']
        )->name('orders.delivery.store');


        /*
        |--------------------------------------------------------------------------
        | Messages
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages',
            [FreelancerMessageController::class, 'index']
        )->name('messages.index');


        /*
        |--------------------------------------------------------------------------
        | Offers
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages/{conversation}/offer',
            [FreelancerOfferController::class, 'create']
        )->name('messages.offers.create');

        Route::post(
            '/messages/{conversation}/offer',
            [FreelancerOfferController::class, 'store']
        )->name('messages.offers.store');


        /*
        |--------------------------------------------------------------------------
        | Conversation Detail
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages/{conversation}',
            [FreelancerMessageController::class, 'show']
        )->name('messages.show');

        Route::post(
            '/messages/{conversation}',
            [FreelancerMessageController::class, 'store']
        )->name('messages.store');


        /*
        |--------------------------------------------------------------------------
        | Wallet
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/wallet',
            [FreelancerWalletController::class, 'index']
        )->name('wallet.index');


        /*
        |--------------------------------------------------------------------------
        | Withdrawals
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/withdrawals',
            [FreelancerWithdrawalController::class, 'index']
        )->name('withdrawals.index');

        Route::get(
            '/withdrawals/create',
            [FreelancerWithdrawalController::class, 'create']
        )->name('withdrawals.create');

        Route::post(
            '/withdrawals',
            [FreelancerWithdrawalController::class, 'store']
        )->name('withdrawals.store');

    });


/*
|--------------------------------------------------------------------------
| Public Freelancer Profile
|--------------------------------------------------------------------------
|
| PENTING:
| Route ini diletakkan SETELAH seluruh route Freelancer
| agar /freelancer/dashboard tidak dianggap sebagai username.
|
*/

Route::get(
    '/freelancer/{username}',
    [FreelancerController::class, 'show']
)
    ->where('username', '^(?!dashboard$)[A-Za-z0-9_-]+$')
    ->name('marketplace.freelancer');


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [AdminDashboardController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/users',
            [AdminUserController::class, 'index']
        )->name('users.index');

        Route::get(
            '/users/{user}',
            [AdminUserController::class, 'show']
        )->name('users.show');


        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/categories',
            [AdminCategoryController::class, 'index']
        )->name('categories.index');

        Route::post(
            '/categories',
            [AdminCategoryController::class, 'store']
        )->name('categories.store');

        Route::get(
            '/categories/{category}/edit',
            [AdminCategoryController::class, 'edit']
        )->name('categories.edit');

        Route::patch(
            '/categories/{category}',
            [AdminCategoryController::class, 'update']
        )->name('categories.update');

        Route::delete(
            '/categories/{category}',
            [AdminCategoryController::class, 'destroy']
        )->name('categories.destroy');


        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/services',
            [AdminServiceController::class, 'index']
        )->name('services.index');

        Route::get(
            '/services/{service}',
            [AdminServiceController::class, 'show']
        )->name('services.show');

        Route::get(
            '/services/{service}/edit',
            [AdminServiceController::class, 'edit']
        )->name('services.edit');

        Route::patch(
            '/services/{service}',
            [AdminServiceController::class, 'update']
        )->name('services.update');

        Route::delete(
            '/services/{service}',
            [AdminServiceController::class, 'destroy']
        )->name('services.destroy');


        /*
        |--------------------------------------------------------------------------
        | Orders
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders',
            [AdminOrderController::class, 'index']
        )->name('orders.index');

        Route::get(
            '/orders/{order}',
            [AdminOrderController::class, 'show']
        )->name('orders.show');


        /*
        |--------------------------------------------------------------------------
        | Payments
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/payments',
            [AdminPaymentController::class, 'index']
        )->name('payments.index');

        Route::get(
            '/payments/{payment}',
            [AdminPaymentController::class, 'show']
        )->name('payments.show');


        /*
        |--------------------------------------------------------------------------
        | Commissions
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/commissions',
            [AdminCommissionController::class, 'index']
        )->name('commissions.index');

        Route::get(
            '/commissions/{commission}',
            [AdminCommissionController::class, 'show']
        )->name('commissions.show');


        /*
        |--------------------------------------------------------------------------
        | Withdrawals
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/withdrawals',
            [AdminWithdrawalController::class, 'index']
        )->name('withdrawals.index');

        Route::get(
            '/withdrawals/{withdrawal}',
            [AdminWithdrawalController::class, 'show']
        )->name('withdrawals.show');

        Route::patch(
            '/withdrawals/{withdrawal}',
            [AdminWithdrawalController::class, 'update']
        )->name('withdrawals.update');


        /*php artisan route:list --path=admin/withdrawals
        |--------------------------------------------------------------------------
        | Reviews
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reviews',
            [AdminReviewController::class, 'index']
        )->name('reviews.index');

        Route::get(
            '/reviews/{review}',
            [AdminReviewController::class, 'show']
        )->name('reviews.show');

        Route::patch(
            '/reviews/{review}',
            [AdminReviewController::class, 'update']
        )->name('reviews.update');

    });


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';