<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use App\Models\ConditionData;
use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConditionDataController extends Controller
{
    public function index()
    {

        $data = Data::with('condition_data.condition')->get();

        return view('pages.data', [
            'conditions' => Condition::all(),
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = Data::create([
            'code' => Str::random(5)
        ]);

        foreach ($request->condition as $key => $value) {
            ConditionData::create([
                'data_id' => $data->id,
                'condition_id' => $key,
                'value' => $value
            ]);
        }

        return redirect()->route('condition-data.index')->with('message', 'Sukses tambah data');
    }

    public function createClasification()
    {
        return view('pages.create-calculate', [
            'conditions' => Condition::all(),
        ]);
    }

    public function calculate(Request $request)
    {

        $conditions = Condition::all();
        $label = Condition::whereType('label')->first();
        $conditionData = ConditionData::with('condition')->get();
        $newConditionData = [];
        foreach ($conditionData as $key => $cd) {
            $newConditionData[$cd->data_id][$cd->condition->name] = $cd->value;
        }

        $source = collect($newConditionData);
        $yTotal = $source->where($label->name, 'Yes')->count();
        $nTotal = $source->where($label->name, 'No')->count();

        $result = [];
        $l = [];
        foreach ($conditions as $key => $condition) {
            foreach ($conditionData as $key => $cd) {
                if ($condition->id == $cd->condition_id) {

                    if ($cd->condition_id == $label->id) {
                        $result[$condition->name]['Yes'] = $source->where($label->name, 'Yes')->count();
                        $result[$condition->name]['No'] = $source->where($label->name, 'No')->count();
                        $result[$condition->name]['total'] = $source->count();

                        $l = $result[$condition->name];


                    } else {
                        $result[$condition->name][$cd->value]['yes'] = $source->where($condition->name, $cd->value)->where($label->name, 'Yes')->count();

                        $result[$condition->name][$cd->value]['no'] = $source->where($condition->name, $cd->value)->where($label->name, 'No')->count();

                        $result[$condition->name][$cd->value]['total(yes)'] = $yTotal;

                        $result[$condition->name][$cd->value]['total(no)'] = $nTotal;
                    }
                }
            }
        }

        $result = collect($result);
        $y = 1;
        $n = 1;

        foreach ($request->condition as $key => $input) {
            $y *= $result[$key][$input]['yes'] / $result[$key][$input]['total(yes)'];
            $n *= $result[$key][$input]['no'] / $result[$key][$input]['total(no)'];
        }
        $divider = ($y * ($l['Yes'] / $l['total'])) + ($n * ($l['No'] / $l['total']));

        $probsY = ($y * ($l['Yes'] / $l['total'])) / $divider;
        $probsN = ($n * ($l['No'] / $l['total'])) / $divider;
        dd($probsY + $probsN);
    }
}
