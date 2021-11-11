@extends('layouts.main')

@section('title', 'Login')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}">
        <div id="welcome" class="ui basic modal">
            <div class="ui icon header">
                <i class="child icon"></i>
                @lang('glob.welcome')
            </div>
            <div class="content text-center">
                @lang('glob.loginNow')
            </div>
        </div>
        

        <div class="ui middle aligned grid">
            <div class="column">
                <form class="ui large form {{ $errors->isEmpty() ? : 'error' }}" id="login-form" method="post" action="{{ route('login.action') }}">
                    @csrf
                    <div class="ui teal image" id="header">
                        {{-- <img class="logo" src="https://cdn.holmesmind.com/dsp/logo_new.png"> --}}
                    </div>

                    <div class="ui error message">
                        <h1 class="header">ooops!</h1>
                        <ul class="list">
                            @if ($errors->has('email'))
                                <li>
                                    {{ $errors->first('email') }} 
                                </li>
                            @endif
                            @if ($errors->has('password'))
                                <li>
                                    {{ $errors->first('password') }}
                                </li>
                            @endif
                        </ul>
                    </div>	
        
                    <div class="ui stacked segment">
                        <div class="{{ $errors->has('email') ? 'error' : '' }} field">
                            <div class="ui left icon input">
                                <i class="user icon"></i>
                                <input type="text" name="email" placeholder="@lang('user.email')">
                            </div>
                        </div>

                        <div class="{{ $errors->has('password') ? 'error' : '' }} field">
                            <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="@lang('user.password')">
                            </div>
                        </div>

                        <div class=" field">
                            <div class="ui two column grid">
                                <div class="column">
                                    <button class="ui fluid large teal submit button login-btn">
                                        <i class="sign in alternate icon"></i>
                                        @lang('user.login')
                                    </button>
                                </div>
                                <div class="column">
                                    <a class="ui fluid large google plus button" href="{{ route('google.login') }}">
                                        <i class="google icon"></i>
                                        @lang('user.google_login')
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class=" field">
                            <a class="ui fluid large gray button login-btn" href="{{ route('register.page') }}">
                                <i class="registered icon"></i>
                                @lang('user.register')
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
@endsection