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
        <form action="{{ route('product.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h5 class="panel-title"> {{ trans('dash.add_new_product') }} </h5>                    
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label"> {{ trans('dash.images') }}</label>
                        <div class="col-lg-9">
                            <input type="file" class="file-styled" name="image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.name') }}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="name" placeholder="{{ trans('dash.name') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.price') }}</label>
                        <div class="col-lg-9">
                            <input type="number" name="price" class="form-control" placeholder="{{ trans('dash.price') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.description') }}</label>
                        <div class="col-lg-9">
                            <textarea name="description" class="form-control" placeholder="{{ trans('dash.description') }}" required> </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label display-block"> {{ trans('dash.offer') }} </label>
                        <div class="col-lg-9">
                            <select name="has_offer" class="select-border-color border-warning" >
                                <option value="no"> {{ trans('dash.has_not_offer') }} </option>                                
                                <option value="yes"> {{ trans('dash.has_offer') }} </option>                                
                            </select>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ trans('dash.offer_price') }}</label>
                        <div class="col-lg-9">
                            <input type="number" name="offer_price" class="form-control" placeholder="{{ trans('dash.offer_price') }}" required>
                        </div>
                    </div>
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" name="forward" value=" {{ trans('dash.add_forword_2_menu') }} " />
                        <input type="reset" class="btn btn-warning" value=" {{ trans('dash.reset_data') }} " />
                        <a href="{{ route('product.index') }}"  class="btn btn-success">{{ trans('dash.back_to_menu') }}</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /basic layout -->
    </div>
    <div class="col-md-6">
        <div class="panel panel-flat">
            <div class="panel-heading">
                <h5 class="panel-title"> {{ trans('dash.latest_products') }} </h5>                    
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr class="text-center">
                        <th> {{ trans('dash.image') }} </th>
                        <th> {{ trans('dash.name') }} </th>
                        <th> {{ trans('dash.price') }} </th>
                        <th> {{ trans('dash.offer') }} </th>
                    </tr>
                    @foreach($latest_products as $product)
                    <tr>
                        @if(count($product->Images) > 0)
                            <td> <img height="80px" width="80px" src="{{ $product->Images[0]->image100 }}" /> </td>
                        @else
                            <td> <img height="80px" width="80px" src="{{ asset('storage/app/uploads/default.png') }}" /> </td>
                        @endif
                        <td> {{ $product->name }} </td>
                        <td> {{ $product->price }} </td>
                        <td class="text-center"> 
                            @if($product->has_offer == 'on')
                                <span class="label bg-success-400">{{ trans('dash.has_offer') }}</span>
                            @else
                                <span class="label bg-warning-400">{{ trans('dash.has_not_offer') }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
