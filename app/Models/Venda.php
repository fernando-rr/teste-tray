<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Venda
 * @package App\Models
 * @mixin Builder
 *
 * @property int id
 * @property int id_vendedor
 * @property double valor
 * @property double comissao
 * @property Vendedor vendedor
 */
class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';

    protected $fillable = [
        'id_vendedor',
        'valor',
        'comissao',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public $timestamps = true;

    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class, 'id_vendedor');
    }
}
