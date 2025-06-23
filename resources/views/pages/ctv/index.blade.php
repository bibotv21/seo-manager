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
        <a class="btn btn-success " href="{{ route('ctv.add.lay_out') }}"><i class="fa fa-plus"></i><span class="bold">Thêm
                CTV</span></a>
    </div>
    <table id="all-ctv" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Account ID</th>
                <th>Text Links</th>
                <th>Guest Post</th>
                <th>Liên Hệ</th>                
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<script>
    $('#all-ctv').DataTable({
        data: @json($ctv_data),
        columns: [
            {data: 'account_id_link'},
            {data: 'quantity_text_links'},
            {data: 'quantity_guest_posts'},
            {data: 'social_network'},
            {data: 'note'},
            {data: 'actions'},
        ],
        columnDefs:[
            {
                target: 0,
                render: (data, type, row) => {
                    return '<a  href="' + data[0] + '">' + data[1] + '</a>'
                }
            },
            {
                target: 5,
                render: (data, type, row) => {
                    return renderTwoActions(data)
                }
            }
        ],
        drawCallback: function(setting){
            deleteAction();
        }
    });


</script>