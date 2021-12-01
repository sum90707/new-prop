

<table class="ui celled striped table center aligned paper-list" width="100%" >        
    <thead>
        <tr>
            <th class="button">@lang('paper.status') </th>
            <th>@lang('paper.id')</th>
            <th>@lang('paper.name')</th>
            <th>@lang('paper.introduce')</th>
            <th>@lang('paper.create_by')</th>
            <th>@lang('paper.operate')</th>
        </tr>
    </thead>
</table>

<script> 
    $(function() {

        let route = {
            list : "{{ route('paper.list') }}",
            toggleStatus : "{{ route('paper.status', ['paper' => '__PAPER__']) }}",
            download : "{{ route('paper.dwonload', ['paper' => '__DATA__']) }}",
        }


        let $dataTable = $('.paper-list').DataTable({
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
                { "width": "45%", "targets": 3},
                { "width": "20%", "targets": 4},
                { "width": "10%", "targets": 5},
            ],
            columns: [
                {
                    data: 'deleted_at',
                    render: function (data, type, row) {

                        return `
                            <div class="ui toggle checkbox status-checkbox" 
                                data-status="${data ? 0 : 1}" 
                                data-id=${row.id}
                                data-route="${stringReplace(route.toggleStatus, {'__PAPER__' : row.id})}">
                                <input type="checkbox" name="public">
                                <label></label>
                            </div>`
                    }
                },
                { 
                    data: 'id'
                },
                { 
                    data: 'name'
                },
                {
                    data: 'introduce'
                },
                {
                    data: 'create_by',
                    render: function (data, type, row) {
                        return data.name;
                    }
                },
                {
                    data: 'id',
                    render: function (data, type, row) {
                        return `
                            <div class="ui floating dropdown button operate">
                                    @lang('paper.operate')
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <a class="item" target="_blank"
                                        href="${stringReplace(route.download, {'__DATA__' : data})}">
                                        Download
                                    </a>
                                </div>
                            </div>
                        `
                    }
                    

                },
            ],
            drawCallback: function() {
                Toggle.setCheckboxs($('.status-checkbox'), 'status');
                Toggle.statusToggle($('.status-checkbox'), function() {
                    $dataTable.draw();
                });
                $('.dropdown.button.operate').dropdown({on: 'hover'});
            }
        });

        setInterval(() => {
            $dataTable.ajax.reload();
        }, 30000);

    })
     
</script>