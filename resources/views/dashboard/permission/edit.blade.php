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
    <div class="col-md-12">
        <!-- Basic layout-->
        <form action="{{ route('permission.update', $permission->id) }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.permissions.edit_permission') }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('dash.permissions.role_name_ar') }}</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="role_ar" value="{{ $permission->role_ar }}" placeholder="{{ trans('dash.permissions.role_name_ar') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('dash.permissions.role_name_en') }}</label>
                        <div class="col-lg-10">
                            <input type="text" name="role_en" value="{{ $permission->role_en }}" class="form-control" placeholder="{{ trans('dash.permissions.role_name_en') }}" >
                        </div>
                    </div>
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> {{ trans('dash.permissions.permissions') }} </h5>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.list') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('permission.index', $permission->plan)) checked @endif value="permission.index" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.create') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('permission.create', $permission->plan)) checked @endif value="permission.create" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.edit') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('permission.edit', $permission->plan)) checked @endif value="permission.edit" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.delete') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('permission.destroy', $permission->plan)) checked @endif value="permission.destroy" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                    </div>
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> {{ trans('dash.permissions.admins') }} </h5>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.list') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('admin.index', $permission->plan)) checked @endif value="admin.index" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.create') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('admin.create', $permission->plan)) checked @endif value="admin.create" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.edit') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('admin.edit', $permission->plan)) checked @endif value="admin.edit" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.delete') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('admin.destroy', $permission->plan)) checked @endif value="admin.destroy" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                    </div>
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> {{ trans('dash.users') }} </h5>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.list') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('user.index', $permission->plan)) checked @endif value="user.index" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.create') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('user.create', $permission->plan)) checked @endif value="user.create" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.edit') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('user.edit', $permission->plan)) checked @endif value="user.edit" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.delete') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('user.destroy', $permission->plan)) checked @endif value="user.destroy" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> {{ trans('dash.providers') }} </h5>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.list') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('provider.index', $permission->plan)) checked @endif value="provider.index" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.create') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('provider.create', $permission->plan)) checked @endif value="provider.create" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.edit') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('provider.edit', $permission->plan)) checked @endif value="provider.edit" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.delete') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('provider.destroy', $permission->plan)) checked @endif value="provider.destroy" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.show_data') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('provider.show', $permission->plan)) checked @endif value="provider.show" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.products') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('provider.products', $permission->plan)) checked @endif value="provider.products" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> {{ trans('dash.countries') }} </h5>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.list') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('country.index', $permission->plan)) checked @endif value="country.index" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.create') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('country.create', $permission->plan)) checked @endif value="country.create" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.edit') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('country.edit', $permission->plan)) checked @endif value="country.edit" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.delete') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('country.destroy', $permission->plan)) checked @endif value="country.destroy" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> {{ trans('dash.cities') }} </h5>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.list') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('city.index', $permission->plan)) checked @endif value="city.index" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.create') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('city.create', $permission->plan)) checked @endif value="city.create" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.edit') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('city.edit', $permission->plan)) checked @endif value="city.edit" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.delete') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('city.destroy', $permission->plan)) checked @endif value="city.destroy" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> {{ trans('dash.categories') }} </h5>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.list') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('category.index', $permission->plan)) checked @endif value="category.index" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.create') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('category.create', $permission->plan)) checked @endif value="category.create" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.edit') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('category.edit', $permission->plan)) checked @endif value="category.edit" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.delete') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('category.destroy', $permission->plan)) checked @endif value="category.destroy" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> {{ trans('dash.orders') }} </h5>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.current_orders') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('order.current', $permission->plan)) checked @endif value="order.current" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.finished_orders') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('order.finished', $permission->plan)) checked @endif value="order.finished" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.show_data') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('order.show', $permission->plan)) checked @endif value="order.show" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.delete') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('order.destroy', $permission->plan)) checked @endif value="order.destroy" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> {{ trans('dash.contacts.contact_us') }} </h5>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.list') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('contact.index', $permission->plan)) checked @endif value="contact.index" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.show_data') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('contact.show', $permission->plan)) checked @endif value="contact.show" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.delete') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('contact.destroy', $permission->plan)) checked @endif value="contact.destroy" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <h5 class="panel-title"> {{ trans('dash.settings') }} </h5>
                            <div class="heading-elements">
                                <ul class="icons-list">
                                    <li><a data-action="collapse"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">                                
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.show_data') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('setting.index', $permission->plan)) checked @endif value="setting.index" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label col-lg-3"> {{ trans('dash.edit') }} </label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery switchery-xs">
                                                <label>
                                                    <input type="checkbox" name="perms[]" class="switchery" @if(in_array('setting.update', $permission->plan)) checked @endif value="setting.update" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.edit_forword_2_menu') }} " />
                        <input type="reset" class="btn btn-warning" value=" {{ trans('dash.reset_data') }} " />
                        <a href="{{ route('permission.index') }}" class="btn btn-success">{{ trans('dash.back_to_menu') }}</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /basic layout -->
    </div>
</div>
@endsection