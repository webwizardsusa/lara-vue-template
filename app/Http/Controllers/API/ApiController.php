<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response as Res;
use Illuminate\Routing\Controller;
use Response;
use Validator;

class ApiController extends Controller
{
    /**
     * @var int
     */
    protected $statusCode = Res::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $message
     * @return json response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondSuccess($data = [], $message = '')
    {
        $this->setStatusCode(Res::HTTP_OK);

        return $this->respond([
            'success' => 'true',
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function respondNotify($message = '')
    {
        $this->setStatusCode(Res::HTTP_OK);

        return $this->respond([
            'success' => 'true',
            'message' => $message,
        ]);
    }

    public function respondNotFound($message = 'Not Found!')
    {
        $this->setStatusCode(Res::HTTP_NOT_FOUND);

        return $this->respond([
            'status' => 'error',
            'message' => $message,
        ]);
    }

    public function respondForbidden($message = 'Access Denied')
    {
        $this->setStatusCode(Res::HTTP_FORBIDDEN);

        return $this->respond([
            'status' => 'error',
            'message' => $message,
        ]);
    }

    public function respondInternalError($message)
    {
        $this->setStatusCode(Res::HTTP_INTERNAL_SERVER_ERROR);

        return $this->respond([
            'status' => 'error',
            'message' => $message,
        ]);
    }

    public function respondWithError($message, $errorString = null)
    {
        $this->setStatusCode(Res::HTTP_UNPROCESSABLE_ENTITY);

        return $this->respond([
            'status' => 'error',
            'message' => $message,
            'errors' => $errorString,
        ]);
    }

    public function respondError($message, $code)
    {
        $this->setStatusCode($code);

        return $this->respond([
            'status' => 'error',
            'message' => $message,
        ]);
    }

    public function respondWithValidationError($message, $errors)
    {
        $this->setStatusCode(Res::HTTP_UNPROCESSABLE_ENTITY);
        try {
            $errorString = '';
            foreach (collect($errors)->all() as $error) {
                if (@$error[0]) {
                    $errorString .= '<li>' . @$error[0] . '</li>';
                }
            }
        } catch (\Exception $e) {
            $errorString = 'Please fill all fields';
        }

        return $this->respond([
            'status' => 'error',
            'message' => $message,
            'errors' => $errorString,
        ]);
    }

    public function _validate($request, $rules)
    {
        return Validator::make($request, $rules);
    }

    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }
}
