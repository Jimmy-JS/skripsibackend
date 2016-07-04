<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller {
	protected $statusCode = 200;
	
	public function getStatusCode() {
		return $this->statusCode;
	}

	public function setStatusCode($statusCode) {
		$this->statusCode = $statusCode;
		return $this;
	}

	public function respond($data, $headers = []) {
		return Response::json($data, $this->statusCode, $headers);
	}

	public function makeResponse($message, $data = null){
		// standar balikan result code, status, message, data
		$result = [
            'code' => $this->statusCode, // ambil dari property statusCode (protected) u/ set statusCode pakai setStatusCode()
            'status' => ($this->statusCode == 200) ? 'success' : 'error',
        ];
        if(!empty($message)) $result['message'] = $message;
        if(!empty($data)) $result['data'] = $data;
        return $this->respond($result);  
	}

	public function respondWithPaginator($item, $limit, $headers = []) {
		$data = array_merge([ // Buat merge $data dengan paginator
			'paginator' => [
                'total_items' => $item->total(), // total() & lastPage() not available on simplePaginate()
                'total_pages' => $item->lastPage(), // atau ceil($item->total() / $item->perPage()),
                'current_page' => $item->currentPage(),
                'per_page' => $item->perPage(),
                'next_url' => $item->nextPageUrl() . '&limit=' . $limit,
                'previous_url' => $item->previousPageUrl() . '&limit=' . $limit
            ]
		], [
			'code' => $this->statusCode,
			'status' => ($this->statusCode == 200) ? 'success' : 'error',
			'data' => $item->items()
		]);
		return $this->respond([
            $data
        ]);
	}

	public function respondWithSimplePaginator($item, $limit, $headers = []) {
		$data = [ // Buat merge $data dengan paginator
			'paginator' => [
                'current_page' => $item->currentPage(),
                'per_page' => $item->perPage(),
                'next_url' => $item->nextPageUrl() . '&limit=' . $limit,
                'previous_url' => $item->previousPageUrl() . '&limit=' . $limit
            ],
            'code' => $this->statusCode,
            'status' => ($this->statusCode == 200) ? 'success' : 'error',
            'data' => $item->items()
		];
		return $this->respond([
            $data
        ]);
	}

	public function respondNotFound($message = 'Not Found!', $headers = []) {
		
		return $this->setStatusCode(404)->makeResponse($message, $headers);
	}

	public function respondUnauthorized($message = 'Unauthorized!', $headers = []) {
		
		return $this->setStatusCode(401)->makeResponse($message, $headers);
	}

	public function respondValidationError($message = 'Validation Error!', $headers = []) {
		
        return $this->setStatusCode(422)->makeResponse($message, $headers);
	}

	public function respondCreated($message = 'Successfuly Created !', $data = null, $headers = []) {
		
		return $this->setStatusCode(201)->respond([
			'code' => $this->statusCode,
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $headers);
	}

	// embed selected fields
    public function embedSelectedFields($selects, $value, $selectableFields = null){
        $selects = explode(',', $selects);
        $temp = [];
        if(!empty($selectableFields)){
	        foreach ($selects as $key => $val) {
	            if(array_key_exists($val, $selectableFields)) $temp[] = $selectableFields[$val];
	        }
	    }else{
	    	$temp = $selects;
	    }
        if(count($temp) > 0) return $value->select($temp);
        else return $value;
    }

    public function isEmptyID($id, $field = 'ID'){
        if(empty($id)) return $this->respondValidationError($field.' can\'t be empty or zero');
        if(!is_numeric($id)) return $this->respondValidationError($field.' must be in numeric format');
        return false;
    }
}