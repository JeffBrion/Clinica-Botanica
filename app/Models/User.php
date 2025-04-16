<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Instances\Instance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Users\UserModule;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Instances\UserInstance;
use App\Models\Tests\WorkerTest;
use App\Models\Tests\Answer;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'inss',
        'worker_type', //Directivo, Administrativo, Académico
        'cargo',
        'direccion',
        'age',
        'gender',   
        'entry_date',
        'contract_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userModule()
    {
        return $this->hasMany(UserModule::class);
    }

    public function modules()
    {
        $modules = new Collection();

        foreach ($this->userModule as $userModule) {
            $modules->push($userModule->module);
        }

        return $modules;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'Administrador';
    }

    public function isUser(): bool
    {
        return $this->role === 'Usuario';
    }

    public function userInstances()
    {
        return $this->hasMany(UserInstance::class);
    }

    public function superiorInstance()
    {
        return $this->hasOne(Instance::class, 'superior_id', 'id');
    }

    public function isBoos(): bool
    {
        return $this->superiorInstance()->exists();
    }

    public function workerType()
    {
        return $this->isBoos() ? 'superior' : 'worker';
    }

    public function workerTests()
    {
        return $this->hasMany(WorkerTest::class);
    }

    public function evaluatedWorkerTests()
    {
        return $this->hasMany(WorkerTest::class, 'evaluated_id');
    }

    public function evaluatorWorkerTests()
    {
        return $this->hasMany(WorkerTest::class, 'evaluator_id');
    }

    public function workerTestsStructure($period_id, $worked_type = null)
    {
        return [
            'evaluated' => [
                'autoevaluation' => $this->getworkerTest('autoevaluation', 'evaluated_id', $period_id, $worked_type),
                'coevaluation' => $this->getworkerTest('coevaluation', 'evaluated_id', $period_id, $worked_type),
                'superiorevaluation' => $this->getworkerTest('superiorevaluation', 'evaluated_id', $period_id, $worked_type),
            ],
            'evaluator' => [
                'autoevaluation' => $this->getworkerTest('autoevaluation', 'evaluator_id', $period_id, $worked_type),
                'coevaluation' => $this->getworkerTest('coevaluation', 'evaluator_id', $period_id, $worked_type),
                'superiorevaluation' => $this->getworkerTest('superiorevaluation', 'evaluator_id', $period_id, $worked_type),
            ],
        ];
    }

    public function getworkerTest($instrument_type, $evaluator_type, $period_id, $worked_type)
    {
        return WorkerTest::where($evaluator_type, $this->id)->whereHas('periodTest', function($query) use ($instrument_type, $period_id, $worked_type) {
            $query->where('instrument_type', $instrument_type)
            ->where('period_id', $period_id);
            if ($worked_type) {
                $query->where('worked_type', $worked_type);
            }
        })->get();
    }

    public function getworkerTestByPeriod($period_id)
    {
        return WorkerTest::where('evaluated_id', $this->id)->whereHas('periodTest', function($query) use ($period_id) {
            $query->where('period_id', $period_id);
        })->get();
    }

    public function getWorkerScoreByPeriod($period_id)
    {
        $workerTests = $this->workerTestsStructure($period_id)['evaluated'];
    
        $autoevaluations = $workerTests['autoevaluation'];
        $coevaluations = $workerTests['coevaluation'];
        $superiorevaluations = $workerTests['superiorevaluation'];
    
        $percentages = [
            1 => 1,
            2 => 0.5,
            3 => 1 / 3,
        ];
    
        $evaluationScores = [
            'autoevaluation' => $this->calculateScore($autoevaluations),
            'coevaluation' => $this->calculateScore($coevaluations),
            'superiorevaluation' => $this->calculateScore($superiorevaluations),
        ];

        $evaluations_types = count(array_filter($evaluationScores, fn($score) => $score > 0));
    
        if ($evaluations_types == 0) return 0;
    
        $totalScore = array_sum(array_map(fn($score) => $score * $percentages[$evaluations_types], $evaluationScores));
    
        return round($totalScore, 2);
    }
    
    public function calculateScore($evaluations)
    {
        if ($evaluations->count() == 0) return 0;

        $max_evaluation_score = $this->getMaxEvaluationScore($evaluations);

        $totalScore = $this->getEvaluationScore($evaluations);

        return round(($totalScore / $max_evaluation_score) * 5, 2);
    }

    private function getMaxEvaluationScore($evaluations)
    {
        $max_evaluation_score = 0;
        foreach ($evaluations as $evaluation) {
            $max_evaluation_score += $evaluation->periodTest->test->maxScore();
        }

        return $max_evaluation_score;
    }

    private function getEvaluationScore($evaluations)
    {
        $totalScore = 0;
        foreach ($evaluations as $evaluation) {
            $totalScore += $evaluation->getScore();
        }

        return $totalScore;
    }

    public function getWorkerScoresByPeriod($period_id)
    {
        $workerTests = $this->workerTestsStructure($period_id)['evaluated'];

        $autoevaluations = $workerTests['autoevaluation'];
        $coevaluations = $workerTests['coevaluation'];
        $superiorevaluations = $workerTests['superiorevaluation'];

        $base_max_score = 5;

        $percentages = [
            1 => 1,
            2 => 0.5,
            3 => 1 / 3,
        ];

        $p = [
            1 => 100,
            2 => 50,
            3 => 33.33,
        ];

        $evaluationScores = [
            'autoevaluation' => $this->getEvaluationScore($autoevaluations),
            'coevaluation' => $this->getEvaluationScore($coevaluations),
            'superiorevaluation' => $this->getEvaluationScore($superiorevaluations),
        ];

        $maxEvaluationsScores = [
            'autoevaluation' => $this->getMaxEvaluationScore($autoevaluations),
            'coevaluation' => $this->getMaxEvaluationScore($coevaluations),
            'superiorevaluation' => $this->getMaxEvaluationScore($superiorevaluations),
        ];

        $percentageScores = [
            'autoevaluation' => $evaluationScores['autoevaluation'] > 0 ? round(($this->getEvaluationScore($autoevaluations) / $this->getMaxEvaluationScore($autoevaluations) * 100), 2) : 0,
            'coevaluation' => $evaluationScores['coevaluation'] > 0 ? round(($this->getEvaluationScore($coevaluations) / $this->getMaxEvaluationScore($coevaluations) * 100), 2) : 0,
            'superiorevaluation' => $evaluationScores['superiorevaluation'] > 0 ? round(($this->getEvaluationScore($superiorevaluations) / $this->getMaxEvaluationScore($superiorevaluations) * 100), 2) : 0,
            'total' => round(($this->getEvaluationScore($autoevaluations) + $this->getEvaluationScore($coevaluations) + $this->getEvaluationScore($superiorevaluations)) / ($this->getMaxEvaluationScore($autoevaluations) + $this->getMaxEvaluationScore($coevaluations) + $this->getMaxEvaluationScore($superiorevaluations)), 2) * 100,
        ];

        $evaluations_types = count(array_filter($evaluationScores, fn($score) => $score > 0));
        
        $totalScore = array_sum(array_filter($evaluationScores, fn($score) => $score > 0));

        $total_percentajes_scores = [
            'autoevaluation' => $percentageScores['autoevaluation'] > 0 ? round(($evaluationScores['autoevaluation'] / $maxEvaluationsScores['autoevaluation'] * $base_max_score) * $percentages[$evaluations_types], 2) : 0,
            'coevaluation' => $percentageScores['coevaluation'] > 0 ? round(($evaluationScores['coevaluation'] / $maxEvaluationsScores['coevaluation'] * $base_max_score) * $percentages[$evaluations_types], 2) : 0,
            'superiorevaluation' => $percentageScores['superiorevaluation'] > 0 ? round(($evaluationScores['superiorevaluation'] / $maxEvaluationsScores['superiorevaluation'] * $base_max_score) * $percentages[$evaluations_types], 2) : 0,
        ];

        return [
            'autoevaluation' => [
                'amount' => $autoevaluations->count(),
                'score' => round($evaluationScores['autoevaluation'], 2),
                'max_score' => $maxEvaluationsScores['autoevaluation'],
                'percentage_score' => $percentageScores['autoevaluation'],
                'percentage' => $autoevaluations->count() > 0 ? $p[$evaluations_types] : 0,
                'total_percentage_score' => $total_percentajes_scores['autoevaluation'],
            ],
            'coevaluation' => [
                'amount' => $coevaluations->count(),
                'score' => round($evaluationScores['coevaluation'], 2),
                'max_score' => $maxEvaluationsScores['coevaluation'],
                'percentage_score' => $percentageScores['coevaluation'],
                'percentage' => $coevaluations->count() > 0 ? $p[$evaluations_types] : 0,
                'total_percentage_score' => $total_percentajes_scores['coevaluation'],
            ],
            'superiorevaluation' => [
                'amount' => $superiorevaluations->count(),
                'score' => round($evaluationScores['superiorevaluation'], 2),
                'max_score' => $maxEvaluationsScores['superiorevaluation'],
                'percentage_score' => $percentageScores['superiorevaluation'],
                'percentage' => $superiorevaluations->count() > 0 ? $p[$evaluations_types] : 0,
                'total_percentage_score' => $total_percentajes_scores['superiorevaluation'],
            ],
            'total' => [
                'amount' => $autoevaluations->count() + $coevaluations->count() + $superiorevaluations->count(),
                'score' => round($totalScore, 2),
                'max_score' => $maxEvaluationsScores['autoevaluation'] + $maxEvaluationsScores['coevaluation'] + $maxEvaluationsScores['superiorevaluation'],
                'percentage_score' => $percentageScores['total'],
                'total_percentage_score' => $total_percentajes_scores['superiorevaluation'] + $total_percentajes_scores['coevaluation'] + $total_percentajes_scores['autoevaluation'],
            ],
        ];
    }

    //función para obtener los tipos de evaluaciones que recibió un trabajador en un periodo por tipo de trabajador
    public function getWorkerExistingTestsByInstrumentType($period_id)
    {
        return [
            'Directivo' => WorkerTest::where('evaluated_id', $this->id)->whereHas('periodTest', function($query) use ($period_id) {
                $query->where('worked_type', 'Directivo')
                ->where('period_id', $period_id);
            })->exists(),
            'Administrativo' => WorkerTest::where('evaluated_id', $this->id)->whereHas('periodTest', function($query) use ($period_id) {
                $query->where('worked_type', 'Administrativo')
                ->where('period_id', $period_id);
            })->exists(),
            'Académico' => WorkerTest::where('evaluated_id', $this->id)->whereHas('periodTest', function($query) use ($period_id) {
                $query->where('worked_type', 'Académico')
                ->where('period_id', $period_id);
            })->exists(),
        ];
    }

    public function getWorkerTestsByInstrumentType($period_id, $worked_type, $instrument_type)
    {
        return WorkerTest::where('evaluated_id', $this->id)->whereHas('periodTest', function($query) use ($period_id, $worked_type, $instrument_type) {
            $query->where('worked_type', $worked_type)
            ->where('instrument_type', $instrument_type)
            ->where('period_id', $period_id);
        })->get();
    }

    //función para obtener las preguntas de un trabajador en un periodo por tipo de trabajador
    public function getWorkerQuestionsByInstrumentType($period_id, $worked_type)
    {
        $worker_tests = WorkerTest::where('evaluated_id', $this->id)->whereHas('periodTest', function($query) use ($period_id, $worked_type) {
            $query->where('worked_type', $worked_type)
            ->where('period_id', $period_id);
        })->get();

        $max_questions_test = [
            'worker_test' => null,
            'questions_amount' => 0,
        ];
        foreach ($worker_tests as $worker_test) {
            $test = $worker_test->periodTest->test;
            $questions = 0;
            foreach ($test->questionTypes as $questionType) {
                $questions += $questionType->questions->count();
            }

            if ($questions > $max_questions_test['questions_amount']) {
                $max_questions_test['worker_test'] = $test->load('questionTypes.questions');
                $max_questions_test['questions_amount'] = $questions;
            }
        }

        return $max_questions_test;
    }

    //función para obtener el promedio de una pregunta de un trabajador en un periodo por tipo de trabajador e instrumento
    public function getWorkerAverageByInstrumentType($period_id, $worked_type, $instrument_type, $question_number)
    {
        $answers = Answer::whereHas('workerTest', function($query) use ($period_id, $worked_type, $instrument_type) {
            $query->where('evaluated_id', $this->id)
            ->whereHas('periodTest', function($query) use ($period_id, $worked_type, $instrument_type) {
                $query->where('worked_type', $worked_type)
                ->where('instrument_type', $instrument_type)
                ->where('period_id', $period_id);
            });
        })->whereHas('question', function($query) use ($question_number) {
            $query->where('number', $question_number);
        })
        ->get();
        
        $total = 0;

        foreach ($answers as $answer) {
            $total += $answer->value;
        }

        return $answers->count() > 0 ? round($total / $answers->count(), 2) : 0;
    }

    //obtiene el porcentaje al que equivale cada tipo de instrumento
    public function getEvaluationsPercentages($period_id, $worked_type)
    {
        $workerTests = $this->workerTestsStructure($period_id, $worked_type)['evaluated'];
    
        $autoevaluations = $workerTests['autoevaluation'];
        $coevaluations = $workerTests['coevaluation'];
        $superiorevaluations = $workerTests['superiorevaluation'];

        $num = 0;

        if ($autoevaluations->count() > 0) $num++;
        if ($coevaluations->count() > 0) $num++;
        if ($superiorevaluations->count() > 0) $num++;

        $percentages = [
            1 => 1,
            2 => 0.5,
            3 => 1 / 3,
        ];

        return $percentages[$num]  ?? 0;
    }
}
