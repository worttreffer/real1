@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifizieren der Email-Adresse') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Ein neuer Verifikationslink wurde an die angegebene your Email-Adresse geschickt.') }}
                        </div>
                    @endif

                    {{ __('Vor dem Absenden schauen sie nach der Email mit dem Verifikationslink.') }}
                    {{ __('Wenn keine Email eingetroffen ist') }}, <a href="{{ route('verification.resend') }}">{{ __('bitte eine neue anfordern') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
