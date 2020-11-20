@extends('dashboard.layout')

@section('script')
    <!-- Theme JS files -->
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>    
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/form_layouts.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>    
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/form_select2.js"></script>    
    <!-- /theme JS files -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <!-- Basic layout-->
        <form action="{{ route('provider.update', $provider->id) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.edit_provider') }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.username') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="username" value="{{ $provider->username }}" placeholder="{{ trans('dash.username') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.fullname') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="fullname" value="{{ $provider->fullname }}" placeholder="{{ trans('dash.fullname') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.mobile') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="mobile" value="{{ $provider->mobile }}" class="form-control" placeholder="{{ trans('dash.mobile') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.password') }}</label>
                        <div class="col-lg-9">
                            <input type="password" name="password" class="form-control" placeholder="{{ trans('dash.password') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.email') }}</label>
                        <div class="col-lg-9">
                            <input type="email" name="email" class="form-control" value="{{ $provider->email }}" placeholder="{{ trans('dash.email') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"> {{ trans('dash.profile_image') }}</label>
                        <div class="col-lg-9">
                            <input type="file" class="file-styled" name="avatar">
                            <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block"> {{ trans('dash.city') }} </label>
                        <div class="col-lg-9">
                            <select name="city_id" class="select-border-color border-warning" >
                            @forelse($countries as $country)
                            <optgroup label="{{ $country->name_ar }}">
                                @foreach ($country->Cities as $city)
                                    @if($city->id == $provider->city_id)
                                        <option value="{{ $city->id }}" selected> {{ $city->name_ar }} </option>
                                    @else
                                        <option value="{{ $city->id }}"> {{ $city->name_ar }} </option>
                                    @endif
                                @endforeach
                            </optgroup>
                            @empty
                            @endforelse
                        </select>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block"> {{ trans('dash.nationality') }} </label>
                        <div class="col-lg-9">
                            <select name="nationality_id" class="select-border-color border-warning" >
                            @forelse($nationalities as $nationality)
                                @if($nationality->id == $provider->nationality_id)
                                    <option value="{{ $nationality->id }}" selected> {{ $nationality->name_ar }} </option>
                                @else
                                    <option value="{{ $nationality->id }}"> {{ $nationality->name_ar }} </option>
                                @endif
                            @empty
                            @endforelse
                        </select>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block"> {{ trans('dash.status_account') }} </label>
                        <div class="col-lg-9">
                            <select name="active" class="select-border-color border-warning" >
                                @if($provider->active == 'active')
                                    <option value="active" selected> {{ trans('dash.active') }} </option>                                
                                    <option value="deactive"> {{ trans('dash.deactive') }} </option>                                
                                @else
                                    <option value="active"> {{ trans('dash.active') }} </option>                                
                                    <option value="deactive" selected> {{ trans('dash.deactive') }} </option>                                
                                @endif
                            </select>
                        </div>                        
                    </div> 
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block"></label>
                        <div class="col-lg-9">
                            <select name="banned" class="select-border-color border-warning" >
                                @if($provider->banned == '0')
                                    <option value="0" selected> {{ trans('dash.not_banned_account') }} </option>                                
                                    <option value="1"> {{ trans('dash.banned_account') }} </option>                                
                                @else
                                    <option value="0"> {{ trans('dash.not_banned_account') }} </option>                                
                                    <option value="1" selected> {{ trans('dash.banned_account') }} </option>                                
                                @endif
                            </select>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block">{{ trans('dash.ban_reason') }}</label>
                        <div class="col-lg-9">
                            <textarea rows="5" cols="5" name="ban_reason" class="form-control" placeholder="{{ trans('dash.ban_reason') }}">
                                {{ $provider->ban_reason }}
                            </textarea>
                        </div>
                    </div>
                    <legend class="text-semibold"><i class="icon-truck position-left"></i> {{ trans('dash.provider_data') }} </legend>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.store_name') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="store_name" class="form-control" value="{{ $provider->ProviderData->store_name }}" placeholder="{{ trans('dash.store_name') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block"> {{ trans('dash.is_verified') }} </label>
                        <div class="col-lg-9">
                            <select name="is_verified" class="select-border-color border-warning" >
                                @if($provider->is_verified == 'verified')
                                    <option value="verified" selected> {{ trans('dash.verified') }} </option>                                
                                    <option value="unverified"> {{ trans('dash.unverified') }} </option>
                                @else
                                    <option value="verified"> {{ trans('dash.verified') }} </option>                                
                                    <option value="unverified" selected> {{ trans('dash.unverified') }} </option>
                                @endif
                            </select>
                        </div>                        
                    </div> 
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.minimum_charge') }}</label>
                        <div class="col-lg-9">
                            <input type="number" name="minimum_charge" class="form-control" value="{{ $provider->ProviderData->minimum_charge }}" placeholder="{{ trans('dash.minimum_charge') }}" >
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.opening_time') }}</label>
                        <div class="col-lg-9">
                            <input type="time" name="opening_time" class="form-control" value="{{ $provider->ProviderData->opening_time }}" placeholder="{{ trans('dash.opening_time') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.closing_time') }}</label>
                        <div class="col-lg-9">
                            <input type="time" name="closing_time" class="form-control" value="{{ $provider->ProviderData->closing_time }}" placeholder="{{ trans('dash.closing_time') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.commercial_register_number') }}</label>
                        <div class="col-lg-9">
                            <input type="number" name="commercial_register_number" class="form-control" value="{{ $provider->ProviderData->commercial_register_number }}" placeholder="{{ trans('dash.commercial_register_number') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"> {{ trans('dash.commercial_register_image') }}</label>
                        <div class="col-lg-9">
                            <input type="file" class="file-styled" name="commercial_register_image">
                            <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.categories') }}</label>
                        <div class="col-lg-9">
                            <select multiple="multiple" name="categories[]" class="select">
                                @foreach($categories as $category)
                                    @if(App\Models\CategoryProvider::where(['user_id' => $provider->id, 'category_id' => $category->id])->exists())
                                        <option value="{{ $category->id }}" selected>{{ $category['name_' . app()->getLocale()] }}</option>                                    
                                    @else
                                        <option value="{{ $category->id }}">{{ $category['name_' . app()->getLocale()] }}</option>                                    
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.edit_forword_2_menu') }} " />
                        <input type="reset" class="btn btn-warning" value=" {{ trans('dash.reset_data') }} " />
                        <a href="{{ route('provider.index') }}" class="btn btn-success">{{ trans('dash.back_to_menu') }}</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /basic layout -->
    </div>
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"> {{ trans('dash.last_providers') }} </h5>                    
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="text-center">
                        <th> {{ trans('dash.username') }} </th>
                        <th> {{ trans('dash.image') }} </th>
                    </tr>
                    @forelse($last_providers as $provider)
                    <tr>
                        <td> {{ $provider->username }}</td>
                        <td> <img height="80px" width="80px" src="{{ $provider->image400 }}" /> </td>
                    </tr>
                    @empty
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
