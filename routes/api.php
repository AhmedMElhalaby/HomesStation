<?php

use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

Route::get('categories', 'Api\CategoryController@index');
Route::post('categories/{category_id}/services', 'Api\CategoryController@get_services_by_category');
Route::get('categories/{category_id}/subcategories', 'Api\SubcategoryController@index');
Route::get('subcategories/{subcategory_id}/tags', 'Api\SubcategoryController@tags');
Route::get('categories/{category_id}/providers', 'Api\CategoryController@get_providers');
Route::post('contact', 'Api\ContactController@index');
Route::post('complaint', 'Api\ContactController@complaint');
Route::get('countries', 'Api\CountryController@index');
Route::get('ads/days', 'Api\AdsController@days');
Route::get('ads/{category_id}/today', 'Api\AdsController@ads_today');
Route::get('countries/{country_id}/cities', 'Api\CityController@index');
Route::get('nationalities', 'Api\NationalityController@index');
Route::get('bank_accounts', 'Api\BankController@index');
Route::get('nearest_providers', 'Api\SearchController@nearest_providers');
Route::get('subscription/providers', 'Api\PackageController@providers');
Route::get('subscription/delegates', 'Api\PackageController@delegates');
Route::get('providers/search', 'Api\SearchController@provider_search');
Route::post('providers/search/tags', 'Api\SearchController@search_provider');
Route::get('providers/{provider_id}/subcategory/{subcategory_id}/tags', 'Api\ProviderController@my_tags');
Route::get('providers/{provider_id}/category/{category_id}/subcategory', 'Api\ProviderController@my_subcategories');
Route::post('providers/search/subcategory', 'Api\SearchController@search_provider_by_subcategory_id');
Route::any('product/search', 'Api\SearchController@search_product');

Route::group(['prefix' => 'settings'], function () {
    Route::get('about', 'Api\SettingController@about');
    Route::get('terms', 'Api\SettingController@terms');
    Route::get('social_info', 'Api\SettingController@social_info');
});

