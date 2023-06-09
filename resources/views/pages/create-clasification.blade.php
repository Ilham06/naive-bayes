@extends('layouts.main')

@section('content')
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Hitung Klasifikasi Baru
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('clasification.calculate') }}">
                        @csrf

                        @forelse ($conditions as $condition)
                            @if ($condition->type !== 'label')
                                <div class="mb-3">
                                    <label class="form-label">{{ $condition->name }}</label>
                                    <input name="condition[{{ $condition->name }}]" type="text" class="form-control @error('condition.' . $condition->name) is-invalid @enderror">
                                </div>
                            @endif
                        @empty
                            <p>belum ada data kondisi</p>
                        @endforelse

                        @if ($conditions->count())
                            <button type="submit" class="btn btn-primary">Submit</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
