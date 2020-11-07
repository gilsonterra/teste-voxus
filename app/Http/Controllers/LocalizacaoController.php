<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use Illuminate\Http\Request;

class LocalizacaoController extends Controller
{
    private $rules = [
        'user_id' => 'required',
        'latitude' => [
            'required',
            'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'
        ],
        'longitude' => [
            'required',
            'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'
        ]
    ];

    /**
     * @OA\Get(
     *     path="/localizacoes/{userId}",
     *     summary="Buscar cordenadas da localização do usuário",     
     *     tags={"Localizacao"},     
     *      @OA\Parameter(
     *         name="userId",
     *         in= "path",
     *         description= "ID do usuário que deseja saber a localização",
     *         required=true,
     *         @OA\Schema(type="integer", format="int64")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Localização do usuário",     
     *         @OA\Schema(ref="#/components/schemas/LocalizacaoResponse",type="array"),     
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Erro inesperado",
     *         @OA\Schema(ref="#/components/schemas/Erro")
     *     )
     * )
     * 
     * @param Request $request
     * @return array
     */
    public function buscarLocalizacaoPorUsuario(int $userId)
    {
        $localizacao = Localizacao::where('user_id', $userId)->get();
        return $this->createResponse($localizacao);
    }

    /**
     * @OA\Post(
     *     path="/localizacoes",
     *     summary="Atualiza a localização de algum usuário",
     *     operationId="store",
     *     tags={"Localizacao"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados da cordenada da localização do usuário",
     *         @OA\JsonContent(ref="#/components/schemas/LocalizacaoRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados da cordenada atualizados",
     *         @OA\JsonContent(ref="#/components/schemas/LocalizacaoResponse"),
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Erro inesperado",
     *         @OA\Schema(ref="#/components/schemas/Erro")
     *     )
     * )
     * 
     * @param Request $request
     * @return array
     */
    public function atualizarLocalizacaoPorUsuario(Request $request)
    {                
        $this->validate($request, $this->rules, self::MENSAGENS);
        
        $data = [
            'user_id' => $request->input('user_id'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude')
        ];

        $localizacao = Localizacao::updateOrCreate($data);    
        return $this->createResponse($localizacao);
    }
}
