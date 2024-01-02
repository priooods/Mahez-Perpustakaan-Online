<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validating($request, $items, $path, $otherPass = null, $otherValue = null) {
        $validate = Validator::make($request->all(), $items);
        if ($validate->fails()) {
            $response = $this->responses('Failure',401,null,[
                "type" => "danger",
                "title" => "Form tidak valid",
                "color" => 'red',
                "description" => implode(' & ', $validate->errors()->all()),
            ]);
            $response = $response->getOriginalContent();
            return view($path, ['failure' => $response, $otherPass => $otherValue]);
        } else {
            return null;
        }
    }

    public function responses($message = '',$code = 200, $data = null, $notification = null) {
        return response()->json([
            'response_status_code' => $code,
            'response_notification' => $notification,
            'response_message'   => $message,
            'response_data'      => $data
        ], $code);
    }
}
