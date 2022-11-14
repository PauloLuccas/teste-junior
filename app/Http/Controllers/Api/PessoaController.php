<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PessoaStoreRequest;
use App\Http\Requests\PessoaUpdateRequest;
use App\Services\PessoaService;
use App\Services\ValidationService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class PessoaController extends Controller
{
    /**
     * @var PessoaService
     */
    private $pessoaService;

    /**
     * @var ValidationService
     */
    private $validationService;

    public function __construct(PessoaService $pessoaService, ValidationService $validationService)
    {
        $this->pessoaService = $pessoaService;
        $this->validationService = $validationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = $this->pessoaService->all();

        return response()->json($people->toArray(),
            Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PessoaStoreRequest $request)
    {
        $validator = Validator::make($request->all(),[
            'cpf' => 'required|string|unique:pessoas',
            'cep' => 'required|string'
        ]);

        if($validator->fails())
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);

        $this->pessoaService->create($request->all());

        return response()->json(['status' => 'success', 'message' => 'People created successfully'],
            Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $pessoa = $this->pessoaService->find($id);

        if (empty($pessoa))
            return response()->json(['status' => 'erro', 'message' => 'People not found.'],
                Response::HTTP_BAD_REQUEST);

        return response()->json($pessoa, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PessoaUpdateRequest $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'cpf' => 'required|string',
            'cep' => 'required|string'
        ]);

        if($validator->fails())
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);

        $pessoa = $this->pessoaService->find($id);

        if (empty($pessoa))
            return response()->json(['status' => 'erro', 'message' => 'People not found.'],
                Response::HTTP_BAD_REQUEST);

        $this->pessoaService->update($request->all(), $id);

        return response()->json(['status' => 'success', 'message' => 'People update successfully'],
            Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pessoa = $this->pessoaService->find($id);

        if (empty($pessoa))
            return response()->json(['status' => 'erro', 'message' => 'People not found.'],
                Response::HTTP_BAD_REQUEST);

        $this->pessoaService->delete($id);

        return response()->json(['status' => 'success', 'message' => 'People delete successfully'],
            Response::HTTP_OK);
    }
}
