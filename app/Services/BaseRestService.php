<?php

namespace App\Services;

use App\DTOs\PaginatedDataDTO;
use App\Repositories\BaseRepository;
use App\Specifications\Specification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

/**
 * Classe de serviço REST padrão
 * @package App\Services
 */
abstract class BaseRestService
{
    protected $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Classe de validação de criação de registro
     * @return string[]
     */
    abstract public static function getCreateRules(): array;

    /**
     * Classe de validação de atualização de registro
     * @return string[]
     */
    abstract public static function getUpdateRules(): array;

    /**
     * Retorna os dados do repositório paginados
     *
     * @param int $perPage
     * @param Specification[] $specifications
     * @param array $relations
     * @param string[] $columns
     * @param string $pageName
     * @param null $page
     * @return PaginatedDataDTO
     */
    public function getPaginated($perPage = 15, $specifications = [], array $relations = [], $page = null)
    {
        $page = $this->getQueryWithSpecifications($specifications)
                     ->with($relations)
                     ->paginate($perPage, ['*'], 'page', $page);

        return new PaginatedDataDto(
            $page->items(),
            $page->total(),
            $page->perPage(),
            $page->currentPage(),
            $page->lastPage()
        );
    }

    /**
     * Retorna os registros
     *
     * @param array $specifications
     * @param array $relations
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get($specifications = [], array $relations = [])
    {
        return $this->getQueryWithSpecifications($specifications)
                    ->with($relations)
                    ->get();
    }

    /**
     * Retorna a query com os filtros aplicados
     *
     * @param Specification[] $specifications
     * @return Builder
     */
    public function getQueryWithSpecifications($specifications)
    {
        $query = $this->repository->getQuery();

        // Aplica os filtros da query
        foreach ($specifications as $specification) {
            if(!($specification instanceof Specification))
                throw new InvalidArgumentException('Invalid specifications provided');

            $query = $specification->apply($query);
        }

        return $query;
    }

    /**
     * Efetua a validação e cria um novo registro
     *
     * @param $data
     * @return Builder|\Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        Validator::validate($data, $this->getCreateRules());

        return $this->repository->create($data);
    }

    /**
     * Busca um registro
     *
     * @param int $id
     * @return Builder|\Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        return $this->repository->findOrFail($data);
    }

    /**
     * Efetua a validação e atualiza um registro
     *
     * @param int $id
     * @param array $data
     * @return Builder|\Illuminate\Database\Eloquent\Model
     */
    public function update($id, $data)
    {
        Validator::validate($data, $this->getUpdateRules());

        return $this->repository->update($id, $data);
    }

    /**
     * Deleta um registro
     *
     * @param int $id
     * @return bool|mixed|null
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
