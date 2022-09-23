{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>


<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product-stock') }}"><i class="nav-icon la la-file"></i> Product stocks</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('stock-out') }}"><i class="nav-icon la la-edit"></i> Stock outs</a></li>
@if(backpack_user()->role == 'Admin')
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-users"></i> Users</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}"><i class="nav-icon la la-box"></i> Products</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('configuration') }}"><i class="nav-icon la la-gear"></i> Configurations</a></li>
@endif