@php
    use Devzkhalil\Installer\Helpers\Environment;
@endphp

@extends('installer::master')
@section('title', 'License Validation')
@section('body')
    <form id="form" action="{{ route('installer.license-validation.process') }}" method="POST" class="p-3">
        @csrf
        <div class="form-group">
            <label for="license_key">
                Enter You License Key <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control @error($license_input_name) is-invalid @enderror" id="license_key"
                name="{{ $license_input_name }}" value="{{ old($license_input_name) }}" placeholder="bfa25.....">
            @error($license_input_name)
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div
            class="form-group text-center mt-5 d-flex {{ $is_first_step == 0 ? 'justify-content-center' : 'justify-content-between' }} align-items-center">
            @if ($is_first_step !== 0)
                <a href="{{ route('installer.previous') }}" class="btn btn-info loader-show">
                    Previous
                </a>
            @endif
            <button type="submit" class="btn btn-success loader-show">
                Click To Complete
            </button>
        </div>
    </form>
@endsection
@section('scripts')
@endsection
