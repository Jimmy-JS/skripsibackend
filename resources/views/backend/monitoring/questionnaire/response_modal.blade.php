<div class="modal-header text-danger">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" id="user_delete_confirm_title">{{ $user->first_name }} Questionnaire Response</h4>
</div>
<div class="modal-body">
    @if($error)
        <div>{!! $error !!}</div>
    @else
    	@foreach($questions as $question)
		<div class="row paddingb-5">
			<div class="col-xs-12">
				<label>{{ $question->question }} {!! ($question->required == 1) ? '<span class="text-danger">*Required</span>' : '' !!}</label>
		    	@if ($question->type == 'Text')
					<input type="text" class="form-control" value="{{ $question->response->response}}" />
		    	@elseif ($question->type == 'Textarea')
					<textarea class="form-control" row="5px">{{ $question->response->response}}</textarea>
		    	@elseif ($question->type == 'Radio')
	    			@foreach ($question->answers as $answer)
	    				<div class="radio">
	    					<label for="radio">
	    						<input type="radio" class="flat" name="" value="{{ $answer->id }}"
	    							@if (isset($question->response))
		    							{{ ($question->response->response == $answer->id) ? ' checked="checked"' : '' }}
	    							@endif
	    						/> {{ $answer->answer }}
    						</label>
	    				</div>
	    			@endforeach
		    	@elseif ($question->type == 'Checkbox')
		    		<?php
		    			$checkboxResponse = explode(',', $question->response->response);
		    		?>
					@foreach ($question->answers as $answer)
	    				<div class="checkbox">
	    					<label for="checkbox">
	    						<input type="checkbox" class="flat" name="" value="{{ $answer->id }}" 
	    						@foreach($checkboxResponse as $checkboxR)
									@if ($answer->id == $checkboxR)
										{{ 'checked="checked"' }}
									@endif
								@endforeach
	    						/> {{ $answer->answer }}
    						</label>
	    				</div>
					@endforeach
		    	@elseif ($question->type == 'Yes or No')
		    		<div class="col-xs-6">
		    		    <div class="radio">
		    		        <label>
		    		        	<input type="radio" class="flat" name=""{{ ($question->response->response == 'Yes') ? 'checked="checked"' : ''}}> Ya
		    		        </label>
		    		    </div>
		    		</div>
		    		<div class="col-xs-6">
		    		    <div class="radio">
		    		        <label>
		    		        	<input type="radio" class="flat" name=""{{ ($question->response->response == 'No') ? 'checked="checked"' : ''}}> Tidak
		    		        </label>
		    		    </div>
		    		</div>
		    	@endif
	    	</div>
		</div>
		<hr />
		@endforeach
    @endif
</div>