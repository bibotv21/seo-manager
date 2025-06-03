<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Kết quả check Text Link</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="active">
                <a href="{{ route('textlinks.index') }}">Text Link Dashboard</a>
            </li>
        </ol>
    </div>
</div>

<table id="textlink-checker" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Website đặt</th>
            <th>Ngày đặt</th>
            <th>Ngày hết hạn</th>
            <th>Anchor Text</th>
            <th>Giá</th>
            <th>CTV</th>
            <th>Trạng thái</th>
            <th>Thẻ rel</th>
            <th>Website</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

<script>
    $('#textlink-checker').DataTable({
        data: @json($checker_data),
        columnDefs: [
            {
                target: 4,
                type: 'currency',
                render: (data, type, row) => {
                    return data.toLocaleString('it-IT', {style: 'currency',currency: 'VND'})
                }
            },
            {
                target: 6,
                render: (data, type, row) => {
                    return convert_status(data, 'tl');
                }
            },
            {
                target: 9,
                render: (data, type, row) => {                    
                    return two_actions(data)
                }

            }
        ]
    });
</script>