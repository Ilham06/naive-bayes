<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClasificationRequest;
use App\Http\Requests\ConditionRequest;
use App\Http\Requests\DataRequest;
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

    public function store(DataRequest $request)
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

    public function destroy($id)
    {
        Data::destroy($id);
        return redirect()->route('condition-data.index')->with('message', 'Sukses tambah dihapus');
    }

    public function createClasification()
    {
        return view('pages.create-clasification', [
            'conditions' => Condition::all(),
        ]);
    }

    public function calculate(ClasificationRequest $request)
    {

        $conditions = Condition::orderBy('type', 'asc')->get();
        $labelCondition = Condition::whereType('label')->first();
        $conditionData = ConditionData::with('condition')->get();

        $newConditionData = [];
        foreach ($conditionData as $key => $cd) {
            $newConditionData[$cd->data_id][$cd->condition->name] = $cd->value;
        }

        $source = collect($newConditionData);
        $yTotal = $source->where($labelCondition->name, 'Yes')->count();
        $nTotal = $source->where($labelCondition->name, 'No')->count();

        $result = [];
        $label = [];

        foreach ($conditions as $key => $condition) {
            foreach ($conditionData as $key => $cd) {
                if ($condition->id == $cd->condition_id) {

                    if ($cd->condition_id == $labelCondition->id) {
                        $result[$condition->name]['yes'] = $source->where($labelCondition->name, 'Yes')->count();
                        $result[$condition->name]['no'] = $source->where($labelCondition->name, 'No')->count();
                        $result[$condition->name]['total'] = $source->count();

                        $label = $result[$condition->name];


                    } else {
                        $result[$condition->name][$cd->value]['yes'] = $source->where($condition->name, $cd->value)->where($labelCondition->name, 'Yes')->count();

                        $result[$condition->name][$cd->value]['no'] = $source->where($condition->name, $cd->value)->where($labelCondition->name, 'No')->count();

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

        $y = $y * ($label['yes'] / $label['total']);
        $n = $n * ($label['no'] / $label['total']);

        $divider = $y + $n;

        $probsY = $y / $divider;
        $probsN = $n / $divider;

        return view('pages.result', [
            'result' => $result,
            'dataset' => $request->condition,
            'probsY' => $probsY,
            'probsN' => $probsN
        ]);
    }
}
