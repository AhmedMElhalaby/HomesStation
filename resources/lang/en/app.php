<?php

return [
    'news' => 'Latest Added',
    'about' => 'About Application',
    'privacy_policy' => 'Privacy Policy',
    'not_have_permission' => " U haven' t any permission to make this action ",
    'email_exist' => " this email already exists ",
    'new_fcm_alert' => 'You Have new Alert',

    // =====================================

    // category
    'category_id_required' => 'category_id is required',
    'category_not_found' => 'category not found',
    'ad_not_found' => 'Ad not found',

    'subcategory_id_required' => 'subcategory_id is required',

    // category provider
    'category_provider_not_found' => 'category provider not found',
    'category_provider_id_required' => 'category_provider_id is required',

    // user
    'user_id_required' => 'user_id required',
    'user_not_found' => 'this user not found on system',

    // provider
    'provider_id_required' => 'provider_id required',
    'provider_name_required' => 'provider name is required',
    'provider_not_found' => 'this provider not found on system',

    // cart
    'cart_id_required' => 'cart_id required',
    'cart_not_found' => 'this cart not found on system',
    'cart_is_empty' => 'your cart is empty',

    // notification
    'notification_id_required' => 'notification_id required',
    'notification_not_found' => 'this notification not found on system',

    // order
    'order_id_required' => 'order_id required',
    'has_delegate_required' => 'has_delegate required',
    'order_not_found' => 'this order not found on system',
    'can_not_accept_or_reject_this_order' => 'Can\'t accept or reject this order',
    'can_not_modify_status_for_this_order' => 'Can\'t modify status for this order',
    'order_status' => [
        'products' => [
            'client_waiting' => 'Waiting for the response of the provider',
            'provider_accepted_and_search_about_delegate' => 'The order is being processed and being searched about delegate',
            'provider_accepted_and_provider_will_be_delivered_the_order' => 'The order is being processed and the provider will deliver the order',
            'provider_rejected' => 'Rejected order',
            'delegate_accepted_order_being_processed' => 'The delegate has agreed to deliver the request pending Preparation the order by the service provider',
            'order_processed_delegate_waiting_to_accept' => 'The service provider has finished processing the order pending the acceptance of one of the delegates delivering the order',
            'order_processed_delegate_waiting_to_receive' => 'The service provider has finished processing the order pending the arrival of the delegate to receive the order',
            'delegate_on_the_way' => 'The delegate is on the way to deliver the order',
            'finished_order_without_rate' => 'The order has been received, pending evaluation the order from a client',
            'finished_order_with_rate' => 'Finished order',
        ],
        'services' => [
            'client_waiting' => 'Waiting for the response of the provider',
            'provider_accepted' => 'The order is being processed',
            'provider_rejected' => 'Rejected order',
            'delegate_on_the_way' => 'The order on the road',
            'finished_order_without_rate' => 'The order has been received, pending evaluation',
            'finished_order_with_rate' => 'Finished order',
        ],
    ],

    // rate
    'rate_required' => 'rate is required',
    'reason_required' => 'reason is required',

    // ads
    'reached_to_the_maximum_number_of_ads_in_this_day' => 'reached to the maximum number of ads in this day',

    // country
    'country_not_found' => 'this country not found on system',

    // service
    'service_id_required' => 'service_id required',
    'service_not_found' => 'this service not found on system',
    'offer_price_required' => 'offer_price is required',
    'service_unavailable' => 'Service is currently unavailable',

    // image
    'image_id_required' => 'image_id required',
    'image_not_found' => 'this image not found on system',

    'added_successfully' => 'Added successfully',
    'updated_successfully' => 'Updated successfully',
    'deleted_successfully' => 'Deleted successfully',
    'activated_successfully' => 'Activated successfully',
    'sent_successfully' => 'Sent successfully',
    'subscription_renewed_successfully' => 'Subscription renewed successfully',
    'not_allowed_to_put_services_from_different_providers_or_categories' => 'You are not allowed to put services from other providers or categories in the same order',
    'not_allowed_to_put_services_with_different_delivery_type' => 'You are not allowed to put services with different delivery type in the same order',
    'not_allowed_to_modify' => 'You are not allowed to modify the data',
    'not_allowed_to_delete' => 'You are not allowed to delete the data',

    // validation
    'lat_and_lng_required' => 'lat and lng are required',
    'deleted_file' => 'Deleted file',

    // device
    'device_type_required' => 'device type is required',

    // password
    'password_not_match' => 'The password does not match',
    'new_password' => 'new password is required',

    // mobile
    'mobile_required' => 'mobile is required',

    'code_required' => 'the activation code is required',
    'wrong_code' => 'The input code is wrong',
    'code_message' => 'Your activation code is ',

    // chat
    'conversation_required' => 'conversation_id is required',
    'conversation_not_found' => 'conversation not found',
    'msg_empty' => 'message is empty',
    'attachment_picture' => 'attachment picture',
    'object_not_found' => 'Object not found',

    // FCM
    'fcm' => [
        'title' => 'Homes Station App',
        'new_chat_message' => 'New Message',
    ],
];
