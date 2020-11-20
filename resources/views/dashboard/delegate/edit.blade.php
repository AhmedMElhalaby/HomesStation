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
        <form action="{{ route('delegate.update', $delegate->id) }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.edit_delegate') }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.username') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="username" value="{{ $delegate->username }}" placeholder="{{ trans('dash.username') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.mobile') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="mobile" value="{{ $delegate->mobile }}" class="form-control" placeholder="{{ trans('dash.mobile') }}" >
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
                            <input type="email" name="email" class="form-control" value="{{ $delegate->email }}" placeholder="{{ trans('dash.email') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.identity_number') }}</label>
                        <div class="col-lg-9">
                            <input type="number" name="identity_number" value="{{ $delegate->identity_number }}" class="form-control" value="{{ old('identity_number') }}" placeholder="{{ trans('dash.identity_number') }}" >
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
                                            @if($city->id == $delegate->city_id)
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
                                    @if($nationality->id == $delegate->nationality_id)
                                        <option value="{{ $nationality->id }}"> {{ $nationality->name_ar }} </option>
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
                                @if($delegate->active == 'active')
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
                                @if($delegate->banned == '0')
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
                                {{ $delegate->ban_reason }}
                            </textarea>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.edit_forword_2_menu') }} " />
                        <input type="reset" class="btn btn-warning" value=" {{ trans('dash.reset_data') }} " />
                        <a href="{{ route('delegate.index') }}" class="btn btn-success">{{ trans('dash.back_to_menu') }}</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /basic layout -->
    </div>
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"> {{ trans('dash.last_delegates') }} </h5>                    
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="text-center">
                        <th> {{ trans('dash.username') }} </th>
                        <th> {{ trans('dash.image') }} </th>
                    </tr>
                    @forelse($last_delegates as $delegate)
                    <tr>
                        <td> {{ $delegate->username }}</td>
                        <td> <img height="80px" width="80px" src="{{ $delegate->image400 }}" /> </td>
                    </tr>
                    @empty
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>
@endsection