
<script defer type="text/javascript" src="{{ URL::asset('js/copied.js') }}"></script>
<script defer type="text/javascript" src="{{ URL::asset('js/toggle.js') }}"></script>
<table class="ui celled striped table center aligned quesition-list" width="100%" >        
    <thead>
        <tr>
            <th class="button">@lang('quesition.status') </th>
            <th>@lang('quesition.id')</th>
            <th>@lang('quesition.info')</th>
            <th>@lang('quesition.introduce')</th>
            <th>@lang('quesition.options')</th>
        </tr>
    </thead>
</table>

<script> 
    $(function() {

        let route = {
            list : "{{ route('quesition.list') }}",
            toggleStatus : "{{ route('quesition.status', ['quesition' => '__QUESITION__']) }}",
        }


        let $dataTable = $('.quesition-list').DataTable({
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
                { "width": "5%", "targets": 0},
                { "width": "5%", "targets": 1},
                { "width": "15%", "targets": 2},
                { "width": "50%", "targets": 3},
                { "width": "25%", "targets": 4},
            ],
            columns: [
                {
                    data: 'deleted_at',
                    render: function (data, type, row) {

                        return `
                            <div class="ui toggle checkbox status-checkbox" 
                                data-status="${data ? 0 : 1}" 
                                data-id=${row.id}
                                data-route="${stringReplace(route.toggleStatus, {'__QUESITION__' : row.id})}">
                                <input type="checkbox" name="public">
                                <label></label>
                            </div>`
                    }
                },
                { 
                    data: 'id'
                },
                { 
                    data: 'name',
                    className: 'left aligned',
                    render: function (data, type, row) {
                        return `
                            @lang('quesition.name') : ${data}<br>
                            @lang('quesition.year') : ${row.year}<br>
                            @lang('quesition.type') : ${row.type.lang}`
                    }
                },
                {
                    data: 'introduce'
                },
                {
                    data: 'options',
                    render: function (data, type, row) {
                        let options = String();
                        $.each(data, function(index, option) {
                            options += `
                                <div class="item">
                                    <div class="content">
                                        <div class="description">
                                            <div class="ui two column grid ">
                                                <div class="five wide column center aligned">
                                                    <div class="ui ${option.order == row.answer ? "green" : ""} label">
                                                        ${option.order}
                                                    </div>
                                                </div>
                                                <div class="five wide column middle aligned">
                                                    ${option.introduce}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `
                        });

                        return `
                            <div class="ui list">
                                ${options}
                            </div>
                        `;
                    }
                },
            ],
            drawCallback: function() {
                Toggle.setCheckboxs($('.status-checkbox'), 'status');
                Toggle.statusToggle($('.status-checkbox'), function() {
                    $dataTable.draw();
                });
            }
        });

        setInterval(() => {
            $dataTable.ajax.reload();
        }, 10000);

    })
     
</script>