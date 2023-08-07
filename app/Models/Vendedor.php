<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vendedor
 * @package App\Models
 * @mixin Builder
 *
 * @property int id
 * @property string nome
 * @property string email
 * @property double comissao
 * @property Venda[] vendas
 */
class Vendedor extends Model
{
    use HasFactory;

    protected $table = 'vendedores';

    protected $fillable = [
        'nome',
        'email',
        'comissao',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public $timestamps = true;

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}
