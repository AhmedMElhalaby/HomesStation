<?php

return [
    'news' => 'أحدث الاضافات',
    'about' => 'عن التطبيق',
    'privacy_policy' => 'سياسة الخصوصية',    
    'not_have_permission' => " لا تملك الصلاحية لعمل هذا الامر ",
    'email_exist' => " هذا البريد موجود بالفعل ",
    'new_fcm_alert' => 'لديك تنبيه جديد',

    // =====================================

    // category
    'category_id_required' => 'category_id مطلوب',
    'category_not_found' => 'القسم غير متاح',
    
    'subcategory_id_required' => 'subcategory_id مطلوب',

    // category provider
    'category_provider_not_found' => 'هذا القسم غير موجود بالأسرة',
    'category_provider_id_required' => 'category_provider_id مطلوب',

    // user
    'user_id_required' => 'user_id مطلوب',
    'user_not_found' => 'هذا المستخدم غير موجود بالنظام',

    // provider
    'provider_id_required' => 'provider_id مطلوب',
    'provider_name_required' => 'اسم مقدم الخدمة مطلوب',
    'provider_not_found' => 'هذه الأسرة غير موجودة بالنظام',
    'notSubscribed' => 'إنتهى الإشتراك الخاص به',

    // cart
    'cart_id_required' => 'cart_id مطلوب',
    'cart_not_found' => 'رقم السلة غير موجود بالنظام',
    'cart_is_empty' => 'السلة فارغة',

    // notification
    'notification_id_required' => 'notification_id مطلوب',
    'notification_not_found' => 'الإشعار غير موجود بالنظام',

    // order
    'order_id_required' => 'order_id مطلوب',
    'has_delegate_required' => 'has_delegate مطلوب',
    'order_not_found' => 'هذا الطلب غير موجود بالنظام',
    'can_not_accept_or_reject_this_order' => 'لا يمكنك قبول او رفض هذا الطلب',
    'can_not_modify_status_for_this_order' => 'لا يمكنك تغيير حالة هذا الطلب',
    'order_status' => [
        'products' => [
            'client_waiting' => 'بإنتظار رد مقدم الخدمة',
            'client_cancel' => 'تم إنهاء الطلب من قبل العميل',
            'provider_accepted_and_search_about_delegate' => 'جاري تجهيز الطلب والبحث عن مندوب',
            'provider_accepted_and_provider_will_be_delivered_the_order' => 'جاري تجهيز الطلب وسيقوم مقدم الخدمة بتوصيل الطلب',
            'provider_rejected' => 'طلب مرفوض',
            'delegate_accepted_order_being_processed' => 'قام مندوب بالموافقة على توصيل الطلب في انتظار انتهاء تجهيز الطلب من قبل مقدم الخدمة',
            'order_processed_delegate_waiting_to_accept' => 'انتهى مقدم الخدمة من تجهيز الطلب في انتظار قبول احد المندوبين توصيل الطلب',
            'order_processed_delegate_waiting_to_receive' => 'انتهى مقدم الخدمة من تجهيز الطلب في انتظار وصول المندوب لإستلام الطلب',
            'delegate_on_the_way' => 'المندوب في الطريق لتوصيل الطلب',
            'finished_order_without_rate' => 'تم تسليم الطلب في إنتظار تقييم الطلب من قبل العميل',
            'finished_order_with_rate' => 'طلب منتهي',
            'products_client_cancel' => 'طلب ملغي من قبل العميل',
        ],
        'services' => [
            'client_waiting' => 'بإنتظار رد مقدم الخدمة',
            'provider_accepted' => 'جاري تجهيز الطلب',
            'provider_rejected' => 'طلب مرفوض',
            'delegate_on_the_way' => 'الطلب بالطريق',
            'finished_order_without_rate' => 'تم تسليم الطلب في انتظار التقييم',
            'finished_order_with_rate' => 'طلب منتهي',
            'services_client_cancel' => 'طلب ملغي من قبل العميل',
        ],
    ],

    // rate
    'rate_required' => 'لم تقم بارسال التقييم',
    'reason_required' => 'لم تقم بارسال السبب',

    // ads
    'reached_to_the_maximum_number_of_ads_in_this_day' => 'تم الوصول الى الحد الأعلى لعدد الإعلانات في هذا اليوم',
    
    // country
    'country_not_found' => 'الدولة غير موجود بالنظام',
    
    // service
    'service_id_required' => 'service_id مطلوب',
    'service_not_found' => 'هذه الخدمة غير موجودة بالنظام',
    'offer_price_required' => 'سعر العرض مطلوب',
    'service_unavailable' => 'الخدمة غير متاحة حاليا',

    // image
    'image_id_required' => 'image_id مطلوب',
    'image_not_found' => 'هذه الصورة غير موجودة بالنظام',

    'added_successfully' => 'تمت الإضافة بنجاح',
    'updated_successfully' => 'تمت التعديل بنجاح',
    'deleted_successfully' => 'تم الحذف بنجاح',
    'activated_successfully' => 'تم التفعيل بنجاح',
    'sent_successfully' => 'تم الارسال بنجاح',
    'not_allowed_to_put_services_from_different_providers_or_categories' => 'غير مسموح لك بوضع خدمات من اسرتين مختلفتين أو من قسمين مختلفين في نفس الطلب',
    'not_allowed_to_modify' => 'غير مسموح لك بتعديل البيانات',
    'not_allowed_to_delete' => 'غير مسموح لك بحذف البيانات',

    // validation
    'lat_and_lng_required' => 'إحداثيات البحث مطلوبة',
    'deleted_file' => 'ملف محذوف',

    // device
    'device_type_required' => 'device_type لم تقم بإرسال',

    // password
    'password_not_match' => 'كلمة المرور غير متطابقة',
    'new_password' => 'كلمة المرور الجديدة مطلوبة',

    // mobile
    'mobile_required' => 'رقم الجوال مطلوب',

    'code_required' => 'كود التفعيل مطلوب',
    'wrong_code' => 'الكود المدخل خاطئ',
    'code_message' => 'كود التحقق الخاص بك هو ',

    // chat 
    'conversation_required' => 'الرجاء إرسال conversation_id',
    'conversation_not_found' => 'لا يوجد محادثة',
    'msg_empty' => 'الرسالة فارغة',
    'attachment_picture' => 'مرفق صورة',

    // FCM
    'fcm' => [
        'title' => 'تطبيق هومز استيشن',
        'new_chat_message' => 'رسالة جديدة',
    ],
    
    'sub_cat_id_and_txt_required' => 'يجب ارسال القسم الفرعى ونص البحث',
];
