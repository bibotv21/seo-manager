<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Thêm Guest Post</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            <li>
                <a href="{{ route('guestpost.index') }}">Guest Post Dashboard</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>

@php
    $previous_url = url()->previous();
@endphp
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="post" class="form-horizontal"
                    action="{{ $action == 'add' ? route('gp.add') : route('gp.update') }}">
                    @csrf
                    <div class="form-group"><label class="col-sm-2 control-label">Trang đặt:</label>

                        <div class="col-sm-5"><input type="text"
                                value="{{ old('target_domain', $gp_data->target_domain ?? '') }}"
                                placeholder="example.com" class="form-control" name="target_domain">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Ngày đặt</label>

                        <div class="col-sm-2"><input type="date"
                                value="{{ old('impl_date', $gp_data->impl_date ?? '') }}" placeholder="placeholder"
                                class="form-control" name="impl_date">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-sm-2 control-label">Link bài viết:</label>

                        <div class="col-sm-5"><input type="text"
                                value="{{ old('source_link', $gp_data->source_link ?? '') }}" placeholder="link google drive"
                                class="form-control" name="source_link">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-sm-2 control-label">Link Đặt:</label>

                        <div class="col-sm-5"><input type="text"
                                value="{{ old('post_link', $gp_data->post_link ?? '') }}"
                                placeholder="https://domain.com/bai-viet-gi-do/" class="form-control"
                                name="post_link">
                        </div>
                    </div>

                    <div class="form-group"><label class="col-sm-2 control-label">Giá</label>

                        <div class="col-sm-5">
                            <input class="col-sm-3 form-control" type="text"
                                value="{{ old('amount', $gp_data->amount ?? '') }}" placeholder="500000"
                                class="form-control" name="amount">
                        </div>
                    </div>
                    <div class="form-group cls-select2-wrapper"><label class="col-sm-2 control-label">CTV</label>
                        <div class="col-sm-3">
                            <select class="cls-tl-select2" name="ctv_id">
                                <option value="">Chọn CTV</option>
                                @foreach ($default_data['ctv'] as $item)
                                    <option {{old('ctv_id', $gp_data->ctv_id ?? '') == $item['id'] ? "selected" : ''}}
                                        value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group cls-select2-wrapper"><label class="col-sm-2 control-label">CTV</label>
                        <div class="col-sm-3">
                            <select class="cls-tl-select2" name="domain_id">
                                <option value="">Chọn Website</option>
                                @foreach ($default_data['website'] as $item)
                                    <option {{old('ctv_id', $gp_data->domain_id ?? '') == $item['id'] ? "selected" : ''}}
                                        value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group cls-select2-wrapper"><label class="col-sm-2 control-label">Trạng thái</label>
                        <div class="col-sm-3">
                            <select name="status" class="cls-tl-select2">
                                @foreach (config('my_config.common.guest_post_status') as $item)
                                    <option value="{{ $item['id'] }}" {{old('status', $gp_data->status ?? "") == $item['id'] ? "selected" : ""}}>{{ $item['title'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="previous_url" value="{{ $previous_url }}">
                    @if ($gp_data)
                        <input type="hidden" name="gp_id" value="{{ $gp_data->id }}">
                    @endif
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white" href="{{ $previous_url }}">Cancel</a>
                            <button class="btn btn-primary" type="submit">{{ $gp_data ? 'Upadte' : 'Save'}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.cls-tl-select2').select2();
    });
</script>
