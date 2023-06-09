<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConditionRequest;
use App\Models\Condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    public function index()
    {
        return view('pages.condition', [
            'conditions' => Condition::all()
        ]);
    }

    public function store(ConditionRequest $request)
    {
        Condition::create($request->all());
        return redirect()->route('condition.index')->with('message', 'Sukses tambah data');
    }

    public function destroy($id)
    {
        Condition::destroy($id);
        return redirect()->route('condition.index')->with('message', 'Sukses hapus data');
    }

    public function process()
    {
        # code...
    }
}
