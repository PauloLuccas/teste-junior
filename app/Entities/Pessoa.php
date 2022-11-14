<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Pessoa.
 *
 * @package namespace App\Entities;
 */
class Pessoa extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'sobrenome', 'cpf', 'celular', 'logradouro', 'cep'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nome' => 'string',
        'sobrenome' => 'string',
        'cpf' => 'string',
        'celular' => 'string',
        'logradouro' => 'string',
        'cep' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'nome' => 'nullable|string',
        'sobrenome' => 'nullable|string',
        'cpf' => 'required|string',
        'celular' => 'nullable|string',
        'logradouro' => 'nullable|string',
        'cep' => 'required|string',
    ];

}
