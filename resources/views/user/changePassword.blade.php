<div class="ui text container">
    <div class="ui one column grid">
        <div class="column">
            <div class="profile ui card ">
                <div class="content">

                    {{ Form::open(array( 'method' => 'post', 'class' => 'ui form', 'id' => 'reset-password')) }}
                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="envelope icon"></i>
                                    @lang('user.email')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::text('email', '',[
                                        'id' => 'reset-email',
                                        'placeholder' => Lang::get('user.email'),
                                        'readonly' => (! Auth::User()->can('superuser', 'App\User'))
                                    ]) }}
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="lock icon"></i>
                                    @lang('user.password')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::password('password', [
                                        'id' => 'password',
                                        'placeholder' => Lang::get('user.password')
                                    ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="lock icon"></i>
                                    @lang('user.password')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::password('password_confirmation', [
                                        'id' => 'password_confirmation',
                                        'placeholder' => Lang::get('user.password_confirmation')
                                    ]) }}
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}

                    @can('edit', 'App\User')
                        <div class="row button-row">
                            <div class="column middle aligned center aligned">
                                <button class="ui secondary button" id="reset-save">
                                    <i class="save icon icon"></i>
                                    @lang('glob.save')
                                </button>
                            </div>
                        </div>
                    @endcan

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {

        let fill = {
            $form : $('#reset-password'),
            url : "{{ route('users.profile') }}",
            token : "{{ csrf_token() }}",
            data : [],
            mapList : {
                email : $('#reset-email')
            }
        },
        save = {
            $btn : $('#reset-save'),
            $form : $('#reset-password'),
            url : "{{ route('users.resetpassword', ['user' => Auth::User()->id ]) }}",
            token : "{{ csrf_token() }}",
            method : 'PUT',
            errorFields : {
                'User.email' : "@lang('user.email')",
            }
        };
        
        let formFill = new FormFill(fill),
            formSave = new FormSave(save);

        formFill.getData();

    })
</script>