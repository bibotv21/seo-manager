<meta name="csrf-token" content="{{csrf_token()}}">

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ config('terms.website.QLGP_title') }}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

<div class="">
    <div class="pagin-swiper-wrapper"></div>
    <div class="tl-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide main-content-wrapper">
                <div class="button-main-wrapper">
                    <button class="btn btn-success" id="chek-all-gps"><i class="fa fa-eye"></i><span
                        class="bold">Check All Guest Posts</span></button>
                    <a class="btn btn-primary " href="{{route('add.gp-csv.layout')}}"><i
                        class="fa fa-briefcase"></i><span class="bold">Thêm GP File CSV</span></a>
                    <a class="btn btn-warning " href="{{ route('ajax.gp-all.export') }}"><i
                        class="fa fa-upload"></i><span class="bold">Export CSV</span></a>
                    <a class="btn btn-info " href="{{route('gp.input-add.layout')}}"><i
                        class="fa fa-briefcase"></i><span class="bold">Thêm Guest Post</span></a>
                </div>
                <table id="all-gp-dashboard" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Website Đặt</th>
                            <th>Ngày Đặt</th>
                            <th>Link Bài Viết</th>
                            <th>Link đặt</th>
                            <th>Giá</th>
                            <th>Trạng Thái</th>
                            <th>CTV</th>
                            <th>Website</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    var columns = [
        {data: 'target_domain'},
        {data: 'impl_date'},
        {data: 'source_link'},
        {data: 'post_link'},
        {data: 'amount'},
        {data: 'status'},
        {data: 'ctv_name'},
        {data: 'website_name'},
        {data: 'actions'}
    ]

    var gp_dashboard = $('#all-gp-dashboard').DataTable({
            data: @json($gp_data),
            order: [1,'desc'],
            columns: columns,
            columnDefs: [
                {
                    target: 2,
                    render: (data, type, row) => {
                        return copyLongStringBtn(data);
                    }
                },
                {
                    target: 4,
                    type: 'currency',
                    render: (data, type, row) => {
                        return data.toLocaleString('it-IT', {
                            style: 'currency',
                            currency: 'VND'
                        })
                    },
                },
                {
                    target: 5,
                    render: (data, type, row) => {
                        return convert_status(data, 'gp');
                    }
                },
                {
                    targets: 8,
                    render: (data, type, row) => {
                        return two_actions(data)
                    },
                }
            ],
            drawCallback: function(){
                initCopyToCliboard('.copy-url-btn')
            }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#chek-all-gps').on('click', function(){
        $.ajax({
            url: "{{ route('ajax.all-gps.check') }}",
            method: "GET",
            success: function(data){
                gp_dashboard.clear().rows.add(data).draw();
                Swal.fire({
                    title: 'Success!',
                    text: 'Data loaded successfully',
                    icon: 'success'
                });
                console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong',
                    icon: 'error'
                });
                console.log('Erorr: ' + textStatus + " " + errorThrown);
            }
        })
    });
    
    initCopyToCliboard('.copy-url-btn')
</script>

