@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profil</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::user()->address != null)
                      @include('components/users/index')
                    @else
                      @include('components/users/registration')
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
