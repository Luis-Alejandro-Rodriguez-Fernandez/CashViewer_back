<?php


namespace App\Helpers;


class generalClass
{

    public function responseToApp($status, $data, $message = "")
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' =>$message
        ]);
    }

}
