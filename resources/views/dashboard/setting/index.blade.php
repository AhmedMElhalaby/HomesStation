@extends('dashboard.layout')

@section('script')
    <!-- Theme JS files -->
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/form_layouts.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>    
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/form_select2.js"></script>    
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>    
    <!-- /theme JS files -->
@endsection

@section('content')
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"> {{ trans('dash.about_and_terms') }} </h5>        
    </div>
    <div class="panel-body">
        <form class="form-horizontal form-validate-jquery" action="{{ route('setting.update') }}" method="POST">
            {{ csrf_field() }}
            <fieldset class="content-group">
                <legend class="text-bold"></legend>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.about_ar') }} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea rows="5" cols="5" name="about_ar" class="form-control" required="required" placeholder="{{ trans('dash.about_ar') }}">
                            {{ settings('about_ar') }}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.about_en') }} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea rows="5" cols="5" name="about_en" class="form-control" required="required" placeholder="{{ trans('dash.about_en') }}">
                            {{ settings('about_en') }}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.policy_terms_ar') }} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea rows="5" cols="5" name="policy_terms_ar" class="form-control" required="required" placeholder="{{ trans('dash.policy_terms_ar') }}">
                            {{ settings('policy_terms_ar') }}
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.policy_terms_en') }} <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea rows="5" cols="5" name="policy_terms_en" class="form-control" required="required" placeholder="{{ trans('dash.policy_terms_en') }}">
                            {{ settings('policy_terms_en') }}
                        </textarea>
                    </div>
                </div>
            </fieldset>            
            <div class="text-right">
                <button type="submit" class="btn btn-primary">{{ trans('dash.update_data') }}<i class="icon-arrow-left13 position-right"></i></button>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"> {{ trans('dash.contact_general_data') }} </h5>        
    </div>
    <div class="panel-body">
        <form class="form-horizontal form-validate-jquery" action="{{ route('setting.update') }}" method="POST">
            {{ csrf_field() }}
            <fieldset class="content-group">
                <legend class="text-bold"></legend>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.facebook_url') }}  </label>
                    <div class="col-lg-9">
                        <input type="text" value="{{ settings('facebook_url') }}" name="facebook_url" class="form-control" placeholder="{{ trans('dash.facebook_url') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.twitter_url') }}  </label>
                    <div class="col-lg-9">
                        <input type="text" value="{{ settings('twitter_url') }}" name="twitter_url" class="form-control" placeholder="{{ trans('dash.twitter_url') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.instagram_url') }}  </label>
                    <div class="col-lg-9">
                        <input type="text" value="{{ settings('instagram_url') }}" name="instagram_url" class="form-control" placeholder="{{ trans('dash.instagram_url') }}">
                    </div>
                </div>            
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.youtube_url') }}  </label>
                    <div class="col-lg-9">
                        <input type="text" value="{{ settings('youtube_url') }}" name="youtube_url" class="form-control" placeholder="{{ trans('dash.youtube_url') }}">
                    </div>
                </div>            
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.whatsapp_phone') }}  </label>
                    <div class="col-lg-9">
                        <input type="text" value="{{ settings('whatsapp_phone') }}" name="whatsapp_phone" class="form-control" placeholder="{{ trans('dash.whatsapp_phone') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.mobile') }}  </label>
                    <div class="col-lg-9">
                        <input type="text" value="{{ settings('mobile') }}" name="mobile" class="form-control" placeholder="{{ trans('dash.mobile') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.email') }}  </label>
                    <div class="col-lg-9">
                        <input type="text" value="{{ settings('email') }}" name="email" class="form-control" placeholder="{{ trans('dash.email') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.app_lang') }}  </label>
                    <div class="col-md-9">
                        <select name="app_lang" class="select-border-color border-warning" >                           
                           @if(settings('app_lang') == 'ar')
                                <option value="ar" selected> Arabic Language - اللغة العربية </option>
                                <option value="en"> English Language - اللغة الإنجليزية </option>
                            @else
                                <option value="ar"> Arabic Language - اللغة العربية </option>
                                <option value="en" selected> English Language - اللغة الإنجليزية </option>
                            @endif
                        </select>
                    </div>
                </div>
            </fieldset>            
            <div class="text-right">
                <button type="submit" class="btn btn-primary">{{ trans('dash.update_data') }} <i class="icon-arrow-left13 position-right"></i></button>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title"> {{ trans('dash.application_settings') }} </h5>        
    </div>
    <div class="panel-body">
        <form class="form-horizontal form-validate-jquery" action="{{ route('setting.update') }}" method="POST">
            {{ csrf_field() }}
            <fieldset class="content-group">
                <legend class="text-bold"></legend>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.num_of_search_km_for_provider') }}  </label>
                    <div class="col-lg-9">
                        <input type="number" value="{{ settings('num_of_search_km_for_provider') }}" name="num_of_search_km_for_provider" class="form-control" placeholder="{{ trans('dash.num_of_search_km_for_provider') }}">
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.app_precentage_from_provider') }}  </label>
                    <div class="col-lg-9">
                        <input type="number" value="{{ settings('app_precentage_from_provider') }}" name="app_precentage_from_provider" class="form-control" placeholder="{{ trans('dash.app_precentage_from_provider') }}">
                    </div>
                </div> --}}
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.delivery_price') }}  </label>
                    <div class="col-lg-9">
                        <input type="number" value="{{ settings('delivery_price') }}" name="delivery_price" class="form-control" placeholder="{{ trans('dash.delivery_price') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.number_of_ads_in_day') }}  </label>
                    <div class="col-lg-9">
                        <input type="number" value="{{ settings('number_of_ads') }}" name="number_of_ads" class="form-control" placeholder="{{ trans('dash.number_of_ads_in_day') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.price_of_delegate_subscription') }}  </label>
                    <div class="col-lg-9">
                        <input type="number" value="{{ settings('price_of_delegate_subscription') }}" name="price_of_delegate_subscription" class="form-control" placeholder="{{ trans('dash.price_of_delegate_subscription') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.price_of_publishing_an_ad') }}  </label>
                    <div class="col-lg-9">
                        <input type="number" value="{{ settings('price_of_publishing_an_ad') }}" name="price_of_publishing_an_ad" class="form-control" placeholder="{{ trans('dash.price_of_publishing_an_ad') }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.free_trial_availability') }}  </label>
                    <div class="col-md-9">
                        <select name="free_trial_availability" class="select-border-color border-warning" >                           
                           @if(settings('free_trial_availability') == 'available')
                                <option value="available" selected> available - متاح </option>
                                <option value="unavailable"> unavailable - غير متاح </option>
                            @else
                                <option value="available"> available - متاح </option>
                                <option value="unavailable" selected> unavailable - غير متاح </option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.free_trial_period_type') }}  </label>
                    <div class="col-lg-9">
                        <select name="free_trial_period_type" class="select-border-color border-warning" >
                            @if(settings('free_trial_period_type') == 'hours')
                                <option value="hours" selected> hours - ساعات </option>
                            @else
                                <option value="hours"> hours - ساعات </option>
                            @endif
                            @if(settings('free_trial_period_type') == 'days')
                                <option value="days" selected> days - أيام </option>
                            @else
                                <option value="days"> days - أيام </option>
                            @endif
                            @if(settings('free_trial_period_type') == 'weeks')
                                <option value="weeks" selected> weeks - أسابيع </option>
                            @else
                                <option value="weeks"> weeks - أسابيع </option>
                            @endif
                            @if(settings('free_trial_period_type') == 'months')
                                <option value="months" selected> months - شهور </option>
                            @else
                                <option value="months"> months - شهور </option>
                            @endif
                            @if(settings('free_trial_period_type') == 'years')
                                <option value="years" selected> years - سنين </option>
                            @else
                                <option value="years"> years - سنين </option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3"> {{ trans('dash.free_trial_period') }}  </label>
                    <div class="col-lg-9">
                        <input type="text" value="{{ settings('free_trial_period') }}" name="free_trial_period" class="form-control" placeholder="{{ trans('dash.free_trial_period') }}">
                    </div>
                </div>
            </fieldset>            
            <div class="text-right">
                <button type="submit" class="btn btn-primary">{{ trans('dash.update_data') }} <i class="icon-arrow-left13 position-right"></i></button>
            </div>
        </form>
    </div>
</div>
@endsection