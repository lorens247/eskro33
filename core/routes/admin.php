<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/

Route::namespace('Auth')->group(function () {
    Route::get('/', 'LoginController@showLoginForm')->name('login');
    Route::post('/', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    // Admin Password Reset
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/email', 'ForgotPasswordController@sendResetCodeEmail')->name('password.email');
    Route::get('password/code-verify', 'ForgotPasswordController@codeVerify')->name('password.code.verify');
    Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify.code');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.form');
    Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
});

Route::middleware('admin')->group(function () {
    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
    Route::get('profile', 'AdminController@profile')->name('profile');
    Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
    Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

    //Notification
    Route::get('notifications','AdminController@notifications')->name('notify');
    Route::get('notification/read/{id}','AdminController@notificationRead')->name('notification.read');
    Route::get('notifications/read-all','AdminController@readAll')->name('notifications.readAll');

    //Report Bugs
    Route::get('system-support','SystemController@support')->name('system.support');
    Route::get('system-info','SystemController@systemInfo')->name('system.info');
    Route::get('system-server-info','SystemController@systemServerInfo')->name('system.server.info');
    Route::get('system-optimize', 'SystemController@optimize')->name('system.optimize');
    Route::get('system-optimize-clear', 'SystemController@optimizeClear')->name('system.optimize.clear');
    Route::get('system-database-backup', 'SystemController@databaseBackup')->name('system.database.backup');



    // Users Manager
    Route::get('users', 'ManageUsersController@allUsers')->name('users.all');
    Route::get('users/active', 'ManageUsersController@activeUsers')->name('users.active');
    Route::get('users/banned', 'ManageUsersController@bannedUsers')->name('users.banned');
    Route::get('users/email-verified', 'ManageUsersController@emailVerifiedUsers')->name('users.email.verified');
    Route::get('users/email-unverified', 'ManageUsersController@emailUnverifiedUsers')->name('users.email.unverified');
    Route::get('users/sms-unverified', 'ManageUsersController@smsUnverifiedUsers')->name('users.sms.unverified');
    Route::get('users/sms-verified', 'ManageUsersController@smsVerifiedUsers')->name('users.sms.verified');
    Route::get('users/with-balance', 'ManageUsersController@usersWithBalance')->name('users.with.balance');

    Route::get('users/{scope}/search', 'ManageUsersController@search')->name('users.search');
    Route::get('user/detail/{id}', 'ManageUsersController@detail')->name('users.detail');
    Route::post('user/update/{id}', 'ManageUsersController@update')->name('users.update');
    Route::post('user/add-sub-balance/{id}', 'ManageUsersController@addSubBalance')->name('users.add.sub.balance');
    Route::get('user/send-notification/{id}', 'ManageUsersController@showNotificationSingleForm')->name('users.notification.single');
    Route::post('user/send-notification/{id}', 'ManageUsersController@sendNotificationSingle')->name('users.notification.single');
    Route::get('user/login/{id}', 'ManageUsersController@login')->name('users.login');
    Route::get('user/transactions/{id}', 'ManageUsersController@transactions')->name('users.transactions');
    Route::get('user/deposits/{id}', 'ManageUsersController@deposits')->name('users.deposits');
    Route::get('user/withdrawals/{id}', 'ManageUsersController@withdrawals')->name('users.withdrawals');
    // Login History
    Route::get('users/login/history/{id}', 'ManageUsersController@userLoginHistory')->name('users.login.history.single');

    Route::get('users/send-notification', 'ManageUsersController@showNotificationAllForm')->name('users.notification.all');
    Route::post('users/send-notification', 'ManageUsersController@sendNotificationAll');
    Route::get('users/notification-log/{id}', 'ManageUsersController@notificationLog')->name('users.notification.log');

    //escrow type
    Route::get('escrow-types','EscrowTypeController@index')->name('escrow.type.index');
    Route::post('escrow-store','EscrowTypeController@store')->name('escrow.type.store');
    Route::post('escrow-update/{id}','EscrowTypeController@update')->name('escrow.type.update');

    //escrow charge
    Route::get('escrow-charge','EscrowChargeController@index')->name('escrow.charge.index');
    Route::post('escrow-charge/global','EscrowChargeController@globalCharge')->name('escrow.charge.global');
    Route::post('escrow-charge/store','EscrowChargeController@store')->name('escrow.charge.store');
    Route::post('escrow-charge/update/{id}','EscrowChargeController@update')->name('escrow.charge.update');
    Route::post('escrow-charge/remove/{id}','EscrowChargeController@remove')->name('escrow.charge.remove');

    //escrow
    Route::get('escrow','EscrowController@index')->name('escrow.index');
    Route::get('escrow/accepted','EscrowController@accepted')->name('escrow.accepted');
    Route::get('escrow/not-accepted','EscrowController@notAccepted')->name('escrow.not.accepted');
    Route::get('escrow/completed','EscrowController@completed')->name('escrow.completed');
    Route::get('escrow/disputed','EscrowController@disputed')->name('escrow.disputed');
    Route::get('escrow/cancelled','EscrowController@cancelled')->name('escrow.cancelled');

    Route::get('escrow/details/{id}','EscrowController@details')->name('escrow.details');
    Route::get('escrow/milestone/{id}','EscrowController@milestone')->name('escrow.milestone');
    Route::post('escrow/message','EscrowController@messageReply')->name('escrow.message.reply');
    Route::get('escrow/message-get','EscrowController@messageGet')->name('escrow.message.get');

    Route::post('escrow/action','EscrowController@action')->name('escrow.action');

    // Deposit Gateway
    Route::name('gateway.')->prefix('gateway')->group(function(){
        // Automatic Gateway
        Route::get('automatic', 'AutomaticGatewayController@index')->name('automatic.index');
        Route::post('automatic/configure/{id}', 'AutomaticGatewayController@configure')->name('automatic.configure');
        Route::get('automatic/currency/{id}', 'AutomaticGatewayController@currency')->name('automatic.currency');
        Route::post('automatic/currency/add', 'AutomaticGatewayController@currencyAdd')->name('automatic.currency.add');
        Route::post('automatic/currency/update/{id}', 'AutomaticGatewayController@currencyUpdate')->name('automatic.currency.update');
        Route::post('automatic/currency/remove/{id}', 'AutomaticGatewayController@currencyUpdateRemove')->name('automatic.currency.remove');


        // Manual Methods
        Route::get('manual', 'ManualGatewayController@index')->name('manual.index');
        Route::post('manual/new', 'ManualGatewayController@store')->name('manual.store');
        Route::post('manual/update/{id}', 'ManualGatewayController@update')->name('manual.update');
        Route::post('manual/activate', 'ManualGatewayController@activate')->name('manual.activate');
        Route::post('manual/deactivate', 'ManualGatewayController@deactivate')->name('manual.deactivate');
    });


    // DEPOSIT SYSTEM
    Route::name('deposit.')->prefix('deposit')->group(function(){
        Route::get('/', 'DepositController@deposit')->name('list');
        Route::get('pending', 'DepositController@pending')->name('pending');
        Route::get('rejected', 'DepositController@rejected')->name('rejected');
        Route::get('successful', 'DepositController@successful')->name('successful');
        Route::get('details/{id}', 'DepositController@details')->name('details');

        Route::post('reject', 'DepositController@reject')->name('reject');
        Route::post('approve', 'DepositController@approve')->name('approve');
        Route::get('via/{method}/{type?}', 'DepositController@depositViaMethod')->name('method');
        Route::get('/{scope}/search', 'DepositController@search')->name('search');

    });


    // WITHDRAW SYSTEM
    Route::name('withdraw.')->prefix('withdraw')->group(function(){
        Route::get('pending', 'WithdrawalController@pending')->name('pending');
        Route::get('approved', 'WithdrawalController@approved')->name('approved');
        Route::get('rejected', 'WithdrawalController@rejected')->name('rejected');
        Route::get('log', 'WithdrawalController@log')->name('log');
        Route::get('via/{method_id}/{type?}', 'WithdrawalController@logViaMethod')->name('method');
        Route::get('{scope}/search', 'WithdrawalController@search')->name('search');
        Route::get('details/{id}', 'WithdrawalController@details')->name('details');
        Route::post('approve', 'WithdrawalController@approve')->name('approve');
        Route::post('reject', 'WithdrawalController@reject')->name('reject');


    });
        // Withdraw Method
    Route::name('withdrawal.method.')->prefix('withdrawal/method')->group(function(){
        Route::get('', 'WithdrawMethodController@methods')->name('index');
        Route::post('create', 'WithdrawMethodController@store')->name('store');
        Route::post('edit/{id}', 'WithdrawMethodController@update')->name('update');
        Route::post('activate', 'WithdrawMethodController@activate')->name('activate');
        Route::post('deactivate', 'WithdrawMethodController@deactivate')->name('deactivate');
    });

    // Report
    Route::get('report/transaction', 'ReportController@transaction')->name('report.transaction');
    Route::get('report/transaction/search', 'ReportController@transactionSearch')->name('report.transaction.search');
    Route::get('report/login/history', 'ReportController@loginHistory')->name('report.login.history');
    Route::get('report/login/ipHistory/{ip}', 'ReportController@loginIpHistory')->name('report.login.ipHistory');
    Route::get('report/email/history', 'ReportController@emailHistory')->name('report.email.history');
    Route::get('report/email/detail/{id}', 'ReportController@emailDetails')->name('report.email.details');
    Route::get('report/sms/history', 'ReportController@smsHistory')->name('report.sms.history');
    Route::get('report/telegram/history', 'ReportController@telegramHistory')->name('report.telegram.history');


    // Admin Support
    Route::get('tickets', 'SupportTicketController@tickets')->name('ticket');
    Route::get('tickets/pending', 'SupportTicketController@pendingTicket')->name('ticket.pending');
    Route::get('tickets/closed', 'SupportTicketController@closedTicket')->name('ticket.closed');
    Route::get('tickets/answered', 'SupportTicketController@answeredTicket')->name('ticket.answered');
    Route::get('tickets/view/{id}', 'SupportTicketController@ticketReply')->name('ticket.view');
    Route::post('ticket/reply/{id}', 'SupportTicketController@ticketReplySend')->name('ticket.reply');
    Route::get('ticket/download/{ticket}', 'SupportTicketController@ticketDownload')->name('ticket.download');
    Route::post('ticket/delete', 'SupportTicketController@ticketDelete')->name('ticket.delete');


    //extension Update
    Route::get('extension/templates','ExtensionController@templates')->name('extension.templates');
    Route::get('extension/active-template/{template}','ExtensionController@activeTemplate')->name('extension.active.template');
    Route::get('extension/plugins','ExtensionController@plugins')->name('extension.plugins');
    Route::get('extension/upload','ExtensionController@upload')->name('extension.upload');
    Route::post('extension/upload','ExtensionController@uploadSubmit');


    Route::name('setting.')->prefix('setting')->group(function(){

        // Language Manager
        Route::get('language', 'LanguageController@langManage')->name('language.manage');
        Route::post('language', 'LanguageController@langStore')->name('language.manage.store');
        Route::post('language/delete/{id}', 'LanguageController@langDel')->name('language.manage.del');
        Route::post('language/update/{id}', 'LanguageController@langUpdate')->name('language.manage.update');
        Route::get('language/edit/{id}', 'LanguageController@langEdit')->name('language.key');
        Route::post('language/import', 'LanguageController@langImport')->name('language.importLang');
        Route::post('language/store/key/{id}', 'LanguageController@storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'LanguageController@deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'LanguageController@updateLanguageJson')->name('language.update.key');

        // General Setting
        Route::get('general', 'GeneralSettingController@index')->name('index');
        Route::post('general', 'GeneralSettingController@update')->name('update');

        // Logo-Icon
        Route::get('logo-icon', 'GeneralSettingController@logoIcon')->name('logo.icon');
        Route::post('logo-icon', 'GeneralSettingController@logoIconUpdate')->name('logo.icon');

        //Custom CSS
        Route::get('custom-assets','GeneralSettingController@customAssets')->name('custom.assets');
        Route::post('custom-css','GeneralSettingController@customCssSubmit')->name('custom.css');
        Route::post('custom-js','GeneralSettingController@customJsSubmit')->name('custom.js');

        //Cookie
        Route::get('cookie','GeneralSettingController@cookie')->name('cookie');
        Route::post('cookie','GeneralSettingController@cookieSubmit');

        // SEO
        Route::get('seo', 'FrontendController@seoEdit')->name('seo');

        //Captcha
        Route::get('captcha','GeneralSettingController@captcha')->name('captcha');
        Route::post('captcha','GeneralSettingController@captchaUpdate');
    });



    //Notification Setting
    Route::name('notification.')->prefix('notification')->group(function(){
        //Template Setting
        Route::get('global','NotificationController@global')->name('global');
        Route::post('global/update','NotificationController@globalUpdate')->name('global.update');
        Route::get('templates','NotificationController@templates')->name('templates');
        Route::get('template/edit/{id}','NotificationController@templateEdit')->name('template.edit');
        Route::post('template/update/{id}','NotificationController@templateUpdate')->name('template.update');

        //Email Setting
        Route::get('email/setting','NotificationController@emailSetting')->name('email.setting');
        Route::post('email/setting','NotificationController@emailSettingUpdate');
        Route::post('email/test','NotificationController@emailTest')->name('email.test');

        //SMS Setting
        Route::get('sms/setting','NotificationController@smsSetting')->name('sms.setting');
        Route::post('sms/setting','NotificationController@smsSettingUpdate');
        Route::post('sms/test','NotificationController@smsTest')->name('sms.test');

        //Telegram Setting
        Route::get('telegram/setting','NotificationController@telegramSetting')->name('telegram.setting');
        Route::post('telegram/setting','NotificationController@telegramSettingUpdate');
        Route::post('telegram/test','NotificationController@telegramTest')->name('telegram.test');
    });


    // Frontend
    Route::name('frontend.')->prefix('frontend')->group(function () {


        Route::get('frontend-sections/{key}', 'FrontendController@frontendSections')->name('sections');
        Route::post('frontend-content/{key}', 'FrontendController@frontendContent')->name('sections.content');
        Route::get('frontend-element/{key}/{id?}', 'FrontendController@frontendElement')->name('sections.element');
        Route::post('remove', 'FrontendController@remove')->name('remove');

        // Page Builder
        Route::get('manage-pages', 'PageBuilderController@managePages')->name('manage.pages');
        Route::post('manage-pages', 'PageBuilderController@managePagesSave')->name('manage.pages.save');
        Route::post('manage-pages/update', 'PageBuilderController@managePagesUpdate')->name('manage.pages.update');
        Route::post('manage-pages/delete', 'PageBuilderController@managePagesDelete')->name('manage.pages.delete');
        Route::get('manage-sections', 'PageBuilderController@allSection')->name('manage.section.all');
        Route::get('manage-section/{id}', 'PageBuilderController@manageSection')->name('manage.section');
        Route::post('manage-section/{id}', 'PageBuilderController@manageSectionUpdate')->name('manage.section.update');
    });
});
