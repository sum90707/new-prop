<script defer type="text/javascript" src="{{ URL::asset('js/upload.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/process-form.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/dynamic.js') }}"></script>
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
                        <div class="content">@lang('quesition.title_create')</div>
                    </h3>
                </div>
                <div class="content">

                    {{ Form::open(array( 'method' => 'post', 'class' => 'ui form', 'id' => 'create-quesition')) }}

                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="calendar alternate outline icon"></i>
                                    @lang('quesition.name')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::text('Quesition[name]', '',[
                                        'id' => 'quesition-name'
                                    ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="calendar alternate icon"></i>
                                    @lang('quesition.year')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::number('Quesition[year]', 90,[
                                        'id' => 'quesition-year'
                                    ]) }}
                                </div>
                            </div>
                        </div>

                    
                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="newspaper icon"></i>
                                    @lang('quesition.type')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::select('Quesition[type]', Lang::get('quesition.types'), '', [
                                        'id' => 'quesition-type'
                                    ]) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="ui two column grid ">
                                <div class="three wide column middle aligned">
                                    <i class="newspaper icon"></i>
                                    @lang('quesition.introduce')
                                </div>
                                <div class="one wide column"></div>
                                <div class="twelve wide column">
                                    {{ Form::textarea('Quesition[introduce]', null, [
                                        'id' => 'quesition-introduce',
                                        'rows' => 5, 
                                        'cols' => 40,
                                        'maxlength' => '200',
                                        'placeholder' => '200 words or less'
                                    ]) }}
                                </div>
                            </div>
                        </div>


                        <div class="row" id="option-part">
                            @include('quesition.TF')
                        </div>

                       
                    {{ Form::close() }}

                    @can('edit', 'App\User')
                        <div class="row button-row">
                            <div class="column middle aligned center aligned">
                                <button class="ui secondary button" id="quesition-save">
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
            $btn : $('#quesition-save'),
            $form : $('#create-quesition'),
            url : "{{ route('quesition.create') }}",
            token : "{{ csrf_token() }}",
            method : 'POST',
            errorFields : {
                'Quesition.name' : "@lang('quesition.name')",
                'Quesition.year' : "@lang('quesition.year')",
                'Quesition.type' : "@lang('quesition.type')",
                'Quesition.introduce' : "@lang('quesition.introduce')"
            },
            callback : function(){
                $('#create-quesition').trigger("reset");
                $('#quesition-type').trigger("change");
            }
        },
        dynamic = {
            $triggerDom : $('#quesition-type'),
            $fillDom : $('#option-part'),
            url : "{{ route('quesition.type') }}",
            token : "{{ csrf_token() }}",
            method : "POST"
        };
        new DynamicHTML(dynamic);
        new FormSave(save);
})
    


</script>