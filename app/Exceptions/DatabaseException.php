<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;

class DatabaseException extends Exception
{
    public function report()
    {
        // You can log the exception here if needed.
    }

    public function render($request)
    {
        if ($this->isQueryException()) {
            $errorCode = $this->getPrevious()->getCode();

            switch($errorCode){
                case '23000':
                    return response()->json(['message' => 'Duplicate entry or unique constraint violation.'], 409);
                    
                case 'HY000':
                    return response()->json(['message' => 'Database connection error.'], 500);

                default:
                    return response()->json(['message' => 'A database error occurred.'], 500);
            }
        }

        return parent::render($request);
    }

    protected function isQueryException()
    {
        return $this->getPrevious() instanceof QueryException;
    }
}
