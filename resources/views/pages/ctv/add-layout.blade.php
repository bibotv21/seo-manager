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
                <a href="">Add CTV</a>
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
                    action="{{ $action == 'edit' ? route('ctv.update.action') : route('ctv.add.action')}}">
                    @csrf
                    <div class="form-group"><label class="col-sm-2 control-label">Id CTV:</label>

                        <div class="col-sm-5"><input type="text" value="{{ old('account_id', $ctv->account_id ?? '')}}"
                                placeholder="example.com" class="form-control" name="account_id">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Nền tảng:</label>
                        <div class="col-sm-5"><input type="text" value="{{old('social_network', $ctv->social_network ?? 'telegram')}}" class="form-control" name="social_network">
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label">Note:</label>

                        <div class="col-sm-5"><input type="text" placeholder="Có thể trống" value="{{ old('note', $ctv->note ?? '')}}" class="form-control" name="note">
                        </div>
                    </div>
                    @if ($action == 'edit')
                    <input type="text" name="id" value="{{$ctv->id}}" hidden>                    
                    @endif                    
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white" href="{{route('ctv.index')}}">Cancel</a>
                            <button class="btn btn-primary" type="submit">{{ $action == 'edit' ? 'Cập nhật' : 'Save'}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