Route::group(['prefix' => 'auth'], function () {
    Route::group(['prefix' => 'delegate'], function () {
        Route::post('login', 'Api\DelegateController@login');
        Route::post('register', 'Api\DelegateController@register');
        Route::post('password/forgot', 'Api\DelegateController@forgot_password');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::post('login', 'Api\UserController@login');
        Route::post('login/social', 'Api\UserController@login_with_social');
        Route::post('register', 'Api\UserController@register');
        Route::post('password/forgot', 'Api\UserController@forgot_password');
    });
    Route::group(['prefix' => 'provider'], function () {
        Route::post('login', 'Api\ProviderController@login');
        Route::post('register', 'Api\ProviderController@register');
        Route::post('password/forgot', 'Api\ProviderController@forgot_password');
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::get('{user_id}', 'Api\UserController@show');
});

Route::group(['prefix' => 'delegate'], function () {
    Route::get('{delegate_id}', 'Api\DelegateController@show');
});

Route::group(['prefix' => 'provider'], function () {
    Route::get('{provider_id}/show', 'Api\ProviderController@show');
    Route::get('{provider_id}/categories', 'Api\ProviderController@get_categories');
    Route::get('{provider_id}/rates', 'Api\ProviderController@get_rates');
    Route::post('{provider_id}/categories/{category_id}/services', 'Api\ServiceController@services_by_category_id_provider_id');
    Route::post('category_provider/{category_provider_id}/services', 'Api\ServiceController@services_by_category_provider');

    Route::post('{provider_id}/my_services', 'Api\ProviderController@my_services');

    Route::group(['prefix' => 'service'], function () {
        Route::get('{service_id}', 'Api\ServiceController@show');
        Route::post('{service_id}/update_availability', 'Api\ServiceController@update_availability');
    });
});

Route::group(['middleware' => 'jwt.auth'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::post('logout', 'Api\UserController@logout');
            Route::post('active', 'Api\UserController@active');
            Route::post('password/confirm_code', 'Api\UserController@confirm_code');
            Route::post('password/change', 'Api\UserController@change_password');
        });
        Route::group(['prefix' => 'delegate'], function () {
            Route::post('logout', 'Api\DelegateController@logout');
            Route::post('active', 'Api\DelegateController@active');
            Route::post('password/confirm_code', 'Api\DelegateController@confirm_code');
            Route::post('password/change', 'Api\DelegateController@change_password');
        });
        Route::group(['prefix' => 'provider'], function () {
            Route::post('logout', 'Api\ProviderController@logout');
            Route::post('active', 'Api\ProviderController@active');
            Route::post('password/confirm_code', 'Api\ProviderController@confirm_code');
            Route::post('password/change', 'Api\ProviderController@change_password');
        });
    });

    Route::group(['prefix' => 'provider'], function () {
        Route::put('profile/update', 'Api\ProviderController@update');
        Route::put('store/update', 'Api\ProviderController@update_store_data');
        Route::put('password/update', 'Api\ProviderController@update_password');
        Route::get('statistics', 'Api\ProviderController@statistics');
        Route::post('{product_id}/report', 'Api\ProviderController@send_report');
        Route::group(['prefix' => 'ads'], function () {
            Route::post('send', 'Api\AdsController@send');
        });
        Route::group(['prefix' => 'service'], function () {
            Route::post('add', 'Api\ServiceController@store');
            Route::put('{service_id}', 'Api\ServiceController@update');
            Route::delete('{service_id}/delete', 'Api\ServiceController@delete');
            Route::delete('addition/{addition_id}/delete', 'Api\ServiceController@delete_addition');
            Route::delete('image/{image_id}/delete', 'Api\ServiceController@delete_image');
            Route::group(['prefix' => '{service_id}/discount'], function () {
                Route::put('update', 'Api\OfferController@update');
                Route::delete('delete', 'Api\OfferController@delete');
            });
        });
        Route::group(['prefix' => 'order'], function () {
            Route::get('{order_id}/details', 'Api\ProviderOrderController@details');
            Route::get('current', 'Api\ProviderOrderController@current_orders');
            Route::get('finished', 'Api\ProviderOrderController@finished_orders');
            Route::get('new', 'Api\ProviderOrderController@new_orders');
            Route::put('{order_id}/accept', 'Api\ProviderOrderController@accept_order');
            Route::put('{order_id}/reject', 'Api\ProviderOrderController@reject_order');
            Route::put('{order_id}/successfully_processed', 'Api\ProviderOrderController@successfully_processed');
            Route::put('{order_id}/delivered', 'Api\ProviderOrderController@delivered_order_to_delegate');
            Route::put('{order_id}/finish', 'Api\ProviderOrderController@finish_order');
        });
    });

    Route::group(['prefix' => 'user'], function () {
        Route::put('profile/update', 'Api\UserController@update');
        Route::put('password/update', 'Api\UserController@update_password');
        Route::get('fav/show', 'Api\FavController@index');
        Route::group(['prefix' => 'cart'], function () {
            Route::get('show', 'Api\CartController@show');
            Route::post('add', 'Api\CartController@store');
            Route::put('{cart_id}/edit', 'Api\CartController@update');
            Route::delete('{cart_id}/delete', 'Api\CartController@delete');
        });
        Route::group(['prefix' => 'service'], function () {
            Route::get('fav/show', 'Api\FavController@index');
            Route::get('{service_id}/fav/update', 'Api\FavController@update');
            Route::post('{service_id}/rate/update', 'Api\ServiceController@rate_service');
            Route::post('{service_id}/report', 'Api\ServiceController@send_report');
        });
        Route::group(['prefix' => 'provider'], function () {
            Route::get('{provider_id}/fav/update', 'Api\FavController@update_provider_fav');
        });
        Route::group(['prefix' => 'order'], function () {
            Route::get('{order_id}/details', 'Api\UserOrderController@details');
            Route::get('all', 'Api\UserOrderController@my_orders');
            Route::post('create_from_cart', 'Api\UserOrderController@create_from_cart');
            Route::post('create_by_book', 'Api\UserOrderController@create_by_book');
            Route::put('{order_id}/finish', 'Api\UserOrderController@finish_order');
            Route::put('{order_id}/retrieve', 'Api\UserOrderController@retrieve_order');
            Route::put('{order_id}/cancel', 'Api\UserOrderController@cancel_order');
        });
    });

    Route::group(['prefix' => 'delegate'], function () {
        Route::put('profile/update', 'Api\DelegateController@update');
        Route::put('password/update', 'Api\DelegateController@update_password');
        Route::group(['prefix' => 'order'], function () {
            Route::get('{order_id}/details', 'Api\DelegateOrderController@details');
            Route::get('current', 'Api\DelegateOrderController@current_orders');
            Route::get('new', 'Api\DelegateOrderController@new_orders');
            Route::put('{order_id}/accept', 'Api\DelegateOrderController@accept_order');
            Route::put('{order_id}/current', 'Api\DelegateOrderController@current_order');
            Route::put('{order_id}/receive', 'Api\DelegateOrderController@receive_order');
            Route::put('{order_id}/finish', 'Api\DelegateOrderController@finish_order');
        });
    });

    Route::post('bank_transfer/send', 'Api\BankTransferController@send');
    Route::post('transaction/send', 'Api\BankTransferController@send_transaction');
    Route::get('notifications', 'Api\NotificationController@show');
    Route::delete('notifications/{notification_id}/delete', 'Api\NotificationController@delete');

});
