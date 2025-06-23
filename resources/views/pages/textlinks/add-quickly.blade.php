<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Thêm <strong class="c-red">Text Links</strong> bằng file csv</h2>
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
                <form action="{{ route('tl_csv_file.preview') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="csv_file" accept=".csv" style="margin-bottom: 10px;">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-eye"></i>Preview Data</button>
                </form>

                @if (!$first_time)
                    @unless ($preview_data['error_message'])
                        <a class="import-action-btn btn btn-primary "
                            href="{{ route('add_tl_quickly.action', $preview_data['file_name']) }}"><span
                                class="bold">Thêm Text Links</span></a>
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
                            <th>Trang Đặt</th>
                            <th>Anchor Text</th>
                            <th>Ngày Đặt</th>
                            <th>Ngày hết hạn</th>
                            <th>Domain</th>
                            <th>Giá</th>
                            <th>CTV</th>
                        </tr>
                    </thead>
                </table>
                <script>
                    $("#preview-tl-data").DataTable({
                        data: @json($preview_data['data']),
                        order: [4, 'asc'],
                        columnDefs: [{
                            target: 5,
                            type: 'currency',
                            render: (data, type, row) => {
                                return data.toLocaleString('it-IT', {
                                    style: 'currency',
                                    currency: 'VND'
                                })
                            }
                        }],
                        createdRow: (row, data, index) => {
                            $(row.querySelector(':nth-child(6)')).css("text-align", "right")
                        }
                    });
                </script>
            @endif
        </div>
    </div>
    <div class="ibox collapsed">
        <div class="collapse-link custom-ibox">
            <div class="ibox-title">
                <h5>Xem mẫu <strong class="c-red">Text Link</strong> csv file</h5>
            </div>
            <i class="fa fa-chevron-down"></i>
        </div>        
        <div class="ibox-content">
            <div>
                <a href="/csv/text-link-template.csv" id="csv-template-download">Tải file csv mẫu </a>
                <figure style="text-align: center;">
                    <img src="/images/text-link-csv-file-template.png" alt="">
                    <figcaption>File Text Link mẫu</figcaption>
                </figure>
            </div>
        </div>
    </div>
</div>
