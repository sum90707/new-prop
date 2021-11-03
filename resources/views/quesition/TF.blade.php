<div class="ui two column grid ">
    <div class="three wide column middle aligned">
        <i class="newspaper icon"></i>
        @lang('quesition.options')
    </div>
    <div class="one wide column"></div>
    <div class="twelve wide column">
        <div class="row">
            <div class="twelve wide column left aligned">
                {{ Form::text('TF[0]', 'X', [
                    'id' => 'option-value-one',
                    'readOnly' => true
                ])}}
            </div>
        </div><br>
        <div class="row">
            <div class="twelve wide column left aligned">
                {{ Form::text('TF[1]', 'O', [
                    'id' => 'option-value-two',
                    'readOnly' => true
                ])}}
            </div>
        </div><br>

        <div class="row">
            <div class="ui two column grid">
                <div class="four wide column middle aligned">
                    @lang('quesition.answer')
                </div>
                <div class="twelve wide column left aligned">
                    {{ Form::select('Quesition[answer]', array('X', 'O'), '', [
                        'id' => 'quesition-answer'
                    ])}}
                </div>
            </div>
        </div>
    </div>
</div>