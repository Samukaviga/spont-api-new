<?php

namespace App\Console\Commands;

use App\Services\SponteService;
use Illuminate\Console\Command;

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

            // echo $aluno['AlunoID'];

            $financeiro = $sponteService->getFinanceiro($aluno['AlunoID']);

          //  dd($financeiro);

            $contaReceberId = $financeiro[0]['ContaReceberID'];

           // dd($contaReceberId);

           $boleto = $sponteService->getLinhaDigitavelBoletos($contaReceberId, 12);

            dd($boleto);
            }
    }
}
