<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CommissionController as AdminCommissionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController;
use App\Http\Controllers\Admin\ServiceModerationController as AdminServiceModerationController;
use App\Http\Controllers\Admin\CancellationController as AdminCancellationController;
use App\Http\Controllers\Admin\DisputeController as AdminDisputeController;
use App\Http\Controllers\Admin\RefundController as AdminRefundController;

/*
|--------------------------------------------------------------------------
| Client Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\FavoriteController as ClientFavoriteController;
use App\Http\Controllers\Client\MessageController as ClientMessageController;
use App\Http\Controllers\Client\OfferController as ClientOfferController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\DeliveryController as ClientDeliveryController;
use App\Http\Controllers\Client\ReviewController as ClientReviewController;
use App\Http\Controllers\Client\JobController as ClientJobController;
use App\Http\Controllers\Client\InvoiceController as ClientInvoiceController;
use App\Http\Controllers\Client\CancellationController as ClientCancellationController;
use App\Http\Controllers\Client\DisputeController as ClientDisputeController;

/*
|--------------------------------------------------------------------------
| Development / Payment
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\DevelopmentPaymentController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Freelancer Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Freelancer\DashboardController as FreelancerDashboardController;
use App\Http\Controllers\Freelancer\DeliveryController as FreelancerDeliveryController;
use App\Http\Controllers\Freelancer\MessageController as FreelancerMessageController;
use App\Http\Controllers\Freelancer\OfferController as FreelancerOfferController;
use App\Http\Controllers\Freelancer\OrderController as FreelancerOrderController;
use App\Http\Controllers\Freelancer\ProfileController as FreelancerProfileController;
use App\Http\Controllers\Freelancer\ServiceController as FreelancerServiceController;
use App\Http\Controllers\Freelancer\WalletController as FreelancerWalletController;
use App\Http\Controllers\Freelancer\WithdrawalController as FreelancerWithdrawalController;
use App\Http\Controllers\Freelancer\JobController as FreelancerJobController;
use App\Http\Controllers\Freelancer\JobProposalController as FreelancerJobProposalController;
use App\Http\Controllers\Freelancer\VerificationController as FreelancerVerificationController;
use App\Http\Controllers\Freelancer\ServiceModerationController as FreelancerServiceModerationController;
use App\Http\Controllers\Freelancer\CancellationController as FreelancerCancellationController;
use App\Http\Controllers\Freelancer\DisputeController as FreelancerDisputeController;


/*
|--------------------------------------------------------------------------
| Marketplace Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Marketplace\CategoryController;
use App\Http\Controllers\Marketplace\FreelancerController;
use App\Http\Controllers\Marketplace\HomeController;
use App\Http\Controllers\Marketplace\SearchController;
use App\Http\Controllers\Marketplace\ServiceController;
use App\Http\Controllers\Marketplace\JobController as MarketplaceJobController;

/*
|--------------------------------------------------------------------------
| Job Board Chat
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\JobBoardChatController;

/*
|--------------------------------------------------------------------------
| Other Controllers
|--------------------------------------------------------------------------
*/

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
| Public Job Board
|--------------------------------------------------------------------------
*/

Route::get(
    '/jobs',
    [MarketplaceJobController::class, 'index']
)->name('marketplace.jobs.index');

Route::get(
    '/jobs/{job}',
    [MarketplaceJobController::class, 'show']
)->name('marketplace.jobs.show');

