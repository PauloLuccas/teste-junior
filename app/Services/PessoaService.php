<?php

namespace App\Services;


use App\Repositories\PessoaRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class PessoaService implements PessoaServiceInterface
{
    /**
     * @var PessoaRepository
     */
    private $pessoaRepo;

    public function __construct(PessoaRepository $pessoaRepository)
    {
        $this->pessoaRepo = $pessoaRepository;
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?Model
    {
        return $this->pessoaRepo->find($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): ?Collection
    {
        // TODO: Implement all() method.
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): ?Model
    {
        $this->verifyCep($data['cep']);

        return $this->pessoaRepo->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): ?bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id): ?Model
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function verifyCep(string $cep)
    {

        try {
            $isCep = preg_replace('/[^0-9]/', '', $cep);

            if(strlen($isCep) <= 8)
                $this->verifyViaCep($isCep);
            else
                throw new \Exception('CEP INVÁLIDO');

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * @inheritDoc
     */
    public function verifyViaCep(string $cep)
    {

        try {
            $url = 'https://viacep.com.br/ws/'.$cep.'/json/';
            $address = json_decode(file_get_contents($url));

            if(property_exists($address, 'erro'))
                throw new \Exception('CEP NÃO ENCONTRADO.');
            else
                return $address;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
