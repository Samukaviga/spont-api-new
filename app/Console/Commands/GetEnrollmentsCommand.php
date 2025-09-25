<?php

namespace App\Console\Commands;

use App\Models\Enrollment;
use App\Services\SponteService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetEnrollmentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enrollments';

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

           // dd($aluno);
              // echo $aluno['AlunoID'];

            $matricula = $sponteService->getMatriculas($aluno['AlunoID']);

            // $matricula = $sponteService->getMatriculas($idAluno);

            // print_r($matricula);

            //dd($matricula);

            // Se AlunoID não existir, for null ou 0 → pula
            if (empty($matricula['AlunoID']) || $matricula['AlunoID'] == 0) {
                $this->warn('⚠️ Matrícula ignorada (AlunoID inválido).');

                continue;
            }

            $startDateFormat = !empty($matricula['DataInicio']) && is_string($matricula['DataInicio'])
                ? Carbon::createFromFormat('d/m/Y', $matricula['DataInicio'])->format('Y-m-d')
                : null;

            $deadlineDateFormat = !empty($matricula['DataTermino']) && is_string($matricula['DataTermino'])
                ? Carbon::createFromFormat('d/m/Y', $matricula['DataTermino'])->format('Y-m-d')
                : null;

            $enrollmentDate = !empty($matricula['DataMatricula']) && is_string($matricula['DataMatricula'])
                ? Carbon::createFromFormat('d/m/Y', $matricula['DataMatricula'])->format('Y-m-d')
                : null;

            $enrollment = Enrollment::updateOrCreate(
                [
                    'student_id' => (int) $matricula['AlunoID'],
                    'enrollments_id' => (int) $matricula['ContratoID']
                ],
                [
                    'enrollments_id' => (int) $matricula['ContratoID'] ?? null,
                    'course_id' => (int) $matricula['CursoID'] ?? null,
                    'class_id' => (int) $matricula['TurmaID'] ?? null,
                    'student_name' => is_array($matricula['Aluno'] ?? null) ? null : ($matricula['Aluno'] ?? null),
                    'class_name' => is_array($matricula['NomeTurma'] ?? null) ? null : ($matricula['NomeTurma'] ?? null),
                    'course_name' => is_array($matricula['NomeCurso'] ?? null) ? null : ($matricula['NomeCurso'] ?? null),
                    'status' => is_array($matricula['Situacao'] ?? null) ? null : ($matricula['Situacao'] ?? null),
                    'start_date' => $startDateFormat ?? null,
                    'deadline_date' => $deadlineDateFormat ?? null,
                    'enrollment_date' => $enrollmentDate ?? null,
                    'contractor' => is_array($matricula['Contratante'] ?? null) ? null : ($matricula['Contratante'] ?? null),
                    'financial_released' => is_array($matricula['FinanceiroLancado'] ?? null) ? null : ($matricula['FinanceiroLancado'] ?? null),
                    'contract_number' => is_array($matricula['NumeroContrato'] ?? null) ? null : ($matricula['NumeroContrato'] ?? null),
                ]
            );

            $this->info("✅ Matrícula {$enrollment->id} criada para aluno " . ($matricula['Aluno'] ?? 'Desconhecido'));
        }
    }
}