/*
|--------------------------------------------------------------------------
| User Profile
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

        /*
        |--------------------------------------------------------------------------
        | Invoice & Transaction Detail
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders/{order}/invoice',
            [ClientInvoiceController::class, 'show']
        )->name('orders.invoice');

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

        Route::post(
            '/orders/{order}/payment/simulate',
            [DevelopmentPaymentController::class, 'simulate']
        )->name('orders.payment.simulate');

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
        | Offers / Quotations
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
        )->name('delivery.show');

        Route::post(
            '/orders/{order}/delivery/approve',
            [ClientDeliveryController::class, 'approve']
        )->name('delivery.approve');

        Route::post(
            '/orders/{order}/delivery/revision',
            [ClientDeliveryController::class, 'revision']
        )->name('delivery.revision');

        /*
        |--------------------------------------------------------------------------
        | Review
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders/{order}/review',
            [ClientReviewController::class, 'create']
        )->name('reviews.create');

        Route::post(
            '/orders/{order}/review',
            [ClientReviewController::class, 'store']
        )->name('reviews.store');

        /*
        |--------------------------------------------------------------------------
        | Job Board - Client
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/jobs',
            [ClientJobController::class, 'index']
        )->name('jobs.index');

        Route::get(
            '/jobs/create',
            [ClientJobController::class, 'create']
        )->name('jobs.create');

        Route::post(
            '/jobs',
            [ClientJobController::class, 'store']
        )->name('jobs.store');

        Route::get(
            '/jobs/{job}',
            [ClientJobController::class, 'show']
        )->name('jobs.show');

        Route::get(
            '/jobs/{job}/edit',
            [ClientJobController::class, 'edit']
        )->name('jobs.edit');

        Route::patch(
            '/jobs/{job}',
            [ClientJobController::class, 'update']
        )->name('jobs.update');

        Route::post(
            '/jobs/{job}/publish',
            [ClientJobController::class, 'publish']
        )->name('jobs.publish');

        Route::post(
            '/jobs/{job}/close',
            [ClientJobController::class, 'close']
        )->name('jobs.close');

        /*
        |--------------------------------------------------------------------------
        | Job Proposals
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/jobs/{job}/proposals/{proposal}/accept',
            [ClientJobController::class, 'acceptProposal']
        )->name('jobs.proposals.accept');

        Route::post(
            '/jobs/{job}/proposals/{proposal}/reject',
            [ClientJobController::class, 'rejectProposal']
        )->name('jobs.proposals.reject');

        /*
        |--------------------------------------------------------------------------
        | Job Board Chat
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/jobs/{job}/proposals/{proposal}/chat',
            [JobBoardChatController::class, 'start']
        )->name('jobs.chat.start');

        /*
        |--------------------------------------------------------------------------
        | Cancellation
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders/{order}/cancellation',
            [ClientCancellationController::class, 'create']
        )->name('orders.cancellation.create');

        Route::post(
            '/orders/{order}/cancellation',
            [ClientCancellationController::class, 'store']
        )->name('orders.cancellation.store');

        Route::post(
            '/orders/{order}/cancellation/mediation',
            [ClientCancellationController::class, 'mediation']
        )->name('orders.cancellation.mediation');

        /*
        |--------------------------------------------------------------------------
        | Dispute
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders/{order}/dispute',
            [ClientDisputeController::class, 'create']
        )->name('orders.dispute.create');

        Route::post(
            '/orders/{order}/dispute',
            [ClientDisputeController::class, 'store']
        )->name('orders.dispute.store');

        Route::get(
            '/disputes/{dispute}',
            [ClientDisputeController::class, 'show']
        )->name('disputes.show');

        Route::post(
            '/disputes/{dispute}/message',
            [ClientDisputeController::class, 'message']
        )->name('disputes.message');

        Route::post(
            '/disputes/{dispute}/evidence',
            [ClientDisputeController::class, 'evidence']
        )->name('disputes.evidence');
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
        | Profile - Experience
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/profile/experiences',
            [FreelancerProfileController::class, 'storeExperience']
        )->name('profile.experiences.store');

        Route::put(
            '/profile/experiences/{experience}',
            [FreelancerProfileController::class, 'updateExperience']
        )->name('profile.experiences.update');

        Route::delete(
            '/profile/experiences/{experience}',
            [FreelancerProfileController::class, 'destroyExperience']
        )->name('profile.experiences.destroy');

        /*
        |--------------------------------------------------------------------------
        | Profile - Education
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/profile/educations',
            [FreelancerProfileController::class, 'storeEducation']
        )->name('profile.educations.store');

        Route::put(
            '/profile/educations/{education}',
            [FreelancerProfileController::class, 'updateEducation']
        )->name('profile.educations.update');

        Route::delete(
            '/profile/educations/{education}',
            [FreelancerProfileController::class, 'destroyEducation']
        )->name('profile.educations.destroy');

        /*
        |--------------------------------------------------------------------------
        | Profile - Certificates
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/profile/certificates',
            [FreelancerProfileController::class, 'storeCertificate']
        )->name('profile.certificates.store');

        Route::put(
            '/profile/certificates/{certificate}',
            [FreelancerProfileController::class, 'updateCertificate']
        )->name('profile.certificates.update');

        Route::delete(
            '/profile/certificates/{certificate}',
            [FreelancerProfileController::class, 'destroyCertificate']
        )->name('profile.certificates.destroy');

        /*
        |--------------------------------------------------------------------------
        | Profile - Skills
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/profile/skills',
            [FreelancerProfileController::class, 'storeSkill']
        )->name('profile.skills.store');

        Route::put(
            '/profile/skills/{skill}',
            [FreelancerProfileController::class, 'updateSkill']
        )->name('profile.skills.update');

        Route::delete(
            '/profile/skills/{skill}',
            [FreelancerProfileController::class, 'destroySkill']
        )->name('profile.skills.destroy');

        /*
        |--------------------------------------------------------------------------
        | Profile - Languages
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/profile/languages',
            [FreelancerProfileController::class, 'storeLanguage']
        )->name('profile.languages.store');

        Route::put(
            '/profile/languages/{language}',
            [FreelancerProfileController::class, 'updateLanguage']
        )->name('profile.languages.update');

        Route::delete(
            '/profile/languages/{language}',
            [FreelancerProfileController::class, 'destroyLanguage']
        )->name('profile.languages.destroy');

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
        | Service Moderation
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/services/{service}/submit-review',
            [FreelancerServiceModerationController::class, 'submitReview']
        )->name('services.submit-review');

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
        | Offers / Quotations - Service Marketplace
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages/{conversation}/offer',
            [FreelancerOfferController::class, 'createService']
        )->name('messages.offers.create');

        Route::post(
            '/messages/{conversation}/offer',
            [FreelancerOfferController::class, 'storeService']
        )->name('messages.offers.store');

        /*
        |--------------------------------------------------------------------------
        | Job Board - Quotation
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/jobs/{job}/proposals/{proposal}/offer',
            [FreelancerOfferController::class, 'createJob']
        )->name('jobs.proposals.offer.create');

        Route::post(
            '/jobs/{job}/proposals/{proposal}/offer',
            [FreelancerOfferController::class, 'storeJob']
        )->name('jobs.proposals.offer.store');

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

        /*
        |--------------------------------------------------------------------------
        | Job Board - Freelancer
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/jobs',
            [FreelancerJobController::class, 'index']
        )->name('jobs.index');

        Route::get(
            '/jobs/{job}',
            [FreelancerJobController::class, 'show']
        )->name('jobs.show');

        Route::post(
            '/jobs/{job}/proposals',
            [FreelancerJobProposalController::class, 'store']
        )->name('jobs.proposals.store');

        /*
        |--------------------------------------------------------------------------
        | Job Board Chat
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/jobs/{job}/proposals/{proposal}/chat',
            [JobBoardChatController::class, 'start']
        )->name('jobs.chat.start');

        /*
        |--------------------------------------------------------------------------
        | Job Board - Quotation
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/jobs/{job}/proposals/{proposal}/offer',
            [FreelancerOfferController::class, 'create']
        )->name('jobs.proposals.offer.create');

        Route::post(
            '/jobs/{job}/proposals/{proposal}/offer',
            [FreelancerOfferController::class, 'store']
        )->name('jobs.proposals.offer.store');

        /*
        |--------------------------------------------------------------------------
        | Verifications
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/verification',
            [FreelancerVerificationController::class, 'index']
        )->name('verification.index');

        Route::post(
            '/verification',
            [FreelancerVerificationController::class, 'store']
        )->name('verification.store');

        /*
        |--------------------------------------------------------------------------
        | Cancellation
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders/{order}/cancellation',
            [FreelancerCancellationController::class, 'create']
        )->name('orders.cancellation.create');

        Route::post(
            '/orders/{order}/cancellation/approve',
            [FreelancerCancellationController::class, 'approve']
        )->name('orders.cancellation.approve');

        Route::post(
            '/orders/{order}/cancellation/reject',
            [FreelancerCancellationController::class, 'reject']
        )->name('orders.cancellation.reject');

         /*
        |--------------------------------------------------------------------------
        | Dispute
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/orders/{order}/dispute',
            [FreelancerDisputeController::class, 'create']
        )->name('orders.dispute.create');

        Route::post(
            '/orders/{order}/dispute',
            [FreelancerDisputeController::class, 'store']
        )->name('orders.dispute.store');

        Route::get(
            '/disputes/{dispute}',
            [FreelancerDisputeController::class, 'show']
        )->name('disputes.show');

        Route::post(
            '/disputes/{dispute}/message',
            [FreelancerDisputeController::class, 'message']
        )->name('disputes.message');

        Route::post(
            '/disputes/{dispute}/evidence',
            [FreelancerDisputeController::class, 'evidence']
        )->name('disputes.evidence');
    });

/*
|--------------------------------------------------------------------------
| Public Freelancer Profile
|--------------------------------------------------------------------------
|
| Route public profile diletakkan setelah seluruh route internal
| freelancer supaya /freelancer/dashboard dan route internal lainnya
| tidak dianggap sebagai username.
|
*/

