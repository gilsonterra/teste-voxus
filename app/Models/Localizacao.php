<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 *  @OA\Schema(
 *     schema="LocalizacaoRequest",
 *     type="object",
 *     title="LocalizacaoRequest",
 *     description="Dados da localização do usuário",
 *     properties={ 
 *         @OA\Property(property="user_id", type="integer"),
 *         @OA\Property(property="latitude", type="string"),
 *         @OA\Property(property="longitude", type="string")
 *     }
 *  )
 * 
 *  @OA\Schema(
 *     schema="LocalizacaoResponse",
 *     type="object",
 *     title="LocalizacaoResponse",
 *     allOf={
 *          @OA\Schema(
 *              @OA\Property(property="id", type="integer"),
 *          ),
 *          @OA\Schema(ref="#/components/schemas/LocalizacaoRequest")
 *     }
 *  )
 */
class Localizacao extends Model
{
    protected $table = 'localizacao';

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'user_id' => 'int'
    ];
}
