@extends('admin.layouts.app')
@tsknav('setting')
@section('panel')
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>@lang('Logo')</label>
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview logoPicPrev" style="background-image: url({{ getImage(fileManager()->logoIcon()->path.'/logo.png', '?'.time()) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                                <label for="profilePicUpload1" class="upload-image"><i class="las la-camera"></i></label>
                                            </div>
                                            <input type="file" class="profilePicUpload" id="profilePicUpload1" accept=".png, .jpg, .jpeg" name="logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>@lang('Favicon')</label>
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview logoPicPrev" style="background-image: url({{ getImage(fileManager()->logoIcon()->path .'/favicon.png', '?'.time()) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                                <label for="profilePicUpload2" class="upload-image"><i class="las la-camera"></i></label>
                                            </div>
                                            <input type="file" class="profilePicUpload" id="profilePicUpload2" accept=".png" name="favicon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Update')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
<style>
    .logoPicPrev{
        background-color: #bfbfbf;
    }
</style>
@endpush
