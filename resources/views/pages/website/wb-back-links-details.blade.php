<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{$website->name}}</h2>
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
            <div class="swiper-slide">
                <div class="button-main-wrapper">
                    <button class="btn btn-success " id="website-check-tl"><i class="fa fa-eye"></i><span class="bold">
                            Check Text Links</span></button>
                </div>
                <div class="main-content-wrapper">
                    <table id="website-text-links" class="display" style="width:100%">
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
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="swiper-slide main-content-wrapper">
                <table id="website-guest-posts" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Website Đặt</th>
                            <th>Ngày Đặt</th>
                            <th>Link Bài Viết</th>
                            <th>Link đặt</th>
                            <th>Giá</th>
                            <th>Trạng Thái</th>
                            <th>CTV</th>
                            <th>Action</th>
                        </tr>
                    </thead>
            </div>
        </div>
    </div>
    <input name="website-id" type="text" value="{{ $website->id }}" hidden>
</div>


<script>
    var website_tl_datatable = $('#website-text-links').DataTable({
        data: @json($tl_data),
        columns: [
            { data: 'target_domain' },
            { data: 'impl_date' },
            { data: 'expired_date' },
            { data: 'anchor_text' },
            { data: 'amount' },
            { data: 'ctv_name' },
            { data: 'status' },
            { data: 'rel_tag' },
            { data: 'actions'}
        ],
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

    $('#website-guest-posts').DataTable({
        data: @json($gp_data),
        columns: [
            { data: 'target_domain' },
            { data: 'impl_date' },
            { data: 'source_link' },
            { data: 'post_link' },
            { data: 'amount' },
            { data: 'status' },
            { data: 'ctv_name' },
            { data: 'actions' }
        ],
        columnDefs: [
            {
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
        ]
    })

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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#website-check-tl').on('click', function() {
        Swal.fire({
            title: 'Loading...',
            allowOutsideClick: false,
            showConfirmButton: false
        });
        $.ajax({
            url: "{{ route('ajax.wb.check_tl') }}",
            type: 'post',
            data: {
                id: $('input[name="website-id"]').val()
            },
            dataType: 'json',
            success: function(data) {
                website_tl_datatable.clear().rows.add(data).draw();
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
