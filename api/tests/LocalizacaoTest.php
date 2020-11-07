<?php

use App\Models\Localizacao;
use Database\Factories\LocalizacaoFactory;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LocalizacaoTest extends TestCase
{
    use DatabaseTransactions;
    
    private const URL = '/api/localizacoes';

    private function requisicaoAtualizacaoLocalizacaoUsuario(Localizacao $localizacao)
    {
        $response = $this->call('POST', self::URL, $localizacao->toArray());
        $this->assertEquals(200, $response->status());
    }

    private function verificaSeLocalizacaoFoiInseridaNoBanco(Localizacao $localizacao)
    {
        $this->seeInDatabase('localizacao', $localizacao->toArray());
    }

    private function requisicaoBuscarLocalizacaoInserida(int $userId)
    {
        $responseGet = $this->call('GET', sprintf('%s/%s', self::URL, $userId));
        $this->assertEquals(200, $responseGet->status());
    }

    public function testPostMethod()
    {               
        $localizacao = LocalizacaoFactory::new()->makeOne();   
        
        $this->requisicaoAtualizacaoLocalizacaoUsuario($localizacao);
        $this->verificaSeLocalizacaoFoiInseridaNoBanco($localizacao);
        $this->requisicaoBuscarLocalizacaoInserida($localizacao->user_id);        
    }

    public function testValidarSeLatitudeEstaInvalida()
    {        
        $localizacao = LocalizacaoFactory::new()->makeOne();   
        $localizacao->latitude = '2222';

        $response = $this->call('POST', self::URL, $localizacao->toArray());
        $this->assertEquals(422, $response->status());
    }

    public function testValidarSeLongitudeEstaInvalida()
    {        
        $localizacao = LocalizacaoFactory::new()->makeOne();   
        $localizacao->longitude = '3333';

        $response = $this->call('POST', self::URL, $localizacao->toArray());
        $this->assertEquals(422, $response->status());
    }
}
