<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\BaseRestService;
use Illuminate\Http\Request;

/**
 * Controller REST com CRUD padrão
 * @package App\Http\Controllers\API
 */
class BaseRestController extends Controller
{
    /** @var BaseRestService */
    protected $restService;

    public function __construct(BaseRestService $restService)
    {
        $this->service = $restService;
    }

    public function index()
    {
        return $this->service->getPaginated(request('per_page', 15));
    }

    public function store()
    {
        return $this->service->create(request()->all());
    }

    public function show($id)
    {
        return $this->service->find($id);
    }

    public function update($id)
    {
        return $this->service->update($id, request()->all());
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
