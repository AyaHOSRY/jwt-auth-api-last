<?php

namespace App\Exceptions;

//use App\Http\Controllers\ProductController;
use Exception;
use Symfony\Component\HttpFoundation\Response;


class ProductNotBelongToUser extends Exception
{
    public function render()
    {
        return ['errors'=>'product dont belong to user'];
    }
}