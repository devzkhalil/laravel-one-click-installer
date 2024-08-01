@extends('installer::master')
@section('title', 'Basic Information')
@section('body')
    <form id="form" action="{{ route('installer.basic-information.save') }}" class="p-3" method="POST">
        @csrf
        <div class="form-group">
            <label for="APP_NAME">
                Application Name
            </label>
            <input wire:model.live="state.APP_NAME" type="text" class="form-control" id="APP_NAME" name="APP_NAME"
                value="{{ config('app.name') }}">
        </div>
        <div class="form-group">
            <label for="APP_URL">
                Application URL
            </label>
            <input type="text" class="form-control" id="APP_URL" name="APP_URL" value="{{ config('app.url') }}">
        </div>
        <div class="form-group">
            <label for="APP_DEBUG">
                Debug Mode
            </label>
            <select class="form-control" id="APP_DEBUG" name="APP_DEBUG">
                <option value="false" {{ !config('app.debug') ? 'selected' : '' }}>
                    FALSE
                </option>
                <option value="true" {{ config('app.debug') ? 'selected' : '' }}>
                    TRUE
                </option>
            </select>
        </div>
        {{-- <div class="form-group">
        <label for="APP_ENV">
            Application Environment (optional)
        </label>
        <input type="text" class="form-control" id="APP_ENV" name="APP_ENV" value="{{ config('app.env') }}">
    </div> --}}
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
                }, 4000);
            });
        });
    </script>
@endsection
