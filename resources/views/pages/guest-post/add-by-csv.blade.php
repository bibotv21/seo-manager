<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Thêm <strong class="c-blue">Guest Posts</strong> bằng file csv</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li class="active">
                <a href="{{ route('guestpost.index') }}">GP Dashboard</a>
            </li>
        </ol>
    </div>
</div>

<div class="import-data-wrapper">
    <div class="preview-data-wrapper panel panel-success">
        <div class="panel-heading">
            <h3>Kiểm tra dữ liệu trước khi import</h3>
        </div>
        <div class="panel-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="preview-data-action">
                <form action="{{ route('gp_csv_file.preview') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="csv_file" accept=".csv">
                    <button type="submit" class="btn btn-danger"><i
                        class="fa fa-eye"></i>Preview Data</button>
                </form>
                @if (!$first_time)
                    @unless ($preview_data['error_message'])
                        <a class="import-action-btn btn btn-primary"
                            href="{{ route('add_gp_csv.action', $preview_data['file_name']) }}"><span class="bold">Thêm Nhanh Guest Post</span></a>
                    @endunless

                @endif
            </div>

            @if (!$first_time)
                @if ($preview_data['error_message'])
                    <span style="color:red; font-size: 20px">{{$preview_data['error_message']}}</span>
                @endif
            @endif

            @if (!empty($preview_data['data']))
                <table id="preview-tl-data" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Trang đặt</th>
                            <th>Ngày Đặt</th>
                            <th>Link Bài Viết</th>
                            <th>Link Đặt</th>
                            <th>Giá</th>
                            <th>Domain</th>
                            <th>CTV</th>
                        </tr>
                    </thead>
                </table>
                <script>
                    $("#preview-tl-data").DataTable({
                        data: @json($preview_data['data']),
                        order: [5, 'asc'],
                        columns: [
                            { data: 'target_domain' },
                            { data: 'impl_date' },
                            { data: 'source_link' },
                            { data: 'post_link' },
                            { data: 'amount' },
                            { data: 'website_name' },
                            { data: 'ctv_name' }
                        ],
                        columnDefs: [{
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
                                }
                            }
                        ],
                        createdRow: (row, data, index) => {
                            $(row.querySelector(':nth-child(5)')).css("text-align", "right")
                        },
                        drawCallback: (settings) => {
                            initCopyToCliboard('.copy-url-btn');
                        }
                    });
                </script>
            @endif
        </div>
    </div>
    <div class="ibox collapsed">
        <div class="collapse-link custom-ibox">
            <div class="ibox-title">
                <h5>Xem mẫu <strong class="c-blue">Guest Post</strong> csv file</h5>
            </div>
            <i class="fa fa-chevron-down"></i></a>
        </div>
        <div class="ibox-content">
            <div>
                <a href="/csv/guest-posts-template.csv" id="csv-template-download">Tải file csv mẫu </a>
                <figure style="text-align: center;">
                    <img src="/images/guest-post-csv-file-template.png" alt="">
                    <figcaption>File Guest post mẫu</figcaption>
                </figure>
            </div>
        </div>
    </div>
</div>
