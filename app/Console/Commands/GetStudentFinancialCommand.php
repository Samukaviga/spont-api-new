<?php

namespace App\Console\Commands;

use App\Models\Financial;
use App\Services\SponteService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class GetStudentFinancialCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'financial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sponteService = new SponteService;

        $alunos = $sponteService->getAlunos();

        foreach ($alunos as $aluno) {

            //print_r($aluno);

            $financeiro = $sponteService->getFinanceiro($aluno['AlunoID']);

            $account_receive_id = !empty($financeiro['ContaReceberID']) ? (int) $financeiro['ContaReceberID'] : null;

            if (!$account_receive_id) {
                foreach ($financeiro as $res) {
                    if (!is_array($res)) {
                        $this->warn("⚠️ Array NULL.");
                        continue;
                    }

                    $financeiroArrayCriado = createOrUpdateFinancial($res);

                    $this->warn("✅Dado Financeiro Criado com sucesso! Aluno $financeiroArrayCriado tem mais de uma conta financeira.");

                }

                continue;
            }

            $financeiroCriado = createOrUpdateFinancial($financeiro);

            $this->info("✅ Dado Financeiro Criado com sucesso! Aluno " . ($financeiroCriado ?? 'Desconhecido'));

        }
    }
}

function createOrUpdateFinancial($data)
{

    $financialCreated = Financial::updateOrCreate(
        [
            'account_receive_id' => (int) $data['ContaReceberID']
        ],
        [
            'unit_code' => (int) $data['CodigoUnidade'] ?? null,
            'student_id' => (int) $data['Aluno']['wsInfoAluno']['AlunoID'] ?? null,
            'student_name' => $data['Aluno']['wsInfoAluno']['Nome'] ?? null,
            'number_of_parcels' => is_array($data['NumeroParcelas'] ?? null) ? null : ($data['NumeroParcelas'] ?? null),
            'contract_number' => is_array($data['NumeroContrato'] ?? null) ? null : ($data['NumeroContrato'] ?? null),
            'total_gross_value' => is_array($data['TotalValorBruto'] ?? null) ? null : ($data['TotalValorBruto'] ?? null),
            'total_net_value' => is_array($data['TotalValorLiquido'] ?? null) ? null : ($data['TotalValorLiquido'] ?? null),
            'total_discount_reais' => is_array($data['TotalDescontoReais'] ?? null) ? null : ($data['TotalDescontoReais'] ?? null),
            'total_discount_percentage' => is_array($data['TotalDescontoPercentual'] ?? null) ? null : ($data['TotalDescontoPercentual'] ?? null),
            'category' => is_array($data['Categoria'] ?? null) ? null : ($data['Categoria'] ?? null),
        ]
    );

    return $financialCreated['student_name'];
}


