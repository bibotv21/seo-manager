<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ config('terms.website.add_textlink') }} </h2>
        <ol class="breadcrumb">
            <li>
                <a href="">Home</a>
            </li>
            <li>
                <a href="{{ route('website.index') }}">Website Dashboard</a>
            </li>
            <li class="active">
                <a href="">Add Website</a>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
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
                    action="{{ $wb_data ? route('website.edit') : route('website.add') }}">
                    @csrf
                    <div class="form-group"><label class="col-sm-2 control-label">Domain:</label>

                        <div class="col-sm-5"><input type="text" value="{{ old('name', $wb_data->name ?? '') }}"
                                placeholder="example.com" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Giá:</label>

                        <div class="col-sm-5"><input type="text" value="{{ old('amount', $wb_data->amount ?? '') }}"
                                placeholder="5.5" class="form-control" name="amount">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Ngày mua:</label>

                        <div class="col-sm-2"><input type="date"
                                value="{{ old('purchase_date', $wb_data->purchase_date ?? '') }}" class="form-control"
                                name="purchase_date">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Ngày hết hạn:</label>

                        <div class="col-sm-2"><input type="date"
                                value="{{ old('expired_date', $wb_data->expired_date ?? '') }}" class="form-control"
                                name="expired_date">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Nhà cung cấp:</label>

                        <div class="col-sm-2"><input type="text"
                                value="{{ old('provider', $wb_data->provider ?? 'namecheap') }}" placeholder="namecheap"
                                class="form-control" name="provider">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Ngày mở index (option):</label>

                        <div class="col-sm-2"><input type="date"
                                value="{{ old('index_opening_date', $wb_data->index_opening_date ?? '') }}"
                                class="form-control" name="index_opening_date">
                        </div>
                    </div>
                    <input type="text" name="wb_id" value="{{ $wb_data->id ?? '' }}" hidden>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white" href="{{ route('website.index') }}">Cancel</a>
                            @if ($wb_data)
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                            @else
                                <button class="btn btn-primary" type="submit">Save</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
