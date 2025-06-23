<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Text Link của CTV: {{ $ctv->account_id }}</h2>
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

<div class="main-content-wrapper">
    <div class="button-main-wrapper">
        <a class="btn btn-success " href="{{ route('tl.ctv.check', $ctv->id) }}"><i class="fa fa-eye"></i><span
                class="bold">Check Text Link</span></a>
    </div>
    <table id="tl-ctv-details" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Trang đặt</th>
                <th>Ngày đặt</th>
                <th>Ngày hết hạn</th>
                <th>Text Link</th>
                <th>Giá</th>
                <th>Tình trạng</th>
                <th>rel</th>
                <th>Website</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<script>

$('#tl-ctv-details').DataTable({
    data: @json($tl_ctv),
    columnDefs: [
        {
            type: 'currency',
            render: (data, type, row) => {
                return data.toLocaleString('it-IT', {
                        style: 'currency',
                        currency: 'VND'
                    })
            },
            target: 4
        },
        {
            render: (data, type, row) => {
                return convert_status(data, 'tl')
            },
            target: 5
        },
        {
            render: (data, type, row) => {
                return two_actions(data)
            },
            target: 8                
        }
    ]
})
</script>