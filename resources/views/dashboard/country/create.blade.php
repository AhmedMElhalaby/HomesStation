@extends('dashboard.layout')

@section('script')
    <!-- Theme JS files -->
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/form_layouts.js"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/libraries/jquery_ui/interactions.min.js"></script>    
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/form_select2.js"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
    <!-- /theme JS files -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <!-- Basic layout-->
        <form action="{{ route('country.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.add_new_country') }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.name_ar') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="name_ar" placeholder="{{ trans('dash.name_ar') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.name_en') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="name_en" class="form-control" placeholder="{{ trans('dash.name_en') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.phonecode') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="phonecode" class="form-control" placeholder="{{ trans('dash.phonecode') }}" >
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.add_forword_2_menu') }} " />
                        <input type="reset" class="btn btn-warning" value=" {{ trans('dash.reset_data') }} " />
                        <a href="{{ route('country.index') }}" class="btn btn-success">{{ trans('dash.back_to_menu') }}</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /basic layout -->
    </div>
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"> {{ trans('dash.latest_countries') }} </h5>                    
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="text-center">
                        <th> {{ trans('dash.name_ar') }} </th>
                        <th> {{ trans('dash.name_en') }} </th>
                        <th> {{ trans('dash.phonecode') }} </th>
                    </tr>
                    @foreach($latest_countries as $country)
                    <tr>
                        <td> {{ $country->name_ar }} </td>
                        <td> {{ $country->name_en }} </td>
                        <td> {{ $country->phonecode }} </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
