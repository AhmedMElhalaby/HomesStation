@extends('dashboard.layout')
@section('script')
	<!-- Theme JS files -->
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/media/fancybox.min.js"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/pages/user_pages_team.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/visualization/echarts/echarts.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/core/app.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/charts/echarts/pies_donuts.js"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/dashboard/material') }}/assets/js/plugins/ui/ripple.min.js"></script>
	<!-- /theme JS files -->
@endsection
@section('content')
<!-- Dashboard content -->
<div class="row">
    <div class="col-lg-12">
        <!-- Quick stats boxes -->
        <div class="row">
            <div class="col-lg-3" onclick="window.location='{{url('dashboard/admin')}}'">
                <div class="panel bg-pink-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{ $admins_count }} </h3>
                        <h5> عدد المشرفين </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3" onclick="window.location='{{url('dashboard/user')}}'">
                <div class="panel bg-pink-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{ $users_count }} </h3>
                        <h5> عدد المستخدمين </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3" onclick="window.location='{{url('dashboard/provider')}}'">
                <div class="panel bg-pink-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{ $providers_count }} </h3>
                        <h5> عدد الأسر </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3" onclick="window.location='{{url('dashboard/delegate')}}'">
                <div class="panel bg-pink-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{ $delegates_count }} </h3>
                        <h5> عدد المندوبين </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6"  onclick="window.location='{{url('dashboard/order/finished')}}'">
                <div class="panel bg-blue-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{$finished_orders_count}} </h3>
                        <h5> عدد الطلبات المنتهية </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" onclick="window.location='{{url('dashboard/order/current')}}'">
                <div class="panel bg-blue-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{$current_orders_count}} </h3>
                        <h5> عدد الطلبات الجارية </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3" onclick="window.location='{{url('dashboard/delegate?active=active')}}'">
                <div class="panel bg-indigo-800">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{$active_delegates_count}} </h3>
                        <h5> عدد المندوبين المفعلين </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3"  onclick="window.location='{{url('dashboard/delegate?active=deactive')}}'">
                <div class="panel bg-indigo-800">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{$deactive_delegates_count}} </h3>
                        <h5> عدد المندوبين الغير مفعلين </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3" onclick="window.location='{{url('dashboard/provider?active=active')}}'">
                <div class="panel bg-indigo-800">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{$active_providers_count}} </h3>
                        <h5> عدد الأسر المفعلين </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-3"  onclick="window.location='{{url('dashboard/provider?active=deactive')}}'">
                <div class="panel bg-indigo-800">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{$deactive_providers_count}} </h3>
                        <h5> عدد الأسر الغير مفعلين </h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- /quick stats boxes -->
    </div>
</div>
<!-- /dashboard content -->
@endsection
