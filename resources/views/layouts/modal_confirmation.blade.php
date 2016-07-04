<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="user_delete_confirm_title">Delete confirmation</h4>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
        {{ 'Apakah kamu yakin ingin menghapus data ini ?' }}
    @endif
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
  @if(!$error)
  {{ Form::open(['method' => 'DELETE', 'route' => [$route, $id], 'style' => "float:right;margin-left: 10px;"]) }}
    <button type="submit" class="btn btn-danger">OK</a>
  {{ Form::close() }}
  @endif
</div>
