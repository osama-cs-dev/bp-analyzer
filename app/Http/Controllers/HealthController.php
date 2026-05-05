<?php

namespace App\Http\Controllers;

use App\Http\Requests\HealthDataRequest;
use App\Models\UserHealthData;
use Illuminate\Http\Request;

class HealthController extends Controller
{
    public function index()
    {
        return view('health.form');
    }

    public function analyze(HealthDataRequest $request)
    {
        $data   = $request->validated();
        $age    = (int)   $data['age'];
        $weight = (float) $data['weight'];
        $height = (float) $data['height'];

        $heightM = $height / 100;
        $bmi     = round($weight / ($heightM * $heightM), 2);

        $bp     = $this->calculateBP($age, $bmi);
        $status = $this->determineStatus($bp);

        $result = sprintf(
            'Systolic %d–%d mmHg | Diastolic %d–%d mmHg | Status: %s',
            $bp['systolic_min'], $bp['systolic_max'],
            $bp['diastolic_min'], $bp['diastolic_max'],
            $status
        );

        $record = UserHealthData::create([
            'name'          => $data['name'],
            'age'           => $age,
            'weight'        => $weight,
            'height'        => $height,
            'bmi'           => $bmi,
            'systolic_min'  => $bp['systolic_min'],
            'systolic_max'  => $bp['systolic_max'],
            'diastolic_min' => $bp['diastolic_min'],
            'diastolic_max' => $bp['diastolic_max'],
            'status'        => $status,
            'result'        => $result,
        ]);

        return redirect()->route('health.result', $record->id);
    }

    public function result(UserHealthData $userHealthData)
    {
        $recommendation = $this->getRecommendation($userHealthData->status, $userHealthData->bmi);
        return view('health.result', compact('userHealthData', 'recommendation'));
    }

    public function admin()
    {
        $records = UserHealthData::latest()->paginate(15);
        return view('health.admin', compact('records'));
    }

    private function calculateBP(int $age, float $bmi): array
    {
        if ($age <= 12) {
            $sMin = 80;  $sMax = 110; $dMin = 50;  $dMax = 70;
        } elseif ($age <= 17) {
            $sMin = 105; $sMax = 120; $dMin = 60;  $dMax = 80;
        } elseif ($age <= 39) {
            $sMin = 110; $sMax = 120; $dMin = 70;  $dMax = 80;
        } elseif ($age <= 59) {
            $sMin = 115; $sMax = 125; $dMin = 70;  $dMax = 85;
        } else {
            $sMin = 120; $sMax = 135; $dMin = 75;  $dMax = 90;
        }

        if ($bmi >= 30) {
            $sMin += 5; $sMax += 10; $dMin += 3; $dMax += 5;
        } elseif ($bmi < 18.5) {
            $sMin -= 5; $sMax -= 5;  $dMin -= 3; $dMax -= 3;
        }

        return [
            'systolic_min'  => $sMin,
            'systolic_max'  => $sMax,
            'diastolic_min' => $dMin,
            'diastolic_max' => $dMax,
        ];
    }

    private function determineStatus(array $bp): string
    {
        $sMid = ($bp['systolic_min']  + $bp['systolic_max'])  / 2;
        $dMid = ($bp['diastolic_min'] + $bp['diastolic_max']) / 2;

        if ($sMid < 90 || $dMid < 60) return 'Low';
        if ($sMid < 120 && $dMid < 80) return 'Normal';
        if ($sMid < 130 && $dMid < 80) return 'Elevated';
        return 'High';
    }

    private function getRecommendation(string $status, float $bmi): string
    {
        $bmiNote = match (true) {
            $bmi < 18.5 => 'Your BMI is below the healthy range — consider increasing caloric intake with nutrient-rich foods.',
            $bmi < 25.0 => 'Your BMI is in the healthy range — great job maintaining a balanced weight.',
            $bmi < 30.0 => 'Your BMI is slightly above the healthy range — regular physical activity and a balanced diet can help.',
            default     => 'Your BMI indicates obesity, which is a key risk factor for hypertension. Consulting a healthcare provider is advised.',
        };

        $bpNote = match ($status) {
            'Normal'   => 'Your blood pressure range looks healthy. Keep up your current lifestyle habits.',
            'Elevated' => 'Your expected blood pressure is slightly elevated. Reducing sodium intake, exercising regularly, and managing stress can help.',
            'High'     => 'Your expected blood pressure falls in the high category. Please consult a doctor and monitor your blood pressure regularly.',
            'Low'      => 'Your expected blood pressure is on the low side. Stay hydrated, avoid prolonged standing, and consult a doctor if you feel dizzy.',
            default    => '',
        };

        return "$bpNote $bmiNote";
    }
}
