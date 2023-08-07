<?php

namespace App\Repositories;

use App\Models\Venda;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Regras padrões de integração com o banco de dados
 * @package App\Repositories
 */
abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retorna o builder da query
     *
     * @return Builder
     */
    public function getQuery()
    {
        return $this->model->query();
    }

    /**
     * Cria um registro no banco
     *
     * @param array $data
     * @return Builder|Model
     */
    public function create(array $data)
    {
        return $this->getQuery()->create($data);
    }

    /**
     * Atualiza um registro no banco
     *
     * @param int $id
     * @param array $data
     * @return Builder|Model
     */
    public function update($id, array $data)
    {
        $model = $this->findOrFail($id);

        return $model->update($data);
    }

    /**
     * Deleta um registro do sistema
     *
     * @param $id
     * @return bool|mixed|null
     */
    public function delete($id)
    {
        $model = $this->findOrFail($id);

        return $model->delete();
    }

    /**
     * Busca o registro pelo id e lança exceção se não encontrar
     *
     * @param $id
     * @return @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     *
     * @throws ModelNotFoundException
     */
    public function findOrFail($id)
    {
        return $this->getQuery()->findOrFail($id);
    }

    /**
     * Busca o registro pelo id
     *
     * @param $id
     * @return @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id)
    {
        return $this->getQuery()->find($id);
    }

    /**
     * Cria registros com os eventos desabilitados
     *
     * @param array $data
     * @return bool
     */
    public function createWithoutEvents(array $data)
    {
        return $this->model::withoutEvents(function () use($data) {
            return $this->model::insert($data);
        });
    }

    /**
     * Retorna a paginação das vendas
     *
     * @param null $perPage
     * @param array $columns
     * @param string $pageName
     * @param null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->getQuery()->paginate($perPage, $columns, $pageName, $page);
    }
}
