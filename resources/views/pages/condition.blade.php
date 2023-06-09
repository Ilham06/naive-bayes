@extends('layouts.main')

@section('content')
    <div class="wrapper mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10">
                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        Data Kondisi
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">#</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse ($conditions as $key => $condition)
                                  <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $condition->name }}</td>
                                    <td>{{ $condition->type }}</td>
                                    <td>
                                        <form method="post" action="{{ route('condition.destroy', $condition->id) }}">
                                            @method('delete')
                                            @csrf
                                            <button onclick="return confirm('Hapus data?')" type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
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
                        <form method="post" action="{{ route('condition.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input name="name" type="text" class="form-control">
                              </div>
                            <div class="mb-3">
                                <label>Type</label>
                                <select name="type" class="form-select">
                                    <option value="criteria">criteria</option>
                                    <option value="label">label</option>
                                  </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
