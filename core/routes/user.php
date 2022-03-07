<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start User Area
|--------------------------------------------------------------------------
*/


Route::name('user.')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->middleware('regStatus');
    Route::post('check-user', 'Auth\RegisterController@checkUser')->name('checkUser');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetCodeEmail')->name('password.email');
    Route::get('password/code-verify', 'Auth\ForgotPasswordController@codeVerify')->name('password.code.verify');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/verify-code', 'Auth\ForgotPasswordController@verifyCode')->name('password.verify.code');
    
    // Remove Auth for user escrow create
    Route::get('escrow-create','EscrowController@create')->name('escrow.create');
    Route::post('escrow-create','EscrowController@nextToStore');
    Route::get('escrow-submit','EscrowController@escrowSubmit')->name('escrow.submit');
    
});

Route::name('user.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('authorization', 'AuthorizationController@authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');
        Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');
        Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');


        Route::middleware(['checkStatus'])->group(function () {
            Route::get('dashboard', 'UserController@home')->name('home');

            Route::get('profile-setting', 'UserController@profile')->name('profile.setting');
            Route::post('profile-setting', 'UserController@submitProfile');
            Route::get('change-password', 'UserController@changePassword')->name('password.setting');
            Route::post('change-password', 'UserController@submitPassword');

            //2FA
            Route::get('twofactor', 'UserController@show2faForm')->name('twofactor');
            Route::post('twofactor/enable', 'UserController@create2fa')->name('twofactor.enable');
            Route::post('twofactor/disable', 'UserController@disable2fa')->name('twofactor.disable');


            // Deposit
            Route::post('deposit/insert', 'Gateway\PaymentController@depositInsert')->name('deposit.insert');
            Route::get('deposit/preview', 'Gateway\PaymentController@depositPreview')->name('deposit.preview');
            Route::get('deposit/confirm', 'Gateway\PaymentController@depositConfirm')->name('deposit.confirm');
            Route::get('deposit/manual', 'Gateway\PaymentController@manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'Gateway\PaymentController@manualDepositUpdate')->name('deposit.manual.update');
            Route::any('deposit/history', 'UserController@depositHistory')->name('deposit.history');
            Route::any('deposit/{type?}', 'Gateway\PaymentController@deposit')->name('deposit');

            // Withdraw
            Route::get('/withdraw', 'UserController@withdrawMoney')->name('withdraw');
            Route::post('/withdraw', 'UserController@withdrawStore')->name('withdraw.money');
            Route::get('/withdraw/preview', 'UserController@withdrawPreview')->name('withdraw.preview');
            Route::post('/withdraw/preview', 'UserController@withdrawSubmit')->name('withdraw.submit');
            Route::get('/withdraw/history/{type?}', 'UserController@withdrawLog')->name('withdraw.history');

            Route::get('transactions','UserController@transactions')->name('transactions');

            //escrow
            Route::post('escrow-submit','EscrowController@escrowStore');
            

            Route::post('escrow-cancel/{hash}','EscrowController@escrowCancel')->name('escrow.cancel');
            Route::post('escrow-accept/{hash}','EscrowController@escrowAccept')->name('escrow.accept');
            Route::post('escrow/dispatch','EscrowController@escrowDispatch')->name('escrow.dispatch');
            Route::post('escrow/dispute','EscrowController@escrowDispute')->name('escrow.dispute');
            Route::get('escrow/details/{hash}','EscrowController@escrowDetails')->name('escrow.details');

            Route::get('escrow/milestone/{hash}','EscrowController@milestones')->name('escrow.milestone');
            Route::post('escrow/milestone/create','EscrowController@milestoneCreate')->name('escrow.milestone.create');
            Route::post('escrow/milestone/pay','EscrowController@milestonePay')->name('escrow.milestone.pay');

            Route::post('escrow/message-reply','EscrowController@messageReply')->name('escrow.message.reply');
            Route::get('escrow/get-messages','EscrowController@getMessages')->name('escrow.message.get');

            Route::get('escrow/{type?}','EscrowController@index')->name('escrow');
        });
    });
});
