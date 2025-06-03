<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{$ctv->account_id}}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
        </ol>
    </div>
</div>

<div class="">
    <div class="pagin-swiper-wrapper"></div>
    <div class="backlinks-website-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide main-content-wrapper">
                <div class="button-main-wrapper">
                    <button class="btn btn-success " id="ctv-check-tl"><i class="fa fa-eye"></i><span class="bold">
                            Check Text Links</span></button>
                    <a class="btn btn-warning " href="{{ route('ajax.ctv-tl.export', $ctv->id) }}"><i
                        class="fa fa-briefcase"></i><span class="bold">Export CSV</span></a>
                </div>
                <table id="ctv-text-links" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Website đặt</th>
                            <th>Ngày đặt</th>
                            <th>Ngày hết hạn</th>
                            <th>Anchor Text</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Thẻ rel</th>
                            <th>Website</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="swiper-slide main-content-wrapper">
                <div class="button-main-wrapper">
                    <button class="btn btn-success " id="ctv-check-gps"><i class="fa fa-eye"></i><span class="bold">
                            Check Guest Post</span></button>
                    <a class="btn btn-warning " href="{{ route('ajax.ctv-gp.export', $ctv->id) }}"><i
                        class="fa fa-briefcase"></i><span class="bold">Export CSV</span></a>
                </div>               
                {{-- <div class="infor-detail">
                    <p>* Tổng số lượng GuestPost: <strong><span id="number-of-alls"></span></strong></p>
                    <p>* Đã Index: <strong><span class="c-green" id="number-of-status-yes"></span></strong></p>
                    <p>* Không Index: <strong><span class="c-red" id="number-of-status-no"><span
                                    id="status-no-percent"></span></span></strong> </p>
                </div> --}}
                <table id="ctv-guest-post" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Website đặt</th>
                            <th>Ngày đặt</th>
                            <th>Link Bài Viết</th>
                            <th>Link Đặt</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Website</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <input name="ctv-id" type="text" value="{{ $ctv->id }}" hidden>
</div>

<script>

    var btn_pag_arr = [
        'Text Links',
        'Guest Posts'
    ];

    const swiper = new Swiper('.backlinks-website-swiper', {
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

    var ctv_tl_datatable = $('#ctv-text-links').DataTable({
        data: @json($ctv_tl),
        columns: [
            { data: 'target_domain' },
            { data: 'impl_date' },
            { data: 'expired_date' },
            { data: 'anchor_text' },
            { data: 'amount' },
            { data: 'status' },
            { data: 'rel_tag' },
            { data: 'website_name' },
            { data: 'actions' }
        ],
        order: [2,'asc'],
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
                target: 5,
                render: (data, type, row) => {
                    return convert_status(data, 'tl')
                }
            },
            {
                target: 8,
                render: (data, type, row) => {
                    return two_actions(data)
                }
            }
        ]
    });

    var ctv_gp_datatable = $('#ctv-guest-post').DataTable({
        data: @json($ctv_gp['data']),
        columns: [
            { data: 'target_domain' },
            { data: 'impl_date' },
            { data: 'source_link' },
            { data: 'post_link' },
            { data: 'amount' },
            { data: 'status' },
            { data: 'website_name' },
            { data: 'actions' }
        ],
        columnDefs: [{
                target: 2,
                render: (data, type, row) => {
                    return copyLongStringBtn(data);
                }
            },
            {
                target: 4,
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
                    return convert_status(data, 'gp')
                }
            },
            {
                target: 7,
                render: (data, type, row) => {
                    return two_actions(data)
                }
            }
        ],
        drawCallback: function(settings) {
            initCopyToCliboard('.copy-url-btn')
        }
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#ctv-check-tl').on('click', function() {
        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            showConfirmButton: false
        });
        $.ajax({
            url: "{{ route('ajax.ctv-tl.check') }}",
            type: 'post',
            data: {
                id: $('input[name="ctv-id"]').val()
            },
            dataType: 'json',
            success: function(data) {
                ctv_tl_datatable.clear().rows.add(data).draw();
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

    $('#ctv-check-gps').on('click', function() {
        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            showConfirmButton: false
        });

        $.ajax({
            url: "{{ route('ajax.ctv-gp.check') }}",
            type: 'post',
            data: {
                id: $('input[name="ctv-id"]').val()
            },
            dataType: 'json',
            success: function(data) {
                ctv_gp_datatable.clear().rows.add(data).draw();
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
