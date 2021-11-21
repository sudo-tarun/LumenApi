<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //function that returns the responce in json format
    public function createSuccessResponce($data, $code)
    {
        return response()->json(['data' => $data], $code);
    }

    // function that returns error message in case of failure 
    public function createErrorMessage($message, $code)
    {
        return response()->json(['message' => $message], $code);
    }

    /**
     * Create the response for when a request fails validation.
     *
     */
    public function buildFailedValidationResponse(Request $request, array $errors)
    {
        return $this->createErrorMessage($errors, 422);
    }
}
