<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SponteService
{
    protected $apiUrl = "https://api.sponteeducacional.net.br/WSAPIEdu.asmx";
    protected $token;

    protected $codigoCliente;

    public function __construct()
    {
        $this->token = env('SPONTE_TOKEN');
        $this->codigoCliente = env('SPONTE_CODIGO_CLIENTE');
    }


    public function getAlunos()
    {

        $response = Http::get("$this->apiUrl/GetAlunos3", [
            'nCodigoCliente' => $this->codigoCliente,
            'sToken' => $this->token,
            'sParametrosBusca' => "Nome=", // Buscar todos os alunos
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Erro ao buscar alunos',
                'status' => $response->status(), // Código HTTP
                'body' => $response->body() // Resposta completa
            ], 500);
        }

        /*
        $xml = simplexml_load_string($response->body());
        $json = json_encode($xml);
        $data = json_decode($json, true);
        */
        $reader = new \XMLReader();
        $reader->XML($response->body());

        $student = [];
        while ($reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT && $reader->name === 'wsAluno') {
                $node = simplexml_load_string($reader->readOuterXML());
                $student[] = json_decode(json_encode($node), true);
            }
        }


        return $student;
    }

    public function getFinanceiro($studentId)
    {
        $response = Http::get("$this->apiUrl/GetFinanceiro2", [
            'nCodigoCliente' => $this->codigoCliente,
            'sToken' => $this->token,
            'sParametrosBusca' => "AlunoID=$studentId", // Buscar todos os alunos

        ]);

        $xml = simplexml_load_string($response->body());
        $json = json_encode($xml);
        $data = json_decode($json, true);

        return $data['wsFinanceiro'];
    }

    public function getSituacoesAlunos($studentId)
    {

        $response = Http::get("$this->apiUrl/GetParcelas", [
            'nCodigoCliente' => $this->codigoCliente,
            'sToken' => $this->token,
            'sParametrosBusca' => "AlunoID=$studentId", // Buscar todos os alunos
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Erro ao buscar alunos',
                'status' => $response->status(), // Código HTTP
                'body' => $response->body() // Resposta completa
            ], 500);
        }
        $xml = simplexml_load_string($response->body());
        $json = json_encode($xml);
        $data = json_decode($json, true);

        return $data;
    }

    public function getContasPagar()
    {

        $response = Http::get("$this->apiUrl/GetParcelasPagar", [
            'nCodigoCliente' => $this->codigoCliente,
            'sToken' => $this->token,
            # 'sParametrosBusca' => "AlunoID=$idAluno", // Buscar todos os alunos
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Erro ao buscar alunos',
                'status' => $response->status(), // Código HTTP
                'body' => $response->body() // Resposta completa
            ], 500);
        }
        $xml = simplexml_load_string($response->body());
        $json = json_encode($xml);
        $data = json_decode($json, true);

        return $data;
    }

    public function getMatriculas($studentId)
    {
        $response = Http::get("$this->apiUrl/GetMatriculas", [
            'nCodigoCliente' => $this->codigoCliente,
            'sToken' => $this->token,
            'sParametrosBusca' => "AlunoID=$studentId", // Buscar todos os alunos
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Erro ao buscar alunos',
                'status' => $response->status(), // Código HTTP
                'body' => $response->body() // Resposta completa
            ], 500);
        }
        $xml = simplexml_load_string($response->body());
        $json = json_encode($xml);
        $data = json_decode($json, true);

        return $data['wsMatricula'];
    }
}
