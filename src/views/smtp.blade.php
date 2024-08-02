@php
    use Devzkhalil\Installer\Helpers\Environment;
@endphp

@extends('installer::master')
@section('title', 'Smtp Setup')
@section('body')
    <form id="form" action="{{ route('installer.smtp.save') }}" method="POST" class="p-3">
        @csrf
        @foreach ($smtp_info as $smtp)
            <div class="form-group">
                <label for="{{ $smtp['key'] }}">
                    {{ $smtp['title'] }}
                </label>
                <input type="text" class="form-control" id="{{ $smtp['key'] }}" name="{{ $smtp['key'] }}"
                    value="{{ Environment::pull($smtp['key']) }}">
            </div>
        @endforeach
        <div class="form-group text-center mt-5">
            <button type="submit" class="btn btn-success loader-show">
                Click To Complete
            </button>
        </div>
    </form>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.getElementById('form').addEventListener('submit', function(e) {
                e.preventDefault();

                // Serialize the form data
                const formData = new FormData(this);
                const action = this.getAttribute('action');

                axios.post(action, formData)
                    .then(function(response) {
                        //
                    })
                    .catch(function(response) {
                        // showError(response);
                        // hideLoader();
                    });

                setTimeout(() => {
                    fetchNextStep();
                }, 1000);
            });
        });
    </script>
@endsection
