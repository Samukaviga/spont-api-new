<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\SponteService;
use Illuminate\Http\Request;

class SponteApiController extends Controller
{
    protected $sponteService;

    public function __construct(SponteService $sponteService)
    {
        $this->sponteService = $sponteService;
    }


    public function getFinanceiro()
    {
        //"AlunoID" => "11098"
        // AlunoID Devendo => 16364

        $student = $this->sponteService->getFinanceiro('16364');

        dd($student);
    }

    public function getAlunos()
    {
        $student = $this->sponteService->getAlunos();

        return response()->json($student);

    }

    public function getSituacoesAlunos()
    {
        $situacoes = $this->sponteService->getSituacoesAlunos('11098');

        dd($situacoes);
    }

    public function getContasPagar()
    {
        $accountPayable = $this->sponteService->getContasPagar();

        return response()->json($accountPayable);
    }

    public function getMatriculas()
    {
        $enrollment = $this->sponteService->getMatriculas('16364');

        dd($enrollment);
    }
}
