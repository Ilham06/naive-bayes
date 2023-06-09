@extends('layouts.main')

@section('content')
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
@endsection
