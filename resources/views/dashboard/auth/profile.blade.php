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
<!-- User profile -->
<div class="row">
    <div class="col-lg-8">
        <!-- Profile info -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h6 class="panel-title">{{ trans('dash.profile_information') }}</h6>                            
            </div>
            <div class="panel-body">
                <form method="post" action="{{ route('update.profile') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>{{ trans('dash.username') }}</label>
                                <input type="text" value="{{ auth()->user()->username }}" name="username" placeholder="{{ trans('dash.username') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>{{ trans('dash.email') }}</label>
                                <input type="text" value="{{ auth()->user()->email }}" name="email"  placeholder="{{ trans('dash.email') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>{{ trans('dash.mobile') }}</label>
                                <input type="text" value="{{ auth()->user()->mobile }}" name="mobile" placeholder="{{ trans('dash.mobile') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>{{ trans('dash.city') }}</label>
                                <select name="city_id" class="select-border-color border-warning" >
                                    @forelse($countries as $country)
                                        <optgroup label="{{ $country->name_ar }}">
                                            @foreach ($country->Cities as $city)
                                                @if($city->id == auth()->user()->city_id)
                                                    <option value="{{ $city->id }}" selected> {{ $city->name_ar . ' - ' . $city->name_en }} </option>
                                                @else
                                                    <option value="{{ $city->id }}"> {{ $city->name_ar . ' - ' . $city->name_en }} </option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>                            
                    <div class="form-group">
                        <div class="row">                            
                            <div class="col-md-6">
                                <label class="display-block">{{ trans('dash.profile_image') }}</label>
                                <input type="file" name="avatar" class="file-styled">
                                <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary"> {{ trans('dash.update_data') }} <i class="icon-arrow-left13 position-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Profile info -->
    </div>
    <div class="col-lg-4">
        <!-- Account settings -->
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h6 class="panel-title"> {{ trans('dash.change_password') }} </h6>                
            </div>
            <div class="panel-body">
                <form action="{{ route('update.password') }}" method="post" >
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>{{ trans('dash.current_password') }}</label>
                                <input type="password"  name="old_password" placeholder="{{ trans('dash.current_password') }}" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>{{ trans('dash.new_password') }}</label>
                                <input type="password" name="password" placeholder="{{ trans('dash.new_password') }}" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">                            
                            <div class="col-md-12">
                                <label>{{ trans('dash.confirm_password') }}</label>
                                <input type="password" name="password_confirmation" placeholder="{{ trans('dash.confirm_password') }}" class="form-control" required>
                            </div>
                        </div>
                    </div>                                
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary"> {{ trans('dash.update_password') }} 
                            <i class="icon-arrow-left13 position-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /account settings -->
    </div>
</div>
<!-- /user profile -->        
@endsection

