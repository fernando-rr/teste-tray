<?php

namespace App\Http\Controllers\API;

use App\Models\Vendedor;
use App\Repositories\VendedorRepository;
use App\Services\VendaService;
use App\Services\VendedorService;
use App\Specification\Specification;
use App\Specifications\VendasIdEmailSpecification;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class VendasController extends BaseRestController
{
    public function __construct(VendaService $restService)
    {
        parent::__construct($restService);
    }

    public function index()
    {
        $relations = [
            'vendedor' => function($vendedor) {
                /** @var Builder $vendedor */
                $vendedor->select(['id', 'nome', 'email']);
            }
        ];

        $page = request('per_page', 15);

        return $this->service->getPaginated($page, $this->getRequestedSpecifications(), $relations);
    }

    /**
     * Retorna os filtros que serão aplicados
     * @return Specification[]
     */
    private function getRequestedSpecifications(): array
    {
        $specifications = [];

        if(request()->has('q_id_email'))
            $specifications[] = new VendasIdEmailSpecification(request('q_id_email'));

        return $specifications;
    }

    public function store()
    {
        $data = request()->all();

        // Busca a comissão do vendedor
        if(!empty($data['id_vendedor'])) {
            /** @var VendedorRepository $vendedorRepository */
            $vendedorRepository = app(VendedorRepository::class);

            /** @var Vendedor $vendedor */
            $vendedor = $vendedorRepository->find((int) $data['id_vendedor']);

            if(!empty($vendedor))
                $data['comissao'] = $vendedor->comissao;
        }

        return $this->service->create($data);
    }
}
