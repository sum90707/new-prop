
<style>
    .button-row {
        padding-top: 2rem;
    }
    .user-img i {
        bottom: 15px;
        position: absolute;
    }

</style>
<div class="ui container fluid">
    <div class="ui two column grid">
        
        <div class="eight wide column">
            <div class="quesition-list ui card fluid center aligned">
                <div class="content center aligned">
                    <div class="header">
                        @lang('glob.quesition_list')
                    </div>
                </div>

                <div class="content">
                    <table class="ui celled striped table center aligned" id="quesition-list" width="100%" >        
                        <thead>
                            <tr>
                                <th>@lang('quesition.info')</th>
                                <th>@lang('quesition.introduce')</th>
                                <th>@lang('paper.import')</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>



        <div class="eight wide column">
           
                <div class="select ui card fluid">

                    <div class="content center aligned">
                        <div class="header">
                            @lang('paper.selected')
                        </div>
                    </div> 

                    <div class="content">
                        <div class="ui two column grid">
                            <div class="five wide column middle aligned center aligned">
                                @lang('paper.paper_select')
                            </div>
                            <div class="ten wide column">
                                <select class="ui fluid search dropdown papers-select" id="papers-select">
                                   
                                </select>
                            </div>
                        </div>
                    </div>
                    {{ Form::open(array( 'method' => 'post', 'class' => 'ui form', 'id' => 'selected')) }}
                        <div class="content">
                            <table class="ui celled striped table center aligned" id="quesition-selected" width="100%" >        
                                <thead>
                                    <tr>
                                        <th class="four wide">@lang('quesition.info')</th>
                                        <th class="ten wide">@lang('quesition.introduce')</th>
                                        <th class="two wide">@lang('glob.delete')</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    {{ Form::close() }}
                </div>
            

            @can('edit', 'App\Paper')
                <div class="row button-row">
                    <div>
                        <button class="ui green button right floated" id="quesition-selected-save">
                            <i class="save icon icon"></i>
                            @lang('glob.save')
                        </button>
                    </div>
                </div>
            @endcan
        </div>
        
    </div>
</div>


<script> 
    $(function() {

        let route = {
            list : "{{ route('quesition.list') }}",
            quesition : "{{ route('quesition.get', ['quesition' => '__DATA__' ]) }}",
            dropdown : "{{ route('paper.dropdwon') }}",
            selectSave : "{{ route('paper.selected', ['paper' => '__DATA__']) }}",
            getSelected : "{{ route('paper.getSelected', ['paper' => '__DATA__']) }}"
        },
        template =  `
            <tr><td class=" left aligned">
                @lang('quesition.name') : __ID__<br>
                @lang('quesition.name') : __NAME__<br>
                @lang('quesition.year') : __YEAR__<br>
                @lang('quesition.type') : __TYPE__</td>
                <td class="sorting_1">
                    __INTRODUCE__
                </td>
                <td>
                    <div class="mini ui red button remove-btn">
                        <i class="remove icon"></i>
                    </div>
                </td>
                <input type="hidden" name="Quesition[id][__ID__]" value="__ID__">
            </tr>
        `,
        config = {
            url : route.quesition,
            token : "{{ csrf_token() }}",
            data : 'id',
            template : template,
            callback : function(json, config) {
                $.each(json.data, function(index, quesition) {
                    $('#quesition-selected').append(
                        stringReplace(config.template, {
                            '__ID__' : quesition.id,
                            '__NAME__' : quesition.name,
                            '__YEAR__' : quesition.year,
                            '__TYPE__' : quesition.type.lang,
                            '__INTRODUCE__' : quesition.introduce
                        })
                    );
                });

                $('.remove-btn').unbind('click').bind('click', function() {
                    $(this).closest('tr').remove();
                });
            }
        },
        get = {
            url : route.getSelected,
            token : "{{ csrf_token() }}",
            method : 'GET',
            template : template,
            before : function() {
                let value = $('.papers-select').find('.selected').data('value')
                if(value) {
                    this.url = stringReplace(route.getSelected, {
                        '__DATA__' : value
                    });
                }
                
            },
            callback : function(json, config) {
                $('#quesition-selected').html('');
                $.each(json.data, function(index, quesition) {
                    $('#quesition-selected').append(
                        stringReplace(config.template, {
                            '__ID__' : quesition.id,
                            '__NAME__' : quesition.name,
                            '__YEAR__' : quesition.year,
                            '__TYPE__' : quesition.type,
                            '__INTRODUCE__' : quesition.introduce
                        })
                    );
                });

                $('.remove-btn').unbind('click').bind('click', function() {
                    $(this).closest('tr').remove();
                });
            }
        }
        dropdwonConfig = {
            url : route.dropdown,
            token : "{{ csrf_token() }}",
            callback : function(json, config) {
                $('.papers-select').dropdown('setup menu', json);
                $('.papers-select').dropdown('set selected', json.values[0].value);
                triggerAJAX(get);
                $('.papers-select').dropdown({
                    onChange: function(value, text, $selectedItem) {
                        get.url = stringReplace(route.getSelected, {
                            '__DATA__' : value
                        });
                        triggerAJAX(get);
                    }
                });
                
            }
        },
        save = {
            $btn : $('#quesition-selected-save'),
            $form : $('#selected'),
            url : route.selectSave,
            token : "{{ csrf_token() }}",
            method : 'POST',
            errorFields : {
                'quesition.paper_id' : "@lang('paper.paper_select')",
                'quesition.id' : "@lang('quesition.introduce')"
            },
            before : function() {
                this.url = stringReplace(this.url,{
                    '__DATA__' : $('.papers-select').find('.selected').data('value')
                });
            },
            callback : function(){
                $('#quesition-selected').html('');
                $('#selected').trigger("reset");
                triggerAJAX(get);
            }
        };

        let $dataTable = $('#quesition-list').DataTable({
            autoWidth: false,
            info: true,
            lengthChange: false,
            serverSide: true,
            pageLength: 20,
            ajax: {
                'url': route.list,
                'type': 'GET',
            },
            order: [[ 1, 'asc' ]],
            columnDefs: [
                { "width": "25%", "targets": 0},
                { "width": "70%", "targets": 1},
                { "width": "5%", "targets": 2}
            ],
            columns: [
                { 
                    data: 'id',
                    className: 'left aligned',
                    render: function (data, type, row) {
                        return `
                            @lang('quesition.name') : ${data}<br>
                            @lang('quesition.name') : ${row.name}<br>
                            @lang('quesition.year') : ${row.year}<br>
                            @lang('quesition.type') : ${row.type.lang}`
                    }
                },
                {
                    data: 'introduce'
                },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            <div class="mini ui blue button import-btn" data-id="${data}">
                                <i class="angle double right icon"></i>
                            </div>
                        `
                    }
                },
            ],
            drawCallback: function() {
                $('#quesition-list thead th').removeClass('left');
                $('.import-btn').on('click', function() {
                    triggerAJAX(config, $(this));
                })
            }   
        });
        
        new FormSave(save);

        triggerAJAX(dropdwonConfig);
        

    });
</script>