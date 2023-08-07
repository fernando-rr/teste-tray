<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\VendedorService;
use Illuminate\Http\Request;

class VendedoresController extends BaseRestController
{
    public function __construct(VendedorService $restService)
    {
        parent::__construct($restService);
    }
}
