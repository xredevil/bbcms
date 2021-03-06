@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Sửa trang ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>
    	<span class="glyphicon glyphicon-book"></span> Sửa trang
    </h3>
	<!-- Tabs -->
	<ul class="nav nav-tabs" style="margin: 15px 0">
		<li class="active"><a href="#tab-general" data-toggle="tab">Thông tin chung</a></li>
	</ul>

	<form method="post" action="" autocomplete="off" role="form">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<div class="row">
			<div class="col-md-9" style="border-right: 1px solid #cccccc">
				<!-- Tabs Content -->
				<div class="tab-content">
					<!-- General tab -->
					<div class="tab-pane active" id="tab-general">
						<!-- Post Title -->
						<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
							<label class="control-label" for="title">Tiêu đề</label>
							<input class="form-control" type="text" name="title" id="title" value="{{ Input::old('title', $post->title) }}" />
						</div>

						<!-- excerpt -->
						<div class="form-group {{ $errors->has('excerpt') ? 'has-error' : '' }}">
							<label class="control-label" for="excerpt">Tóm tắt</label>
							<textarea class="form-control" name="excerpt" id="excerpt" value="excerpt" rows="3">{{ Input::old('excerpt', $post->excerpt) }}</textarea>
						</div>
						<hr />
						<!-- Content -->
						<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
							<div>
								<label class="control-label" for="textareabox">Nội dung</label>
								<span class="pull-right"><a data-toggle="modal" href="#modal_updateMedia" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-cloud-upload"></i> Thêm ảnh</a></span>
							</div>
							<textarea class="form-control" name="content" id="textareabox" value="content" rows="40">{{ Input::old('content', $post->content) }}</textarea>
						</div>
						<hr />
						<!-- Post Slug -->
						<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
							<label class="control-label" for="slug">Đường dẫn</label>
							<div class="input-group">
							  <span class="input-group-addon">{{ str_finish(URL::to('/'), '/') }}page/</span>
							  <input class="form-control" type="text" name="slug" id="slug" value="{{ Input::old('slug', $post->slug) }}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<!-- Form actions -->
				<div>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="pull-left">
								<select name="status" class="form-control">
									<option value="hidden" {{ $post->status=='hidden' ? 'selected="selected"' : '' }}>Ẩn</option>									
									<option value="published" {{ $post->status=='published' ? 'selected="selected"' : '' }}>Hiển thị</option>
								</select>
							</div>
							<div class="controls pull-right">
								<button type="submit" class="btn btn-success btn-sm">Lưu</button>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Ảnh đại diện</div>
					<div class="panel-body">
					  <div class="form-group">
					    <p class="help-block" id="cover-image">
					    	@if($media)
					    		<img src="{{ asset($media->mpath . '/180x100_crop/' . $media->mname) }}" width="175" />
					    		<a class="label label-default" href="javascript:void(0)" onclick="removeNewsCover()" >Bỏ ảnh</a>
					    	@else
					    		Chưa có ảnh đại diện
					    	@endif
					    </p>
					    <input type="hidden" name="media_id" value="{{ $post->media_id }}" id="media-cover-id" />
					  </div>
					</div>
				</div>
				@if ( Sentry::getUser()->hasAnyAccess(['pages','pages.delete']) )
					<a onclick="confirmDelete(this); return false;" href="{{ route('delete/page', $post->id) }}" class="btn btn-danger btn-xs">@lang('button.delete')</a>
				@endif
			</div>
		</div>

	</form>

<!-- Upload image -->
<div class="modal fade" id="modal_updateMedia" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Thư viện</h4>
      </div>
      <div class="modal-body">
        <iframe frameborder="0" hspace="0" src="<?=url('medias/upload')?>" id="TB_iframeContent" name="TB_iframeContent131" style="height: 450px; width: 100%">This feature requires inline frames. You have iframes disabled or your browser does not support them.</iframe>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
