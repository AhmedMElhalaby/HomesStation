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
        <form action="{{ route('permission.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.permissions.add_new_permission') }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('dash.permissions.role_name_ar') }}</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="role_ar" value="{{ old('role_ar') }}" placeholder="{{ trans('dash.permissions.role_name_ar') }}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">{{ trans('dash.permissions.role_name_en') }}</label>
                        <div class="col-lg-10">
                            <input type="text" name="role_en" value="{{ old('role_en') }}" class="form-control" placeholder="{{ trans('dash.permissions.role_name_en') }}" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="permission.index" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="permission.create" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="permission.edit" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="permission.destroy" >
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
                            <h5 class="panel-title"> {{ trans('dash.admins') }} </h5>
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="admin.index" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="admin.create" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="admin.edit" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="admin.destroy" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="user.index" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="user.create" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="user.edit" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="user.destroy" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="provider.index" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="provider.create" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="provider.edit" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="provider.destroy" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="provider.show" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="provider.products" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="country.index" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="country.create" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="country.edit" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="country.destroy" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="city.index" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="city.create" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="city.edit" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="city.destroy" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="category.index" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="category.create" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="category.edit" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="category.destroy" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="order.current" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="order.finished" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="order.show" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="order.destroy" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="contact.index" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="contact.show" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="contact.destroy" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="setting.index" >
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
                                                    <input type="checkbox" name="perms[]" class="switchery" value="setting.update" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.add_forword_2_menu') }} " />
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
