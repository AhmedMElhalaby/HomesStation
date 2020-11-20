<?php

Route::get('/', 'Website\HomeController@index')->name('website.home');
Route::get('privacy', 'Website\SettingController@privacy')->name('website.settings.privacy');
Route::get('terms', 'Website\SettingController@terms')->name('website.settings.terms');


Route::group(['prefix' => 'dashboard'], function () {

    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', 'Dashboard\AuthController@signin_view')->name('dashboard.login');
        Route::post('login_post', 'Dashboard\AuthController@signin')->name('dashboard.post_login');
    });

    Route::group(['middleware' => ['auth', 'admin']], function () {

        Route::get('/', 'Dashboard\HomeController@index')->name('dashboard.home');
        Route::get('logout', 'Dashboard\AuthController@signout')->name('dashboard.logout');

        Route::group(['prefix' => 'auth'], function () {
            Route::get('profile', 'Dashboard\AuthController@profile')->name('admin.profile');
            Route::post('update', 'Dashboard\AuthController@update')->name('update.profile');
            Route::post('update_password', 'Dashboard\AuthController@update_password')->name('update.password');
        });
        Route::group(['middleware' => ['check_permission']], function () {
            Route::resource('permission', 'Dashboard\PermissionController');
            Route::resource('admin', 'Dashboard\AdminController');
            Route::resource('user', 'Dashboard\UserController');
            Route::get('user/trashed', 'Dashboard\UserController@trashed')->name('user.trashed');
            Route::resource('provider', 'Dashboard\ProviderController');
            Route::get('provider/{service_id}/services', 'Dashboard\ProviderController@get_services')->name('provider.services');
            Route::get('provider/trashed', 'Dashboard\ProviderController@trashed')->name('provider.trashed');
            Route::post('provider/update_expire_date', 'Dashboard\ProviderController@update_expire_date')->name('provider.update_expire_date');
            Route::resource('delegate', 'Dashboard\DelegateController');
            Route::get('delegate/trashed', 'Dashboard\DelegateController@trashed')->name('delegate.trashed');
            Route::post('delegate/update_expire_date', 'Dashboard\DelegateController@update_expire_date')->name('delegate.update_expire_date');
            Route::resource('nationality', 'Dashboard\NationalityController');
            Route::resource('country', 'Dashboard\CountryController');
            Route::resource('city', 'Dashboard\CityController');
            Route::resource('category', 'Dashboard\CategoryController');
            Route::resource('subscription', 'Dashboard\SubscriptionController');
            Route::resource('subcategory', 'Dashboard\SubcategoryController');
            Route::resource('subcategory_tag', 'Dashboard\SubcategoryTagController');
            Route::resource('service', 'Dashboard\ServiceController');
            Route::resource('bank_account', 'Dashboard\BankAccountController');
            Route::resource('transaction', 'Dashboard\TransactionController');

            Route::group(['prefix' => 'order'], function () {
                Route::get('current', 'Dashboard\OrderController@current_orders')->name('order.current');
                Route::get('finished', 'Dashboard\OrderController@finished_orders')->name('order.finished');
                Route::get('{order_id}/show', 'Dashboard\OrderController@show')->name('order.show');
                Route::delete('{order_id}', 'Dashboard\OrderController@destroy')->name('order.destroy');
            });

            Route::group(['prefix' => 'ads'], function () {
                Route::get('waiting', 'Dashboard\AdController@waiting_ads')->name('ads.waiting');
                Route::get('accepted', 'Dashboard\AdController@accepted_ads')->name('ads.accepted');
                Route::get('unaccepted', 'Dashboard\AdController@unaccepted_ads')->name('ads.unaccepted');
                Route::get('{ad_id}/show', 'Dashboard\AdController@show')->name('ads.show');
                Route::put('waiting/reply', 'Dashboard\AdController@reply_ad_request')->name('ads.reply');
                Route::delete('{ad_id}', 'Dashboard\AdController@destroy')->name('ads.destroy');
            });

            Route::group(['prefix' => 'bank_transfer'], function () {
                Route::get('ads', 'Dashboard\BankTransferController@pay_advertising_fees')->name('bank_transfer.ads');
                Route::get('providers_subscriptions', 'Dashboard\BankTransferController@pay_of_the_provider_subscription')->name('bank_transfer.providers_subscriptions');
                Route::get('delegate', 'Dashboard\BankTransferController@pay_of_the_delegate_subscription')->name('bank_transfer.delegate');
                Route::put('retrieve', 'Dashboard\BankTransferController@retrieve_bank_transfer')->name('bank_transfer.retrieve');
            });

            Route::group(['prefix' => 'retrieve_order'], function () {
                Route::get('requests', 'Dashboard\RetrieveOrderController@all_requests')->name('retrieve_order.requests');
                Route::get('retrieved', 'Dashboard\RetrieveOrderController@all_retrieved')->name('retrieve_order.retrieved');
                Route::put('reply', 'Dashboard\RetrieveOrderController@reply_request')->name('retrieve_order.reply');
            });

            Route::group(['prefix' => 'notification'], function () {
                Route::post('single/send', 'Dashboard\NotificationController@send_single_notification')->name('notification.send_single');
                Route::post('multiple/send', 'Dashboard\NotificationController@send_multiple_notification')->name('notification.send_multiple');
            });

            Route::group(['prefix' => 'statistics'], function () {
                Route::get('real/weekly', 'Dashboard\StatisticsController@real_weekly')->name('statistics.real_weekly');
                Route::get('real/weekly_days', 'Dashboard\StatisticsController@real_weekly_days')->name('statistics.real_weekly_days');
                Route::get('real/yearly', 'Dashboard\StatisticsController@real_yearly')->name('statistics.real_yearly');
                Route::get('real/yearly_days', 'Dashboard\StatisticsController@real_yearly_days')->name('statistics.real_yearly_days');
            });

            Route::group(['prefix' => 'setting'], function () {
                Route::get('/', 'Dashboard\SettingController@index')->name('setting.index');
                Route::post('update', 'Dashboard\SettingController@update')->name('setting.update');
            });

            Route::group(['prefix' => 'user_reports'], function () {
                Route::get('/', 'Dashboard\UserReportController@index')->name('user_reports.index');
                Route::get('show/{user_report_id}', 'Dashboard\UserReportController@show')->name('user_reports.show');
            // Route::post('update', 'Dashboard\UserReportController@update')->name('user_reports.update');
                Route::delete('delete/{user_report_id}', 'Dashboard\UserReportController@destroy')->name('user_reports.destroy');
            });

            Route::resource('contact', 'Dashboard\ContactController');
            Route::post('reply', 'Dashboard\ContactController@reply')->name('contact.reply');
        });
    });
});