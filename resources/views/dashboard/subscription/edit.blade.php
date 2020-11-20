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
        <form action="{{ route('subscription.update', $subscription->id) }}" class="form-horizontal" method="post">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.edit_subscription') }} : {{ $subscription['name_' . app()->getLocale()] }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.subscription.name_ar') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="name_ar" value="{{ $subscription->name_ar }}" placeholder="{{ trans('dash.subscription.name_ar') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.subscription.name_en') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="name_en" value="{{ $subscription->name_en }}" class="form-control" placeholder="{{ trans('dash.subscription.name_en') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label"> {{ trans('dash.subscription.user_type') }} </label>
                        <div class="col-lg-9">
                            <select name="user_type" class="select-border-color border-warning" >
                                @if($subscription->user_type == 'providers')
                                    <option value="providers" selected> providers - مقدمي الخدمات </option>
                                    <option value="delegates"> delegates - المناديب </option>
                                @else
                                    <option value="providers"> providers - مقدمي الخدمات </option>
                                    <option value="delegates" selected> delegates - المناديب </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.subscription.period') }}</label>
                        <div class="col-lg-9">
                            <input type="number" name="period" value="{{ $subscription->period }}" class="form-control" placeholder="{{ trans('dash.subscription.period') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.subscription.period_type') }}</label>
                        <div class="col-lg-9">
                            <select name="period_type" class="select-border-color border-warning" >
                                @if($subscription->period_type == 'hours')
                                    <option value="hours" selected> hours - ساعات </option>
                                @else
                                    <option value="hours"> hours - ساعات </option>
                                @endif
                                @if($subscription->period_type == 'days')
                                    <option value="days" selected> days - أيام </option>
                                @else
                                    <option value="days"> days - أيام </option>
                                @endif
                                @if($subscription->period_type == 'weeks')
                                    <option value="weeks" selected> weeks - أسابيع </option>
                                @else
                                    <option value="weeks"> weeks - أسابيع </option>
                                @endif
                                @if($subscription->period_type == 'months')
                                    <option value="months" selected> months - شهور </option>
                                @else
                                    <option value="months"> months - شهور </option>
                                @endif
                                @if($subscription->period_type == 'years')
                                    <option value="years" selected> years - سنين </option>
                                @else
                                    <option value="years"> years - سنين </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.subscription.price') }}</label>
                        <div class="col-lg-9">
                            <input type="number" name="price" value="{{ $subscription->price }}" class="form-control" placeholder="{{ trans('dash.subscription.price') }}" required>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.edit_forword_2_menu') }} " />
                        <input type="reset" class="btn btn-warning" value=" {{ trans('dash.reset_data') }} " />
                        <a href="{{ route('subscription.index') }}"  class="btn btn-success">{{ trans('dash.back_to_menu') }}</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /basic layout -->
    </div>
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"> {{ trans('dash.subscription.latest_subscriptions') }} </h5>                    
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="text-center">
                        <th> {{ trans('dash.subscription.name_ar') }} </th>
                        <th> {{ trans('dash.subscription.name_en') }} </th>
                        <th> {{ trans('dash.subscription.price') }} </th>
                    </tr>
                    @foreach($latest_subscriptions as $subscription)
                    <tr>
                        <td> {{ $subscription->name_ar }} </td>
                        <td> {{ $subscription->name_en }} </td>
                        <td> {{ $subscription->price }} </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
