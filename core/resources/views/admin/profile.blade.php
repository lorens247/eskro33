@extends('admin.layouts.app')

@section('panel')

@php
    $imageData = fileManager()->profile()->admin;
@endphp

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">@lang('Update profile')</h5>

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xxl-3 col-xl-5">
                                <div class="form-group">
                                    <div class="image-upload admin-img-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage($imageData->path.'/'.auth()->guard('admin')->user()->image,$imageData->size) }})">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                                <label for="profilePicUpload1" class="upload-image"><i class="las la-camera"></i></label>
                                            </div>
                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                            <small class="mt-2 text-facebook">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 400x400px') </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-9 col-xl-7">
                                <div class="form-group ">
                                    <label class=" fw-bold">@lang('Name')</label>
                                    <input class="form-control" type="text" name="name" value="{{ auth()->guard('admin')->user()->name }}" >
                                </div>
                                <div class="form-group">
                                    <label class="  fw-bold">@lang('Email')</label>
                                    <input class="form-control" type="email" name="email" value="{{ auth()->guard('admin')->user()->email }}" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('Change Password')</h5>
                </div>
                <form action="{{ route('admin.password.update') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('Password')</label>
                            <input class="form-control" type="password" placeholder="@lang('Password')" name="old_password">
                        </div>

                        <div class="form-group">
                            <label>@lang('New Password')</label>
                            <input class="form-control" type="password" placeholder="@lang('New Password')" name="password">
                        </div>

                        <div class="form-group">
                            <label>@lang('Confirm Password')</label>
                            <input class="form-control" type="password" placeholder="@lang('Confirm Password')" name="password_confirmation">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
