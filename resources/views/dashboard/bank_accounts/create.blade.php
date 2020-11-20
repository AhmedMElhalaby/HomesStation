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
        <form action="{{ route('bank_account.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.bank_accounts.add_new_bank_accounts') }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label"> {{ trans('dash.bank_accounts.logo_bank') }}</label>
                        <div class="col-lg-9">
                            <input type="file" class="file-styled" name="logo_bank">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.bank_accounts.bank_name') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="bank_name" placeholder="{{ trans('dash.bank_accounts.bank_name') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.bank_accounts.owner_account') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="owner_account" class="form-control" placeholder="{{ trans('dash.bank_accounts.owner_account') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.bank_accounts.account_number') }}</label>
                        <div class="col-lg-9">
                            <input type="number" name="account_number" class="form-control" placeholder="{{ trans('dash.bank_accounts.account_number') }}" required>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.add_forword_2_menu') }} " />
                        <input type="reset" class="btn btn-warning" value=" {{ trans('dash.reset_data') }} " />
                        <a href="{{ route('bank_account.index') }}"  class="btn btn-success">{{ trans('dash.back_to_menu') }}</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /basic layout -->
    </div>
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"> {{ trans('dash.bank_accounts.latest_bank_accounts') }} </h5>                    
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="text-center">
                        <th> {{ trans('dash.bank_accounts.logo_bank') }} </th>
                        <th class="text-center"> {{ trans('dash.bank_accounts.bank_name') }} </th>
                        <th class="text-center"> {{ trans('dash.bank_accounts.owner_account') }} </th>
                    </tr>
                    @foreach($latest_bank_accounts as $bank_accounts)
                    <tr>
                        <td> <img height="60px" width="100px" src="{{ $bank_accounts->logo_bank400 }}" /> </td>
                        <td> {{ $bank_accounts->bank_name }} </td>
                        <td> {{ $bank_accounts->owner_account }} </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
