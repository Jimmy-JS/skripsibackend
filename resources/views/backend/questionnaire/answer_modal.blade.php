<div class="modal-header text-danger">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="user_delete_confirm_title">Available Answer Preview</h4>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
		<div class="row">
			<div class="col-xs-12">{{ $question }} {!! ($required == 1) ? '<span class="text-danger">*Required</span>' : '' !!}</div>
	    	@if ($type == 'Checkbox')
				<div class="col-xs-12">
					@foreach ($answers as $answer)
	    				<div class="checkbox">
	    					<label for="checkbox">
	    						<input type="checkbox" class="flat" name="value" value="{{ $answer->id }}" /> {{ $answer->answer }}
    						</label>
	    				</div>
					@endforeach
				</div>
	    	@elseif ($type == 'Radio')
	    		<div class="col-xs-12">
	    			@foreach ($answers as $answer)
	    				<div class="radio">
	    					<label for="radio">
	    						<input type="radio" class="flat" name="value" value="{{ $answer->id }}" /> {{ $answer->answer }}
    						</label>
	    				</div>
	    			@endforeach
	    		</div>
	    	@elseif ($type == 'Yes or No')
	    		<div class="col-xs-6">
	    		    <div class="radio">
	    		        <label>
	    		        	<input type="radio" class="flat" name="value" checked="checked"> Ya
	    		        </label>
	    		    </div>
	    		</div>
	    		<div class="col-xs-6">
	    		    <div class="radio">
	    		        <label>
	    		        	<input type="radio" class="flat" name="value"> Tidak
	    		        </label>
	    		    </div>
	    		</div>
	    	@endif
		</div>
    @endif
</div>