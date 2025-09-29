<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Services\SponteService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetStudentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'getting all students';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sponteService = new SponteService;


        $alunos = $sponteService->getAlunos();

        foreach ($alunos as $aluno) {

           // dd($aluno);

            $financialCreated = Student::updateOrCreate(
                [
                    'student_id' => (int) $aluno['AlunoID']
                ],
                [
                    'responsible_financial_id' => (int) $aluno['ResponsavelFinanceiroID'] ?? null,
                    'responsible_didactic_id' => (int) $aluno['ResponsavelDidaticoID'] ?? null,

                    'name' => is_array($aluno['Nome'] ?? null) ? null : ($aluno['Nome'] ?? null),
                    'cpf' => is_array($aluno['CPF'] ?? null) ? null : ($aluno['CPF'] ?? null),
                    'rg' => is_array($aluno['RG'] ?? null) ? null : ($aluno['RG'] ?? null),
                    'midia' => is_array($aluno['Midia'] ?? null) ? null : ($aluno['Midia'] ?? null),
                    'date_of_birth' => !empty($aluno['DataNascimento']) && is_string($aluno['DataNascimento']) ? Carbon::createFromFormat('d/m/Y', $aluno['DataNascimento'])->format('Y-m-d') : null,

                    'email' => is_array($aluno['Email'] ?? null) ? null : ($aluno['Email'] ?? null),
                    'date_of_register' => !empty($aluno['DataCadastro']) && is_string($aluno['DataCadastro']) ? Carbon::createFromFormat('d/m/Y', $aluno['DataCadastro'])->format('Y-m-d') : null,
                    'ra' => is_array($aluno['RA'] ?? null) ? null : ($aluno['RA'] ?? null),
                    'portal_login' => is_array($aluno['LoginPortal'] ?? null) ? null : ($aluno['LoginPortal'] ?? null),
                    'portal_password' => is_array($aluno['SenhaPortal'] ?? null) ? null : ($aluno['SenhaPortal'] ?? null),
                    'obs' => is_array($aluno['obs'] ?? null) ? null : ($aluno['obs'] ?? null),
                    'phone' => is_array($aluno['Telefone'] ?? null) ? null : ($aluno['Telefone'] ?? null),
                    'mobile_phone' => is_array($aluno['Celular'] ?? null) ? null : ($aluno['Celular'] ?? null),
                    'current_class' => is_array($aluno['TurmaAtual'] ?? null) ? null : ($aluno['TurmaAtual'] ?? null),
                    'enrollments_number' => is_array($aluno['NumeroMatricula'] ?? null) ? null : ($aluno['NumeroMatricula'] ?? null),
                    'gender' => is_array($aluno['Sexo'] ?? null) ? null : ($aluno['Sexo'] ?? null),
                    'status' => is_array($aluno['Situacao'] ?? null) ? null : ($aluno['Situacao'] ?? null),

                    'postal_code' => is_array($aluno['CEP'] ?? null) ? null : ($aluno['CEP'] ?? null),
                    'address' => is_array($aluno['Endereco'] ?? null) ? null : ($aluno['Endereco'] ?? null),
                    'address_number' => is_array($aluno['NumeroEndereco'] ?? null) ? null : ($aluno['NumeroEndereco'] ?? null),
                    'city' => is_array($aluno['Cidade'] ?? null) ? null : ($aluno['Cidade'] ?? null),
                    'neighborhood' => is_array($aluno['Bairro'] ?? null) ? null : ($aluno['Bairro'] ?? null),
                    'hometown' => is_array($aluno['CidadeNatal'] ?? null) ? null : ($aluno['CidadeNatal'] ?? null),
                    'defaulter' => is_array($aluno['Inadimplente'] ?? null) ? null : ($aluno['Inadimplente'] ?? null),
                    'origin' => is_array($aluno['Origem'] ?? null) ? null : ($aluno['Origem'] ?? null),
                    'origin_name' => is_array($aluno['NomeOrigem'] ?? null) ? null : ($aluno['NomeOrigem'] ?? null),
                    'course_interest' => is_array($aluno['CursoInteresse'] ?? null) ? null : ($aluno['CursoInteresse'] ?? null),
                ]
            );

            $this->info("✅ Aluno Criado com sucesso! Aluno: " . ($financialCreated->name ?? 'Desconhecido'));}
    }
}
