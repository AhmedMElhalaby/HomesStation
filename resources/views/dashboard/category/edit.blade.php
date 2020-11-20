@extends('dashboard.layout')
@section('script')
    <!-- Theme JS files -->
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
        <form action="{{ route('category.update', $category->id) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.edit_category') }} : {{ $category['name_' . app()->getLocale()] }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label"> {{ trans('dash.image') }}</label>
                        <div class="col-lg-6">
                            <input type="file" class="file-styled" name="image">
                        </div>
                        <div class="col-lg-3">
                            <img src="{{ $category->image200 }}" class="img-thumbnail" alt="Cinque Terre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.name_ar') }}</label>
                        <div class="col-lg-9">
                            <input type="text" value="{{ $category->name_ar }}" class="form-control" name="name_ar" placeholder="{{ trans('dash.name_ar') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.name_en') }}</label>
                        <div class="col-lg-9">
                            <input type="text" value="{{ $category->name_en }}" name="name_en" class="form-control" placeholder="{{ trans('dash.name_en') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.type') }}</label>
                        <div class="col-lg-9">
                            <select name="type" class="select-border-color border-warning" >
                                @if($category->type == 'products')
                                    <option value="products" selected> products - منتجات </option>
                                    <option value="services"> services - خدمات </option>
                                @else
                                    <option value="products"> products - منتجات </option>
                                    <option value="services" selected> services - خدمات </option>
                                @endif
                            </select>
                        </div>
                    </div>                    
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.edit_forword_2_menu') }} " />
                        <input type="reset" class="btn btn-warning" value=" {{ trans('dash.reset_data') }} " />
                        <a href="{{ route('category.index') }}"  class="btn btn-success">{{ trans('dash.back_to_menu') }}</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /basic layout -->
    </div>
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"> {{ trans('dash.latest_categories') }} </h5>                    
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="text-center">
                        <th> {{ trans('dash.image') }} </th>
                        <th> {{ trans('dash.name_ar') }} </th>
                        <th> {{ trans('dash.name_en') }} </th>
                    </tr>
                    @foreach($latest_categories as $category)
                    <tr>
                        <td> <img height="60px" width="100px" src="{{ $category->image200 }}" /> </td>
                        <td> {{ $category->name_ar }} </td>
                        <td> {{ $category->name_en }} </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
