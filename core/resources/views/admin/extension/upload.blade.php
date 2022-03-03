@extends('admin.layouts.app')
@tsknav('extension')
@section('panel')
<div class="row">
	<div class="card">
		<form action="" method="post" enctype="multipart/form-data">
			@csrf
			<div class="card-body">
				<div class="form-group">
					<label>@lang('Project Purchase Code')</label>
					<input type="text" name="purchase_code" class="form-control" value="{{ env('PURCHASE_CODE') }}" required>
				</div>
				<div class="form-group">
					<label>@lang('Template / Plugin Purchase Code') <small class="text--primary">(@lang('If any'))</small></label>
					<input type="text" name="extra_purchase_code" class="form-control">
				</div>
				<div class="form-group">
					<label>@lang('Files')</label>
					<input type="file" name="file" class="form-control" required>
				</div>
			</div>
			<div class="card-footer">
				<button type="submit" class="btn btn--primary btn-block">@lang('Upload')</button>
			</div>
		</form>
	</div>
</div>
@endsection
