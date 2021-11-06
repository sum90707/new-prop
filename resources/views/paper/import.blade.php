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
            {{ Form::open(array( 'method' => 'post', 'class' => 'ui form', 'id' => 'selected')) }}
                <div class="select ui card fluid">

                    <div class="content center aligned">
                        <div class="header">
                            @lang('paper.selected')
                        </div>
                    </div>

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

                </div>
            {{ Form::close() }}
        </div>
        
    </div>
</div>


<script> 
    $(function() {

        let route = {
            list : "{{ route('quesition.list') }}"
        }


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
                    DynamicClone.cloneDom($(this).closest('tr'), $('#quesition-selected'))
                })
            }   
        });

    })
     
</script>