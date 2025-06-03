<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ config('terms.website.QLW_title') }}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="active">
                <strong>Layouts</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="main-content-wrapper">
    <div class="button-main-wrapper">
        <a class="btn btn-success " href="{{ route('wb_add.layout') }}"><i class="fa fa-plus"></i><span class="bold">Thêm
                Website</span></a>
    </div>
    <table id="all-website" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Website</th>
                <th>Giá</th>
                <th>Ngày mua</th>
                <th>Ngày hết hạn</th>
                <th>Ngày mở index</th>
                <th>Chuyển hướng</th>
                <th>Nhà cung cấp</th>
                <th>SL Back links</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>


<script>
    var jsData = @json($websites_data);
    var columns = [
        { data: "name" },
        { data: "amount" },
        { data: "purchase_date" },
        { data: "expired_date" },
        { data: "index_opening_date" },
        { data: "r301_message" },
        { data: "provider" },
        { data: "number_of_backlinks" },
        { data: "actions" },
    ];
    $('#all-website').DataTable({
        data: jsData,
        order: [3,'asc'],
        columns: columns,
        columnDefs: [
            {
                target: 0,
                render:  (data, type, row) => {
                    return '<a class="website-name" href="' + data[0] + '">' + data[1] + '</a>'
                }
            },
            {
                target: 1,
                render: (data, type, row) => {
                    return data + ' $'
                },
            },
            {
                render: function(data, type, row) {
                    return renderTwoActions(data)
                },
                target: 8,

            }
        ],
        createdRow: function(row, data, dataIndex) {            
            if(data['is_expired_soon'] == true) {
                $(row).addClass('expire-soon');
            }
        },
        drawCallback: function(settings){
            deleteAction('.delete-action', "Nếu xóa Website này thì sẽ xóa tất cả các back links liên quan. Bạn có chắc chắn muốn xóa không?");
        }
    });

</script>
