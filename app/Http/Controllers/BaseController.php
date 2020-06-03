<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Void_;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Component\Console\Helper\Table;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message = null, $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];

        return response($response, $code);
    }

    public function sendResponseJson($result, $message = null, $code = 200)
    {
        foreach ($result as $r)
        {
            $r->content = json_decode($r->content, true);
        }
//        dd($result);
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result
        ];


        return response($response, $code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($errorMessages, $code = 404)
    {
        $response = [
            'success' => false,
//            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['message'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function notFound($obj, int $id)
    {
        if( is_null($obj::find($id))){
            $response = [
                'success' => false,
                'message' => $obj.' NOT FOUND'
            ];

            return response()->json($response, 404);
        }

        return null;


    }
}
