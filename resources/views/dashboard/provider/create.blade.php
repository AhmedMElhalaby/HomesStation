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
        <form action="{{ route('provider.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.add_new_provider') }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.username') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="username" placeholder="{{ trans('dash.username') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.fullname') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="fullname" placeholder="{{ trans('dash.fullname') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.mobile') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="mobile" class="form-control" placeholder="{{ trans('dash.mobile') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.password') }}</label>
                        <div class="col-lg-9">
                            <input type="password" name="password" class="form-control"  >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.email') }}</label>
                        <div class="col-lg-9">
                            <input type="email" name="email" class="form-control" placeholder="{{ trans('dash.email') }}" >
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
                                    <option value="{{ $city->id }}"> {{ $city->name_ar }} </option>
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
                                    <option value="{{ $nationality->id }}"> {{ $nationality->name_ar }} </option>
                                @empty
                                @endforelse
                            </select>
                        </div>                        
                    </div>                    
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block"> {{ trans('dash.status_account') }} </label>
                        <div class="col-lg-9">
                            <select name="active" class="select-border-color border-warning" >
                                <option value="active"> {{ trans('dash.active') }} </option>                                
                                <option value="deactive"> {{ trans('dash.deactive') }} </option>                                
                            </select>
                        </div>                        
                    </div> 
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block"></label>
                        <div class="col-lg-9">
                            <select name="banned" class="select-border-color border-warning" >
                                <option value="0"> {{ trans('dash.not_banned_account') }} </option>                                
                                <option value="1"> {{ trans('dash.banned_account') }} </option>                                
                            </select>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block">{{ trans('dash.ban_reason') }}</label>
                        <div class="col-lg-9">
                            <textarea rows="5" cols="5" name="ban_reason" class="form-control" placeholder="{{ trans('dash.ban_reason') }}"></textarea>
                        </div>
                    </div>
                    <legend class="text-semibold"><i class="icon-truck position-left"></i> {{ trans('dash.provider_data') }} </legend>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.store_name') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="store_name" class="form-control" value="{{ old('store_name') }}" placeholder="{{ trans('dash.store_name') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block"> {{ trans('dash.is_verified') }} </label>
                        <div class="col-lg-9">
                            <select name="is_verified" class="select-border-color border-warning" >
                                <option value="verified"> {{ trans('dash.verified') }} </option>                                
                                <option value="unverified"> {{ trans('dash.unverified') }} </option>                                
                            </select>
                        </div>                        
                    </div> 
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.minimum_charge') }}</label>
                        <div class="col-lg-9">
                            <input type="number" name="minimum_charge" class="form-control" value="{{ old('minimum_charge') }}" placeholder="{{ trans('dash.minimum_charge') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.opening_time') }}</label>
                        <div class="col-lg-9">
                            <input type="time" name="opening_time" class="form-control" value="{{ old('opening_time') }}" placeholder="{{ trans('dash.opening_time') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.closing_time') }}</label>
                        <div class="col-lg-9">
                            <input type="time" name="closing_time" class="form-control" value="{{ old('closing_time') }}" placeholder="{{ trans('dash.closing_time') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.commercial_register_number') }}</label>
                        <div class="col-lg-9">
                            <input type="number" name="commercial_register_number" class="form-control" value="{{ old('commercial_register_number') }}" placeholder="{{ trans('dash.commercial_register_number') }}" >
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
                                    <option value="{{ $category->id }}">{{ $category['name_' . app()->getLocale()] }}</option>                                    
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.add_forword_2_menu') }} " />
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
