<meta name="csrf-token" content="{{csrf_token()}}">

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ config('terms.website.QLTL_title') }}</h2>
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
                    <button class="btn btn-success" id="check-all-tls"><i class="fa fa-eye"></i><span
                        class="bold">Check All Text Links</span></button>
                    <a class="btn btn-primary " href="{{ route('add.textlink.quickly') }}"><i
                        class="fa fa-briefcase"></i><span class="bold">Thêm File CSV</span></a>
                    <a class="btn btn-warning " href="{{ route('ajax.tl-all.export') }}"><i
                        class="fa fa-upload"></i><span class="bold">Export CSV</span></a>
                    <a class="btn btn-info " href="{{ route('add.tl.layout') }}"><i
                        class="fa fa-briefcase"></i><span class="bold">Thêm Text Link</span></a>
                </div>
                <table id="all-tl-dashboard" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Website đặt</th>
                            <th>Ngày đặt</th>
                            <th>Ngày hết hạn</th>
                            <th>Anchor Text</th>
                            <th>Giá</th>
                            <th>CTV</th>
                            <th>Trạng thái</th>
                            <th>Thẻ Rel</th>
                            <th>Website</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="swiper-slide main-content-wrapper">
                <div class="button-main-wrapper">
                    <a class="btn btn-warning" id="delete-selected-tl">
                        Delete Selected
                    </a>
                    <button class="btn btn-warning" id="renewal-text-links">
                        Gia Hạn: 
                    </button>
                    <input type="date" name="renewal-tl-date" required>
                </div>
                <table id="expired-text-links-table" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="select_all" value="1" id="select-all-id"></th>
                            <th>Website đặt</th>
                            <th>Ngày đặt</th>
                            <th>Ngày hết hạn</th>
                            <th>Anchor Text</th>
                            <th>Giá</th>
                            <th>CTV</th>
                            <th>Trạng thái</th>
                            <th>Thẻ Rel</th>
                            <th>Website</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="swiper-slide main-content-wrapper">
                <div class="button-main-wrapper">
                    <button class="btn btn-warning">
                        <span>
                            Trashed
                        </span>
                    </button>
                </div>
                <table id="trashed-text-links" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Website đặt</th>
                            <th>Ngày đặt</th>
                            <th>Ngày hết hạn</th>
                            <th>Anchor Text</th>
                            <th>Giá</th>
                            <th>CTV</th>
                            <th>Trạng thái</th>
                            <th>Thẻ Rel</th>
                            <th>Website</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    var btn_pag_arr = [
        'All Text Links',    
        'Text Link Hết Hạn',
        'Text Link Từng Đặt'
    ];

    var columns = [
        {data: 'target_domain'},
        {data: 'impl_date'},
        {data: 'expired_date'},
        {data: 'anchor_text'},
        {data: 'amount'},
        {data: 'ctv_name'},
        {data: 'status'},
        {data: 'rel_tag'},
        {data: 'website_name'},
        {data: 'actions'}
    ]

    const swiper = new Swiper('.tl-swiper', {
        pagination: {
            el: '.pagin-swiper-wrapper',
            bulletClass: 'btn-pag',
            bulletActiveClass: 'active',
            clickable: true,
            renderBullet: (i, c) => {
                return '<span class="' + c + '">' + btn_pag_arr[i] + '</span>'
            }
        },
        simulateTouch: false
    });

    var tl_dashboard = $('#all-tl-dashboard').DataTable({
            data: @json($tl_data),
            order: [2,'asc'],
            columns: columns,
            pageLength: 50,
            columnDefs: [
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
                    target: 6,
                    render: (data, type, row) => {
                        return convert_status(data, 'tl');
                    }
                },
                {
                    targets: 9,
                    render: (data, type, row) => {
                        return two_actions(data)
                    },
                }
            ],
            createdRow: (row, data, dataIndex) => {
                if(data['is_expired_soon']){
                    $(row).addClass('expire-soon');
                }
            }
    });


    $('#trashed-text-links').DataTable({
            data: @json($tl_trashed),
            columns: columns.filter(column => column.data !== 'actions'),
            columnDefs: [{
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
                    target: 6,
                    render: (data, type, row) => {
                        return convert_status(data, 'tl');
                    }
                }            
            ]
    });
    var expired_data = @json($tl_expired);
</script>
<script src="{{ asset('assets/js/customize/expired-textlink.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#check-all-tls').on('click', function(event){
        event.preventDefault();
        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            showConfirmButton: false
        });
        $.ajax({
            url: "{{route('ajax.tl-all.check')}}",
            type: "GET",
            success: function (data) {
                tl_dashboard.clear().rows.add(data).draw();
                Swal.fire({
                    title: 'Success!',
                    text: 'Data loaded successfully',
                    icon: 'success'
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong',
                    icon: 'error'
                });
                console.log('Erorr: ' + textStatus + " " + errorThrown);
            }
        });
    });
    
    
</script>

