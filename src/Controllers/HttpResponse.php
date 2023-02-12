<?php

declare(strict_types=1);

namespace Api\Controllers;
header('Content-Type:application/json');
trait HttpResponse
{
    protected function error(array $data, string $message = null): string
    {
        $response = [
          'status' => false,
          'message' => $message,
          'data' => $data
          ];
        return json_encode($response);
    }
     protected function success(array $data, string $message = null): string
     {
         $response = [
          'status' => true,
          'message' => $message,
          'data' => $data
          ];
         return json_encode($response);
     }

     protected function internalError(string $message): string
     {
         $response = [
          'status' => false,
          'message' => 'Internal Server Error',
          'error' => $message
          ];
         return json_encode($response);
     }
}
