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

            if ($matricula instanceof \Illuminate\Http\JsonResponse) {
                $matricula = $matricula->getData(true); // agora vira array
            }

            if (!is_array($matricula)) {
                $this->error("❌ getMatriculas não retornou um array.");
                dd($matricula);
            }

            // $matricula = $sponteService->getMatriculas($idAluno);

            // dd($matricula);

            // print_r($matricula);

            //  var_dump($matricula);

            // Se AlunoID não existir, for null ou 0 → pula
            if (empty($matricula['AlunoID']) || $matricula['AlunoID'] == 0) {
                $this->warn('⚠️ Aluno com mais de uma matricula .');


                foreach ($matricula as $res) {


                    if (!is_array($res)) {
                        $this->warn('⚠️  Sem valor atribuido');
                        continue;
                    }

                    // -------------

                    $startDateFormat = !empty($res['DataInicio']) && is_string($res['DataInicio'])
                        ? Carbon::createFromFormat('d/m/Y', $res['DataInicio'])->format('Y-m-d')
                        : null;

                    $deadlineDateFormat = !empty($res['DataTermino']) && is_string($res['DataTermino'])
                        ? Carbon::createFromFormat('d/m/Y', $res['DataTermino'])->format('Y-m-d')
                        : null;

                    $enrollmentDate = !empty($res['DataMatricula']) && is_string($res['DataMatricula'])
                        ? Carbon::createFromFormat('d/m/Y', $res['DataMatricula'])->format('Y-m-d')
                        : null;

                    $contratoId = !empty($res['ContratoID']) ? (int) $res['ContratoID'] : null;
                    if (!$contratoId) {
                        $this->warn("⚠️ Matrícula sem ContratoID válido, ignorada.");
                        continue;
                    }


                    $enrollment = Enrollment::updateOrCreate(
                        [
                            'enrollments_id' => (int) $contratoId
                        ],
                        [
                            'student_id' => (int) $res['AlunoID'],
                            'enrollments_id' => (int) $res['ContratoID'] ?? null,
                            'course_id' => (int) $res['CursoID'] ?? null,
                            'class_id' => (int) $res['TurmaID'] ?? null,
                            'student_name' => is_array($res['Aluno'] ?? null) ? null : ($res['Aluno'] ?? null),
                            'class_name' => is_array($res['NomeTurma'] ?? null) ? null : ($res['NomeTurma'] ?? null),
                            'course_name' => is_array($res['NomeCurso'] ?? null) ? null : ($res['NomeCurso'] ?? null),
                            'status' => is_array($res['Situacao'] ?? null) ? null : ($res['Situacao'] ?? null),
                            'start_date' => $startDateFormat ?? null,
                            'deadline_date' => $deadlineDateFormat ?? null,
                            'enrollment_date' => $enrollmentDate ?? null,
                            'contractor' => is_array($res['Contratante'] ?? null) ? null : ($res['Contratante'] ?? null),
                            'financial_released' => is_array($res['FinanceiroLancado'] ?? null) ? null : ($res['FinanceiroLancado'] ?? null),
                            'contract_number' => is_array($res['NumeroContrato'] ?? null) ? null : ($res['NumeroContrato'] ?? null),
                            'type_of_contract' => is_array($res['TipoContratoID'] ?? null) ? null : ($res['TipoContratoID'] ?? null),
                            'type' => is_array($res['Tipo'] ?? null) ? null : ($res['Tipo'] ?? null),
                        ]
                    );

                    $this->info("✅ Matrícula Araay {$enrollment->id} criada para aluno " . ($res['Aluno'] ?? 'Desconhecido'));



                    //---------------

                }


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

            $contratoIdTwo = !empty($matricula['ContratoID']) ? (int) $matricula['ContratoID'] : null;
            if (!$contratoIdTwo) {
                $this->warn("⚠️ Matrícula sem ContratoID válido, ignorada.");
                continue;
            }


            $enrollment = Enrollment::updateOrCreate(
                [
                    'enrollments_id' => (int) $contratoIdTwo
                ],
                [
                    'student_id' => (int) $matricula['AlunoID'],
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
