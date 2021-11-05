<script defer type="text/javascript" src="{{ URL::asset('js/upload.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/process-form.js') }}"></script>
<style>
    .button-row {
        padding-top: 2rem;
    }
    .user-img i {
        bottom: 15px;
        position: absolute;
    }

</style>
<div class="ui text container">
    <div class="ui one column grid">
        <div class="centered row user-img">
            <div class="mug-shot-group">
                {{-- <img class="ui medium circular image" id="mug-shot" > --}}
                <img class="ui medium circular image" id="mug-shot" 
                    src="https://cdn.holmesmind.com/image/defbg.jpg">
                @can('edit', 'App\User')
                    <i class="edit icon" id="mug-shot-icon"></i>
                    <input type="file" id="img-input" name="attachmentName" style="display: none">
                @endcan
            </div>

        </div>
        <div class="column">
            <div class="profile ui card ">
                <div class="content">

                    {{ Form::open(array( 'method' => 'post', 'class' => 'ui form', 'id' => 'user-profile')) }}

                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="user icon"></i>
                                    @lang('user.name')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::text('User[name]', '',[
                                        'id' => 'user-name'
                                    ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="envelope icon"></i>
                                    @lang('user.email')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column" id="user-email"></div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="address card icon"></i>
                                    @lang('user.auth')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column" id="user-auth"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="language icon"></i>
                                    @lang('user.language')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::select('User[language]', config('languages'), '', [
                                        'id' => 'user-language'
                                    ]) }}
                                </div>
                            </div>
                        </div>

                        @can('create', 'App\User')
                            <div class="row">
                                <div class="ui two column grid ">
                                    <div class="three wide column middle aligned">
                                        <i class="id badge icon"></i>
                                        @lang('user.introduce')
                                    </div>
                                    <div class="one wide column"></div>
                                    <div class="twelve wide column">
                                        {{ Form::textarea('User[introduce]', '', [
                                            'id' => 'user-introduce',
                                            'rows' => 5, 
                                            'cols' => 40,
                                            'maxlength' => '200',
                                            'placeholder' => '200 words or less'
                                        ]) }}
                                    </div>
                                </div>
                            </div>
                        @endcan
                            
                    {{ Form::close() }}
                    @can('edit', 'App\User')
                        <div class="row button-row">
                            <div class="column middle aligned center aligned">
                                <button class="ui secondary button" id="profile-save">
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
            $form : $('#user-profile'),
            url : "{{ route('users.profile') }}",
            token : "{{ csrf_token() }}",
            data : [],
            path : {
                image : '{{ asset("upload/" . Auth::id())  }}'
            },
            mapList : {
                name : $('#user-name'),
                email : $('#user-email'),
                language : $('#user-language'),
                introduce : $('#user-introduce'),
                mug_shot : $('#mug-shot'),
                role_name : $('#user-auth'),
            }
        },
        save = {
            $btn : $('#profile-save'),
            $form : $('#user-profile'),
            url : "{{ route('users.edit',['user' => Auth::user()->id]) }}",
            token : "{{ csrf_token() }}",
            method : 'PUT',
            errorFields : {
                'user.name' : "@lang('User.name')",
                'user.language' : "@lang('User.language')",
            }
        },
        upload = {
            $image : $('#mug-shot'),
            $input : $('#img-input'),
            $uploadBtn : $('#mug-shot-icon'),
            url : "{{ route('users.image',['user' => Auth::user()->id]) }}",
            token : "{{ csrf_token() }}",
            allowExtension : ['image/png', 'image/jpeg', 'text/csv'],
            method : 'POST',
            errorFields : {
                'image' : "@lang('User.mug_shot')"
            }
        };
   
    let formFill = new FormFill(fill),
        formSave = new FormSave(save),
        uploadImage = new UploadImage(upload);

    formFill.getData();

})
    


</script>

