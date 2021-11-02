@extends('layouts.main')

@section('title',  __('user.manage'))

@section('content')

    <div>
        <h2 class="ui icon header aligned">
            <i class="settings icon"></i>
            <div class="content">@lang('user.manage')</div>
        </h2>
    </div>

    <div class="ui top attached tabular menu user">
        <a class="item active" data-tab="profile">@lang('user.profile')</a>
        @can('superuser', 'App\User')
            <a class="item" data-tab="list">
                @lang('user.user_list')
            </a>
        @endcan
        @can('edit', 'App\User')
            <a class="item" data-tab="resetpwd">
                @lang('user.reset_password')
            </a>
        @endcan
    </div>
    
    <div class="ui bottom attached tab segment active" data-tab="profile">
        @include('user.profile')
    </div>
    @can('superuser', 'App\User')
        <div class="ui bottom attached tab segment" data-tab="list">
            @include('user.list')
        </div>
    @endcan
    @can('edit', 'App\User')
        <div class="ui bottom attached tab segment" data-tab="resetpwd">
            @include('user.changePassword')
        </div>
    @endcan
<script>
   $('.tabular.menu.user .item').tab();
</script>
@endsection

