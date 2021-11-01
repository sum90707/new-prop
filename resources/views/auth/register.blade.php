@extends('layouts.main')

@section('title', __('user.register'))

@section('content')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login.css') }}">

        <div class="ui middle aligned grid">
            <div class="column">
                <form class="ui large form {{ $errors->isEmpty() ? : 'error' }}" id="register-form" method="post" action="{{ route('register') }}">
                    @csrf
                    <div class="ui teal image" id="header">
                        {{-- <img class="logo" src="https://cdn.holmesmind.com/dsp/logo_new.png"> --}}
                    </div>

                    {{-- Display error messages and change throught javascript --}}
                    <div class="ui error message">
                        <h1 class="header">@lang('glob.ooops') !</h1>
                        <ul class="list">
                            @if ($errors->has('name'))
                                <li>
                                    {{ $errors->first('name') }} 
                                </li>
                            @endif
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

                        <div class="{{ $errors->has('name') ? 'error' : '' }} field">
                            <div class="ui left icon input">
                                <i class="user circle icon"></i>
                                <input type="text" name="name" placeholder="@lang('user.name')">
                            </div>
                        </div>

                        <div class="{{ $errors->has('email') ? 'error' : '' }} field">
                            <div class="ui left icon input">
                                <i class="envelope icon"></i>
                                <input type="text" name="email" placeholder="@lang('user.email')">
                            </div>
                        </div>

                        <div class="{{ $errors->has('password') ? 'error' : '' }} field">
                            <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="@lang('user.password')">
                            </div>
                        </div>

                        <div class="{{ $errors->has('password') ? 'error' : '' }} field">
                            <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password_confirmation" placeholder="@lang('user.password_confirmation')">
                            </div>
                        </div>

                        <div class="ui text-center">
                            <button class="ui black button icon submit button register-btn">
                                <i class="registered icon"></i>
                                @lang('user.register')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection