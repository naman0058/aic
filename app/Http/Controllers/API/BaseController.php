<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendSuccess($data, $message = 'Success')
	{
		return response()->json([
			'status' => 'success',
			'data' => $data,
			'message' => $message
		], 200);
	}
	public function sendError($message, $error = [], $status = 500)
	{
		return response()->json([
			'status' => 'error',
			'message' => $message,
			'errors' => $error
		], $status);
	}
}
