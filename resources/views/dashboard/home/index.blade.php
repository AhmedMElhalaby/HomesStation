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
            <div class="col-lg-4">
                <div class="panel bg-pink-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{ $admins_count }} </h3>
                        <h5> عدد المشرفين </h5>                        
                    </div>                    
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel bg-pink-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{ $users_count }} </h3>
                        <h5> عدد المستخدمين </h5>                        
                    </div>                    
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel bg-pink-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> {{ $providers_count }} </h3>
                        <h5> عدد الأسر </h5>                        
                    </div>                    
                </div>
            </div>
            <div class="col-lg-6">          
                <div class="panel bg-blue-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> 0 </h3>
                        <h5> عدد الطلبات المنتهية </h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">          
                <div class="panel bg-blue-400">
                    <div class="panel-body">
                        <h3 class="no-margin"> 0 </h3>
                        <h5> عدد الطلبات الجارية </h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- /quick stats boxes -->       
    </div>
</div>
<!-- /dashboard content -->
@endsection