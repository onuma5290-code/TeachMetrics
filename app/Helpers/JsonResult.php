<?php

namespace App\Helpers;

class JsonResult
{
    public static function jsonResult($data = null, $errors = null,  $message = "",  $success = true, $message_ex  = "")
    {
        $json['data'] = $data;
        $json['message'] = $message;
        $json['message_ex'] = $message_ex;
        $json['success'] = $success;
        $json['errors'] =  $errors;
        // return $json;
        return response()->json($json);
    }
    public static  function jsonNewResult($data = null, $errors = null,  $message = "",  $success = true, $message_ex  = "")
    {
        $json['data'] = $data;
        $json['success'] = $success;
        $json['errors'] =  $errors;
        return response()->json($json);
    }

    public static  function jsonPackageResult($data = null, $errors = null,  $message = "",  $success = true, $message_ex  = "", $package = null, $message_status = null)
    {
        $json['data'] = $data;
        $json['message_status'] = $message_status;
        $json['message'] = $message;
        $json['message_ex'] = $message_ex;
        $json['package'] = $package;
        $json['success'] = $success;
        $json['errors'] =  $errors;
        // return $json;
        return response()->json($json);
    }

    public static function resultSuccess($data = null,  $message = "", $message_ex = "")
    {
        return self::jsonResult($data, null, $message, true, $message_ex);
    }

    public static function resultErrors($errors = null,  $message = "", $message_ex = "")
    {

        return self::jsonResult(null, $errors, $message, false, $message_ex);
    }

    public static function errors($errors = null,  $message = "", $message_ex = "")
    {
        return self::jsonResult(null, $errors, $message, false, $message_ex);
    }
    public static function packageSuccess($data = null,  $message = "", $message_ex = "", $package = null, $message_status = null)
    {
        return self::jsonPackageResult($data, null, $message, true, $message_ex, $package, $message_status);
    }
    public static function packageErrors($errors = null,  $message = "", $message_ex = "", $package = null, $message_status = null)
    {
        return self::jsonPackageResult(null, $errors, $message, false, $message_ex, $package, $message_status);
    }

    public static function success($data = null,  $message = "", $message_ex = "")
    {
        return self::jsonResult($data, null, $message, true, $message_ex);
    }
    public static function newSuccess($data = null,  $message = "", $message_ex = "")
    {
        return self::jsonNewResult($data, null, $message, true, $message_ex);
    }
}
