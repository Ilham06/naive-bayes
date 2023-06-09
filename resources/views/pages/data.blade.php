@extends('layouts.main')

@section('content')
    <div class="wrapper mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        Data
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    @foreach ($conditions as $condition)
                                        <th scope="col">{{ $condition->name }}</th>
                                    @endforeach
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $key => $d)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        @foreach ($d->condition_data as $cd)
                                            <td>{{ $cd->value }}</td>
                                        @endforeach

                                        <td>
                                            <form method="post" action="{{ route('condition.destroy', $condition->id) }}">
                                                @method('delete')
                                                @csrf
                                                <button onclick="return confirm('Hapus data?')" type="submit"
                                                    class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data Kosong</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Tambah Data
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('condition-data.store') }}">
                            @csrf

                            @foreach ($conditions as $condition)
                                @if ($condition->type == 'label')
                                    <div class="mb-3">
                                        <label>{{ $condition->name }}</label>
                                        <select name="condition[{{ $condition->id }}]" class="form-select">
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label class="form-label">{{ $condition->name }}</label>
                                        <input name="condition[{{ $condition->id }}]" type="text" class="form-control">
                                    </div>
                                @endif
                            @endforeach

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-end mt-4">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        Hitung
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('condition-data.calculate') }}">
                            @csrf

                            @foreach ($conditions as $condition)
                                @if ($condition->type !== 'label')
                                <div class="mb-3">
                                    <label class="form-label">{{ $condition->name }}</label>
                                    <input name="condition[{{ $condition->name }}]" type="text" class="form-control">
                                </div>
                                @endif
                            @endforeach

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
