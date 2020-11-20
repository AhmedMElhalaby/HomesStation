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

<div class="row">
    <div class="col-md-6">

        <!-- Basic layout-->
        <form action="{{ route('admin.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.add_new_admin') }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.username') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="{{ trans('dash.username') }}" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.mobile') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control" placeholder="{{ trans('dash.mobile') }}" >
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
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="{{ trans('dash.email') }}" >
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
                        <label class="col-lg-3 control-label display-block"> {{ trans('dash.roles') }} </label>
                        <div class="col-lg-9">
                            <select name="role_id" class="select-border-color border-warning" >
                            @forelse($roles as $role)
                                <option value="{{ $role->id }}"> {{ $role->role_ar }} </option>                              
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
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.add_forword_2_menu') }} " />
                        <input type="reset" class="btn btn-warning" value=" {{ trans('dash.reset_data') }} " />
                        <a href="{{ route('admin.index') }}" class="btn btn-success">{{ trans('dash.back_to_menu') }}</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /basic layout -->
    </div>
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"> {{ trans('dash.last_admins') }} </h5>                    
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="text-center">
                        <th> {{ trans('dash.username') }} </th>
                        <th> {{ trans('dash.image') }} </th>
                    </tr>
                    @forelse($last_admins as $admin)
                    <tr>
                        <td> {{ $admin->username }}</td>
                        <td> <img height="80px" width="80px" src="{{ $admin->image400 }}" /> </td>
                    </tr>
                    @empty
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
