<!-- Main sidebar -->
<div class="sidebar sidebar-main sidebar-default">
	<div class="sidebar-content">
		<!-- User menu -->
		<div class="sidebar-user-material">
			<div class="category-content">
				<div class="sidebar-user-material-content">
					<a href="#" class="legitRipple"><img src="{{ auth()->user()->profile_image }}" class="img-circle img-responsive" alt=""></a>
					<h6> {{ auth()->user()->username }} </h6>
					<span class="text-size-small"> {{ auth()->user()->Role['role_' . app()->getLocale()] }} </span>
				</div>											
				<div class="sidebar-user-material-menu">
					<a href="#user-nav" data-toggle="collapse"><span>{{ trans('dash.my_account') }}</span> <i class="caret"></i></a>
				</div>
			</div>
			<div class="navigation-wrapper collapse" id="user-nav">
				<ul class="navigation">
					<li><a href="{{ route('admin.profile') }}"><i class="icon-user-plus"></i> <span> {{ trans('dash.my_profile') }} </span></a></li>
					<li class="divider"></li>
					<li><a href="{{ route('setting.index') }}"><i class="icon-cog5"></i> <span> {{ trans('dash.settings') }} </span></a></li>
					<li><a href="{{ route('dashboard.logout') }}"><i class="icon-switch2"></i> <span> {{ trans('dash.logout') }} </span></a></li>
				</ul>
			</div>
		</div>
		<!-- /user menu -->
		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">
					<!-- Main -->
					<li class="navigation-header"><span>{{ trans('dash.main') }}</span> <i class="icon-menu" title="Main pages"></i></li>
					<li {{ request()->route()->getName() === 'dashboard.home' ? ' class=active' : '' }} ><a href="{{ route('dashboard.home') }}"><i class="icon-home4"></i> <span> {{ trans('dash.home') }} </span></a></li>					
					<li>
						<a href="#"><i class="icon-tree7"></i> <span> {{ trans('dash.permissions.permissions') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'permission.index' ? ' class=active' : '' }}><a href="{{ route('permission.index') }}">{{ trans('dash.permissions.permissions') }}</a></li>
							<li {{ request()->route()->getName() === 'permission.create' ? ' class=active' : '' }}><a href="{{ route('permission.create') }}">{{ trans('dash.permissions.add_new_permission') }}</a></li>
						</ul>
					</li>				
					<li>
						<a href="#"><i class="icon-people"></i> <span> {{ trans('dash.admins') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'admin.index' ? ' class=active' : '' }}><a href="{{ route('admin.index') }}">{{ trans('dash.admins') }}</a></li>
							<li {{ request()->route()->getName() === 'admin.create' ? ' class=active' : '' }}><a href="{{ route('admin.create') }}">{{ trans('dash.add_new_admin') }}</a></li>
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-people"></i> <span> {{ trans('dash.users') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'user.index' ? ' class=active' : '' }}><a href="{{ route('user.index') }}">{{ trans('dash.users') }}</a></li>
							<li {{ request()->route()->getName() === 'user.create' ? ' class=active' : '' }}><a href="{{ route('user.create') }}">{{ trans('dash.add_new_user') }}</a></li>
							{{--  <li class="navigation-divider"></li>
							<li  class="disabled" {{ request()->route()->getName() === 'user.trashed' ? ' class=active' : '' }}><a href="{{ route('user.trashed') }}"> {{ trans('dash.users_trashed') }} <span class="label label-transparent">{{ trans('dash.soon') }}</span>  </a> </li>  --}}
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-truck"></i> <span> {{ trans('dash.delegate') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'delegate.index' ? ' class=active' : '' }}><a href="{{ route('delegate.index') }}">{{ trans('dash.delegates') }}</a></li>
							<li {{ request()->route()->getName() === 'delegate.create' ? ' class=active' : '' }}><a href="{{ route('delegate.create') }}">{{ trans('dash.add_new_delegate') }}</a></li>
							{{--  <li class="navigation-divider"></li>
							<li  class="disabled" {{ request()->route()->getName() === 'delegate.trashed' ? ' class=active' : '' }}><a href="{{ route('delegate.trashed') }}"> {{ trans('dash.delegates_trashed') }} <span class="label label-transparent">{{ trans('dash.soon') }}</span>  </a> </li>  --}}
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-store"></i> <span> {{ trans('dash.providers') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'provider.index' ? ' class=active' : '' }}><a href="{{ route('provider.index') }}">{{ trans('dash.providers') }}</a></li>
							<li {{ request()->route()->getName() === 'provider.create' ? ' class=active' : '' }}><a href="{{ route('provider.create') }}">{{ trans('dash.add_new_provider') }}</a></li>
							{{--  <li class="navigation-divider"></li>
							<li class="disabled" {{ request()->route()->getName() === 'provider.trashed' ? ' class=active' : '' }}><a href="{{ route('provider.trashed') }}"> {{ trans('dash.providers_trashed') }} <span class="label label-transparent">{{ trans('dash.soon') }}</span>  </a></li>  --}}
						</ul>
					</li>				
					<li>
						<a href="#"><i class="icon-tree5"></i> <span> {{ trans('dash.categories') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'category.index' ? ' class=active' : '' }}><a href="{{ route('category.index') }}">{{ trans('dash.categories') }}</a></li>
							<li {{ request()->route()->getName() === 'category.create' ? ' class=active' : '' }}><a href="{{ route('category.create') }}">{{ trans('dash.add_new_category') }}</a></li>							
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-tree5"></i> <span> {{ trans('dash.subcategories') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'subcategory.index' ? ' class=active' : '' }}><a href="{{ route('subcategory.index') }}">{{ trans('dash.subcategories') }}</a></li>
							<li {{ request()->route()->getName() === 'subcategory.create' ? ' class=active' : '' }}><a href="{{ route('subcategory.create') }}">{{ trans('dash.add_new_subcategory') }}</a></li>							
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-tree5"></i> <span> {{ trans('dash.subcategory_tags') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'subcategory_tag.index' ? ' class=active' : '' }}><a href="{{ route('subcategory_tag.index') }}">{{ trans('dash.subcategory_tags') }}</a></li>
							<li {{ request()->route()->getName() === 'subcategory_tag.create' ? ' class=active' : '' }}><a href="{{ route('subcategory_tag.create') }}">{{ trans('dash.add_new_subcategory_tag') }}</a></li>							
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-cup2"></i> <span> {{ trans('dash.ads.ads') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'ads.waiting' ? ' class=active' : '' }}><a href="{{ route('ads.waiting') }}">{{ trans('dash.ads.waiting') }}</a></li>
							<li {{ request()->route()->getName() === 'ads.accepted' ? ' class=active' : '' }}><a href="{{ route('ads.accepted') }}">{{ trans('dash.ads.accepted') }}</a></li>							
							<li {{ request()->route()->getName() === 'ads.unaccepted' ? ' class=active' : '' }}><a href="{{ route('ads.unaccepted') }}">{{ trans('dash.ads.unaccepted') }}</a></li>							
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-cube"></i> <span> {{ trans('dash.orders') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'order.current' ? ' class=active' : '' }}><a href="{{ route('order.current') }}">{{ trans('dash.current_orders') }}</a></li>
							<li {{ request()->route()->getName() === 'order.finished' ? ' class=active' : '' }}><a href="{{ route('order.finished') }}">{{ trans('dash.finished_orders') }}</a></li>							
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-loop"></i> <span> {{ trans('dash.retrieve_orders') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'retrieve_order.requests' ? ' class=active' : '' }}><a href="{{ route('retrieve_order.requests') }}">{{ trans('dash.retrieve_order_requests') }}</a></li>
							<li {{ request()->route()->getName() === 'retrieve_order.retrieved' ? ' class=active' : '' }}><a href="{{ route('retrieve_order.retrieved') }}">{{ trans('dash.retrieve_order_retrieved') }}</a></li>							
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-shield-check"></i> <span> {{ trans('dash.subscription.subscriptions') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'subscription.index' ? ' class=active' : '' }}><a href="{{ route('subscription.index') }}"> {{ trans('dash.subscription.subscriptions') }} </a></li>
							<li {{ request()->route()->getName() === 'subscription.create' ? ' class=active' : '' }}><a href="{{ route('subscription.create') }}"> {{ trans('dash.subscription.add_new_subscription') }} </a></li>
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-earth"></i> <span> {{ trans('dash.countries') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'country.index' ? ' class=active' : '' }}><a href=" {{ route('country.index') }} " > {{ trans('dash.countries') }} </a></li>
							<li {{ request()->route()->getName() === 'country.create' ? ' class=active' : '' }}><a href=" {{ route('country.create') }} " > {{ trans('dash.add_new_country') }} </a></li>
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-city"></i> <span> {{ trans('dash.cities') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'city.index' ? ' class=active' : '' }}><a href=" {{ route('city.index') }} " > {{ trans('dash.cities') }} </a></li>
							<li {{ request()->route()->getName() === 'city.create' ? ' class=active' : '' }}><a href=" {{ route('city.create') }} " > {{ trans('dash.add_new_city') }} </a></li>
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-earth"></i> <span> {{ trans('dash.nationalities') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'nationality.index' ? ' class=active' : '' }}><a href=" {{ route('nationality.index') }} " > {{ trans('dash.nationalities') }} </a></li>
							<li {{ request()->route()->getName() === 'nationality.create' ? ' class=active' : '' }}><a href=" {{ route('nationality.create') }} " > {{ trans('dash.add_new_nationality') }} </a></li>
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-credit-card"></i> <span> {{ trans('dash.bank_accounts.bank_accounts') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'bank_account.index' ? ' class=active' : '' }}><a href=" {{ route('bank_account.index') }} " > {{ trans('dash.bank_accounts.bank_accounts') }} </a></li>
							<li {{ request()->route()->getName() === 'bank_account.create' ? ' class=active' : '' }}><a href=" {{ route('bank_account.create') }} " > {{ trans('dash.bank_accounts.add_new_bank_account') }} </a></li>
						</ul>
					</li>
					<li>
						<a href="#"><i class="icon-cash3"></i> <span> {{ trans('dash.bank_transfers.bank_transfers') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'bank_transfer.ads' ? ' class=active' : '' }}><a href=" {{ route('bank_transfer.ads') }} " > {{ trans('dash.bank_transfers.bank_transfers_for_ads') }} </a></li>
							<li {{ request()->route()->getName() === 'bank_transfer.providers_subscriptions' ? ' class=active' : '' }}><a href=" {{ route('bank_transfer.providers_subscriptions') }} " > {{ trans('dash.bank_transfers.providers_subscriptions') }} </a></li>
							<li {{ request()->route()->getName() === 'bank_transfer.delegate' ? ' class=active' : '' }}><a href=" {{ route('bank_transfer.delegate') }} " > {{ trans('dash.bank_transfers.bank_transfers_for_delegate') }} </a></li>
						</ul>
					</li>
					<li {{ request()->route()->getName() === 'transaction.index' ? ' class=active' : '' }}>
						<a href="{{ route('transaction.index') }}"><i class="icon-envelop3"></i <span> {{ trans('dash.transaction.transactions') }} </span></a>
					</li>
					<!-- /main -->
					<!-- others -->
					<li class="navigation-header"><span> {{ trans('dash.others') }} </span> <i class="icon-menu" title=" {{ trans('dash.others') }} "></i></li>					
					<li>
						<a href="#"><i class="icon-chart"></i> <span> {{ trans('dash.statistics.statistics') }} </span></a>
						<ul>
							<li {{ request()->route()->getName() === 'statistics.real_weekly' ? ' class=active' : '' }}><a href="{{ route('statistics.real_weekly') }}"> {{ trans('dash.statistics.real_weakly_report') }} </a></li>
							<li {{ request()->route()->getName() === 'statistics.real_yearly' ? ' class=active' : '' }}><a href="{{ route('statistics.real_yearly') }}"> {{ trans('dash.statistics.real_yearly_report') }} </a></li>
						</ul>
					</li>
					<li {{ request()->route()->getName() === 'contact.index' ? ' class=active' : '' }}>
						<a href="{{ route('contact.index') }}"><i class="icon-envelop3"></i <span> {{ trans('dash.contacts.contact_us') }} </span></a>
					</li>
					<li {{ request()->route()->getName() === 'user_reports.index' ? ' class=active' : '' }}>
						<a href="{{ route('user_reports.index') }}"> <i class="icon-alert"></i> <span> {{ trans('dash.user_reports.user_reports') }} </span> </a>
					</li>																
					<li {{ request()->route()->getName() === 'setting.index' ? ' class=active' : '' }}>
						<a href="{{ route('setting.index') }}"><i class="icon-cog2"></i> <span> {{ trans('dash.settings') }} </span> </a>
					</li>
					<!-- /others -->
				</ul>
			</div>
		</div>
		<!-- /main navigation -->
	</div>
</div>
<!-- /main sidebar -->