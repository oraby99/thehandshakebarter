<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\BarterController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\PageController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\UserWantController;
use App\Http\Controllers\API\NotificationController;



Route::prefix('v1')->group(function () {
    // Auth
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('auth/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('auth/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('auth/resend-otp', [AuthController::class, 'resendOtp']);

    // Public
    Route::get('pages', [PageController::class, 'index']);
    Route::post('contact', [ContactController::class, 'store']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::get('items', [ItemController::class, 'index']);
    Route::get('items/{item}', [ItemController::class, 'show']);
    Route::get('subscriptions', [SubscriptionController::class, 'index']);
    Route::get('subscription-plans', [SubscriptionController::class, 'index']);

    // Attributes (public)
    Route::get('brands', [\App\Http\Controllers\API\AttributeController::class, 'brands']);
    Route::get('colors', [\App\Http\Controllers\API\AttributeController::class, 'colors']);
    Route::get('cities', [\App\Http\Controllers\API\AttributeController::class, 'cities']);
    Route::get('item-statuses', [\App\Http\Controllers\API\AttributeController::class, 'itemStatuses']);
    Route::get('conditions', [\App\Http\Controllers\API\AttributeController::class, 'conditions']);
    Route::get('sizes', [\App\Http\Controllers\API\AttributeController::class, 'sizes']);

    // Protected
    Route::middleware(['auth:sanctum', 'verified.api'])->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('me', [ProfileController::class, 'me']);
        Route::put('me', [ProfileController::class, 'update']);
        Route::put('me/password', [ProfileController::class, 'updatePassword']);
        Route::delete('me', [ProfileController::class, 'destroy']);
        Route::get('me/favorites', [ProfileController::class, 'favorites']);
        Route::apiResource('user-wants', UserWantController::class);

        // Items
        Route::post('items', [ItemController::class, 'store']);
        Route::put('items/{item}', [ItemController::class, 'update']);
        Route::delete('items/{item}', [ItemController::class, 'destroy']);
        Route::post('items/{item}/favorite', [ItemController::class, 'favorite']);
        Route::delete('items/{item}/favorite', [ItemController::class, 'unfavorite']);

        // Barters
        Route::apiResource('barters', BarterController::class);
        Route::post('barters/{barter}/accept', [BarterController::class, 'accept']);
        Route::post('barters/{barter}/reject', [BarterController::class, 'reject']);
        Route::post('barters/{barter}/cancel', [BarterController::class, 'cancel']);
        Route::post('barters/{barter}/confirm-received', [BarterController::class, 'confirmReceived']);
        Route::post('barters/{barter}/report-not-received', [BarterController::class, 'reportNotReceived']);
        Route::post('barters/{barter}/rate', [BarterController::class, 'rate']);

        // Payments
        Route::post('payments/initiate', [PaymentController::class, 'initiate']);
        Route::get('me/payments', [PaymentController::class, 'index']);

        // Subscriptions
        Route::post('subscriptions', [SubscriptionController::class, 'subscribe']);
        Route::get('me/subscription', [SubscriptionController::class, 'current']);

        // Chat
        Route::get('chat/conversations', [ChatController::class, 'index']);
        Route::get('barters/{barter}/conversation', [ChatController::class, 'show']);
        Route::post('barters/{barter}/messages', [ChatController::class, 'storeMessageByBarter']);
        Route::post('chat/conversations/{conversation}/messages', [ChatController::class, 'storeMessage']);

        // Notifications
        Route::get('notifications', [NotificationController::class, 'index']);
        Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    });
});
