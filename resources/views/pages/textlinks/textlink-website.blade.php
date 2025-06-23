<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ config('terms.website.TLW_title') }} {{ $tl_website_data['website']->name }}</h2>
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

<div class="button-wrapper">
    <a class="btn btn-success " href="{{ route('add.tl.layout', $tl_website_data['website']->id) }}"><i
            class="fa fa-plus"></i><span class="bold">Thêm</span></a>
</div>

<div class="main-content-wrapper">
    <table id="textlink-website" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Trang đặt</th>
                <th>Ngày đặt</th>
                <th>Ngày hết hạn</th>
                <th>Text Link</th>
                <th>Giá</th>
                <th>CTV</th>
                <th>Tình trạng</th>
                <th>Thẻ rel</th>            
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>


<script>
    $('#textlink-website').DataTable({
        data: @json($tl_website_data['data_table']),
        columnDefs: [
            {
                target: 4,
                type: 'currency',
                render: function(data, type, row) {
                    return data.toLocaleString('it-IT', {
                        style: 'currency',
                        currency: 'VND'
                    })
                }
            },
            {
                render: (data, type, row) => {
                    return convert_status(data, 'tl')
                },
                target: 6
            },
            {
                render: function(data, type, row) {
                    return two_actions(data)
                },
                target: 8
            }
        ],
        createdRow: function(row, data, index) {
            $(row.querySelector(':nth-child(5)')).css("text-align", "right")
        }
    });
</script>
