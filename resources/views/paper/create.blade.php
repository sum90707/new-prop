
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
        <div class="column">
            <div class="create ui card ">
                <div class="content">
                    <h3 class="ui icon header aligned">
                        <i class="edit outline icon"></i>
                        <div class="content">@lang('paper.title_create')</div>
                    </h3>
                </div>
                <div class="content">

                    {{ Form::open(array( 'method' => 'post', 'class' => 'ui form', 'id' => 'create-paper')) }}

                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="calendar alternate outline icon"></i>
                                    @lang('paper.name')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::text('Paper[name]', '',[
                                        'id' => 'paper-name'
                                    ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="newspaper icon"></i>
                                    @lang('paper.introduce')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::textarea('Paper[introduce]', null, [
                                        'id' => 'paper-introduce',
                                        'rows' => 5, 
                                        'cols' => 40,
                                        'maxlength' => '200',
                                        'placeholder' => '200 words or less'
                                    ]) }}
                                </div>
                            </div>
                        </div>

                       
                    {{ Form::close() }}

                    @can('create', 'App\Paper')
                        <div class="row button-row">
                            <div class="column middle aligned center aligned">
                                <button class="ui secondary button" id="paper-save">
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

    let save = {
            $btn : $('#paper-save'),
            $form : $('#create-paper'),
            url : "{{ route('paper.create') }}",
            token : "{{ csrf_token() }}",
            method : 'POST',
            errorFields : {
                'paper.name' : "@lang('paper.name')",
                'paper.introduce' : "@lang('paper.introduce')"
            },
            callback : function(){
                $('#create-paper').trigger("reset");
            }
        };

        new FormSave(save);
})
    


</script>