
<!--Start: Nav  -->
<div class="ui fixed borderless huge menu">

    <div class="ui container grid">
        
        <!--Start: Desktop Nav-->
        <div class="computer only row">
            <a class="header item" href="{{ route('home') }}">@lang('glob.slogan')</a>
            <a class="item" href="{{ route('home') }}" >@lang('glob.home')</a>
            @guest
            @else
                <div class="ui dropdown item">
                    @lang('glob.menu')
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        @can('read', 'App\Quesition')
                            <a href="{{ route('quesition.index') }}">
                                <div class="item">
                                    <i class="file alternate icon"></i>
                                    @lang('quesition.manage')
                                </div>
                            </a>
                        @endcan
                    </div>
                </div>
            @endguest
            
            <div class="right menu">
                @guest
                    <div class="item">
                        <a href="{{ route('login') }}" >@lang('glob.login')</a>
                    </div>
                    <div class="item">
                        <a class="mini ui blue button" href="{{ route('register.page') }}" >@lang('glob.signup')</a>
                    </div>
                @else
                    <div class="ui dropdown item">
                        {{ Auth::user()->name }}
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            @can('read', 'App\User')
                                <a href="{{ route('users.index') }}">
                                    <div class="item">
                                        <i class="cogs icon"></i>
                                        @lang('user.manage')
                                    </div>
                                </a>   
                            @endcan
                        </div>
                    </div>
                    <div class="item">
                        <a class="mini ui blue button" href="{{ route('logout') }}" >@lang('glob.logout')</a>
                    </div>
                @endguest


                <div class="ui dropdown item">@lang('glob.langSelect')
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a href="{{ url('local/tw') }}">
                            <div class="item">
                                <i class="tw flag"></i>
                                中文
                            </div>
                        </a> 
                        <a href="{{ url('local/en') }}">
                            <div class="item">
                                <i class="us flag"></i>
                                English
                            </div>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
        <!--End: Desktop Nav-->
        
        <!--Start: Mobile Nav-->
        <div class="tablet mobile only row">
        <a class="header item">@lang('glob.slogan')</a>
        <div class="right menu">
            <a class="menu item">
            <div class="ui basic icon toggle button">
                <i class="content icon"></i>
            </div>
            </a>
        </div>

        <div class="ui vertical accordion borderless fluid menu">
            {{-- <!-- Start: Search -->
            <div class="item">
            <div class="ui icon input">
                <input type="text" placeholder="Search...">
                <i class="search link icon"></i>
            </div>
            </div>
            <!-- End: Search --> --}}
            <a class="active item">@lang('glob.home')</a>
            @guest
            @else
                <div class="item">
                    <div class="title">
                    @lang('glob.menu')
                    <i class="dropdown icon"></i>
                    </div>
                    <div class="content">
                        @can('read', 'App\Quesition')
                            <a href="{{ route('quesition.index') }}">
                                <div class="item">
                                    <i class="file alternate icon"></i>
                                    @lang('quesition.manage')
                                </div>
                            </a>
                        @endcan
                    </div>
                </div>
            @endguest
            <div class="ui divider"></div>

            @guest
                <div class="item">
                    <a href="{{ route('login') }}" >@lang('glob.login')</a>
                </div>
                <div class="item">
                    <a class="mini ui blue button" href="{{ route('register.page') }}" >@lang('glob.signup')</a>
                </div>
            @else
                <div class="item">
                    <div class="title">
                        {{ Auth::user()->name }}
                        <i class="dropdown icon"></i>
                    </div>
                    <div class="content">
                        {{-- <a href="{{ "" }}">
                            <div class="item">
                                <i class="user circle icon"></i>
                                @lang('user.profile')
                            </div>
                        </a>
                        <a href="{{ '' }}">
                            <div class="item">
                                <i class="lock icon"></i>
                                @lang('user.change_password')
                            </div>
                        </a> --}}
                        @can('read', 'App\User')
                            <a href="{{ route('users.index') }}">
                                <div class="item">
                                    <i class="cogs icon"></i>
                                    @lang('user.manage')
                                </div>
                            </a>   
                        @endcan
                    </div>
                </div>
                <div class="item">
                    <a class="mini ui blue button" href="{{ route('logout') }}" >@lang('glob.logout')</a>
                </div>
            @endguest

            <div class="item">
                <div class="title">
                   @lang('glob.langSelect')
                   <i class="dropdown icon"></i>
                </div>
                <div class="content">
                    <a href="{{ url('local/tw') }}">
                        <div class="item">
                            <i class="tw flag"></i>
                            中文
                        </div>
                    </a> 
                    <a href="{{ url('local/en') }}">
                        <div class="item">
                            <i class="us flag"></i>
                            English
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <!--End: Mobile Nav-->
    </div>
</div>
<!--End: Nav  -->

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/navBar.css') }}">
<script>
    $(document).ready(function() {
        $('.ui.dropdown').dropdown();
        $('.ui.accordion').accordion();

        // bind "hide and show vertical menu" event to top right icon button 
        $('.ui.toggle.button').click(function() {
            $('.ui.vertical.menu').toggle("250", "linear")
        });
});
</script>