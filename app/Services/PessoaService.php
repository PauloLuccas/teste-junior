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

    /**
     * @var ValidationService
     */
    private $validationService;

    public function __construct(PessoaRepository $pessoaRepository, ValidationService $validationService)
    {
        $this->pessoaRepo = $pessoaRepository;
        $this->validationService = $validationService;
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?Model
    {
        return $this->pessoaRepo->findPeople($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): ?Collection
    {
        return $this->pessoaRepo->all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): ?Model
    {
        // Valida o CEP
        if($data['cep'])
            $this->validationService->verifyCep($data['cep']);

        // Valida o CPF
        if($data['cpf'])
            $this->validationService->verifyCpf($data['cpf']);

        return $this->pessoaRepo->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): ?bool
    {
        $people = $this->pessoaRepo->findPeople($id);

        if(empty($people))
            throw new \Exception('People not found.');

        return $this->pessoaRepo->delete($id);
    }

    /**
     * @inheritDoc
     */
    public function update(array $data, int $id): ?Model
    {
        // Valida o CEP
        if($data['cep'])
            $this->validationService->verifyCep($data['cep']);

        // Valida o CPF
        if($data['cpf'])
            $this->validationService->verifyCpf($data['cpf']);

        $people = $this->pessoaRepo->find($id);

        if(empty($people))
            throw new \Exception('People not found.');

        return $this->pessoaRepo->update($data, $id);
    }
}
