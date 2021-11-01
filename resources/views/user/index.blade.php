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
        <a class="item " data-tab="profile">@lang('user.profile')</a>
        @can('superuser', 'App\User')
            <a class="item active" data-tab="list">@lang('user.user_list')</a>
        @endcan
        <a class="item" data-tab="third">Third</a>
    </div>
    <div class="ui bottom attached tab segment " data-tab="profile">
        @include('user.profile')
    </div>

    @can('superuser', 'App\User')
        <div class="ui bottom attached tab segment active" data-tab="list">
            @include('user.list')
        </div>
    @endcan
    
    <div class="ui bottom attached tab segment " data-tab="third">
        Third
    </div>
<script>
   $('.tabular.menu.user .item').tab();
</script>
@endsection

