@extends('installer::master')
@section('title', 'Database Setup')
@section('body')
    <form id="form" action="{{ route('installer.database.save') }}" method="POST" class="p-3">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text dg-group">
                    DB Connection
                </span>
            </div>
            <input type="text" class="form-control" id="DB_CONNECTION" name="DB_CONNECTION"
                value="{{ config('database.default') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text dg-group">
                    DB Host
                </span>
            </div>
            <input type="text" class="form-control" id="DB_HOST" name="DB_HOST"
                value="{{ config('database.connections.' . config('database.default') . '.host') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text dg-group">
                    DB Port
                </span>
            </div>
            <input type="text" class="form-control" id="DB_PORT" name="DB_PORT"
                value="{{ config('database.connections.' . config('database.default') . '.port') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text dg-group">
                    DB Name
                </span>
            </div>
            <input type="text" class="form-control" id="DB_DATABASE" name="DB_DATABASE"
                value="{{ config('database.connections.' . config('database.default') . '.database') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text dg-group">
                    DB User
                </span>
            </div>
            <input type="text" class="form-control" id="DB_USERNAME" name="DB_USERNAME"
                value="{{ config('database.connections.' . config('database.default') . '.username') }}">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text dg-group">
                    DB Pass
                </span>
            </div>
            <input type="text" class="form-control" id="DB_PASSWORD" name="DB_PASSWORD"
                value="{{ config('database.connections.' . config('database.default') . '.password') }}">
        </div>
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
                        if (response.data.success && response.data.redirect_url) {
                            setTimeout(() => {
                                window.location.href = response.data.redirect_url;
                            }, 2000);
                        }

                        if (!response.data.success && response.data.message) {
                            showError(response.data.message);
                            hideLoader();
                        }

                    })
                    .catch(function(response) {
                        showError(response);
                        hideLoader();
                    });
            });
        });
    </script>
@endsection
