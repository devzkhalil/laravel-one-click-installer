@extends('installer::master')
@section('title', 'Requirements')
@section('body')
    <div class="">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        Option
                    </th>
                    <th>
                        Required
                    </th>
                    <th>
                        Current
                    </th>
                    <th>
                        Support
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        PHP Version
                    </td>
                    <td>
                        v{{ $phpVersionInfo['minimum'] }}
                    </td>
                    <td>
                        v{{ $phpVersionInfo['current'] }}
                    </td>
                    <td>
                        {!! $phpVersionInfo['supported']
                            ? '<span class="badge badge-success">OK</span>'
                            : '<span class="badge badge-danger">ERROR</span>' !!}
                    </td>
                </tr>
                <tr>
                    <td>
                        PHP Extensions
                    </td>
                    <td colspan="3">
                        @foreach ($phpExtensions as $ext)
                            {!! $ext['installed']
                                ? '<span class="badge badge-success my-1">' . $ext['ext'] . '</span>'
                                : '<span class="badge badge-danger my-1">' . $ext['ext'] . '</span>' !!}
                        @endforeach
                    </td>
                </tr>
                @if (!is_null($symlink))
                    <tr>
                        <td>
                            Symbolic Links
                        </td>
                        <td colspan="3">
                            <kbd>symlink()</kbd> {!! $symlink
                                ? '<span class="badge badge-success my-1">enabled</span>'
                                : '<span class="badge badge-danger my-1">disabled</span>' !!}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="text-center">
            @if ($supported)
                <a href="{{ $next_step_url }}" class="btn btn-success loader-show">
                    Click To Complete
                </a>
            @else
                <a href="{{ route('installer.require') }}" class="btn btn-warning loader-show" id="recheck">
                    Re-check Requirements
                </a>
            @endif
        </div>
    </div>
@endsection