Route::get(
    '/freelancer/{username}',
    [FreelancerController::class, 'show']
)
    ->where(
        'username',
        '^(?!dashboard$)[A-Za-z0-9_-]+$'
    )
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

        /*
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

        /*
        |--------------------------------------------------------------------------
        | Freelancer Verification
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/verifications',
            [AdminVerificationController::class, 'index']
        )->name('verifications.index');

        Route::get(
            '/verifications/{verification}',
            [AdminVerificationController::class, 'show']
        )->name('verifications.show');

        Route::get(
            '/verifications/{verification}/document',
            [AdminVerificationController::class, 'document']
        )->name('verifications.document');

        Route::post(
            '/verifications/{verification}/approve',
            [AdminVerificationController::class, 'approve']
        )->name('verifications.approve');

        Route::post(
            '/verifications/{verification}/reject',
            [AdminVerificationController::class, 'reject']
        )->name('verifications.reject');

        /*
        |--------------------------------------------------------------------------
        | Service Moderation
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/service-moderation',
            [AdminServiceModerationController::class, 'index']
        )->name('service-moderation.index');

        Route::get(
            '/service-moderation/{service}',
            [AdminServiceModerationController::class, 'show']
        )->name('service-moderation.show');

        Route::post(
            '/service-moderation/{service}/publish',
            [AdminServiceModerationController::class, 'publish']
        )->name('service-moderation.publish');

        Route::post(
            '/service-moderation/{service}/reject',
            [AdminServiceModerationController::class, 'reject']
        )->name('service-moderation.reject');

        /*
        |--------------------------------------------------------------------------
        | Cancellations
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/cancellations',
            [AdminCancellationController::class, 'index']
        )->name('cancellations.index');

        Route::get(
            '/cancellations/{cancellationRequest}',
            [AdminCancellationController::class, 'show']
        )->name('cancellations.show');

        Route::post(
            '/cancellations/{cancellationRequest}/approve',
            [AdminCancellationController::class, 'approve']
        )->name('cancellations.approve');

        Route::post(
            '/cancellations/{cancellationRequest}/reject',
            [AdminCancellationController::class, 'reject']
        )->name('cancellations.reject');

         /*
        |--------------------------------------------------------------------------
        | Dispute
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/disputes',
            [AdminDisputeController::class, 'index']
        )->name('disputes.index');

        Route::get(
            '/disputes/{dispute}',
            [AdminDisputeController::class, 'show']
        )->name('disputes.show');

        Route::post(
            '/disputes/{dispute}/resolve',
            [AdminDisputeController::class, 'resolve']
        )->name('disputes.resolve');

        Route::post(
            '/disputes/{dispute}/close',
            [AdminDisputeController::class, 'close']
        )->name('disputes.close');

                /* 
        |--------------------------------------------------------------------------
        | Refunds
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/refunds',
            [AdminRefundController::class, 'index']
        )->name('refunds.index');

        Route::get(
            '/refunds/{refund}',
            [AdminRefundController::class, 'show']
        )->name('refunds.show');

        Route::post(
            '/refunds/{refund}/process',
            [AdminRefundController::class, 'process']
        )->name('refunds.process');

        Route::post(
            '/refunds/{refund}/complete',
            [AdminRefundController::class, 'complete']
        )->name('refunds.complete');

        Route::post(
            '/refunds/{refund}/reject',
            [AdminRefundController::class, 'reject']
        )->name('refunds.reject');
    });

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';