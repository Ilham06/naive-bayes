@extends('layouts.main')

@section('content')
    <div class="wrapper my-5">
        <div class="text-center">
            <h4>Hasil Perhitungan</h4>
        </div>
        <div class="row justify-content-center mb-5 mt-4">
            @foreach ($result as $key => $r)
                <div class="col-lg-4 mb-3">
                    <div class="card">
                        <div class="card-header">
                            {{ $key }}
                        </div>
                        <div class="card-body">
                            @if ($loop->last)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Prob</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Yes</td>
                                            <td>{{ data_get($r, 'yes') }}</td>
                                            <td>{{ data_get($r, 'yes') . '/' . data_get($r, 'total') }}</td>
                                        </tr>
                                        <tr>
                                            <td>No</td>
                                            <td>{{ data_get($r, 'no') }}</td>
                                            <td>{{ data_get($r, 'no') . '/' . data_get($r, 'total') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @else
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Yes</th>
                                            <th scope="col">No</th>
                                            <th scope="col">Prob (Yes)</th>
                                            <th scope="col">Prob (No)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($r as $key => $rValue)
                                            <tr>
                                                <td>{{ $key }}</td>
                                                <td>{{ data_get($rValue, 'yes') }}</td>
                                                <td>{{ data_get($rValue, 'no') }}</td>
                                                <td>{{ data_get($rValue, 'yes') . '/' . data_get($rValue, 'total(yes)') }}</td>
                                                <td>{{ data_get($rValue, 'no') . '/' . data_get($rValue, 'total(no)') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="">
            <div class="card">
                <div class="card-header">
                    kesimpulan
                </div>
                <div class="card-body">
                    Berdasarkan dataset yang telah diinput yaitu
                    @foreach ($dataset as $key => $ds)
                        {{ $key . ' = ' . $ds }},
                    @endforeach
                    maka diperoleh hasil perhitungan sebagai berikut :
                    <br>
                    Nilai Probabilitas Y = {{ $probsY }}
                    <br>
                    Nilai Probabilitan N = {{ $probsN }}
                    <br><br>
                    Jadi, klasifikasi yang dihasilkan adalah <strong>{{ $probsY > $probsN ? 'Ya' : 'Tidak' }}</strong>.
                </div>
            </div>
        </div>
    </div>
@endsection
