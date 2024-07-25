<?php

namespace Devzkhalil\Installer\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Devzkhalil\Installer\Helpers\Environment;
use Devzkhalil\Installer\Helpers\Requirements;

class InstallerController extends Controller
{
    public $phpVersionInfo = [];
    public $phpExtensions = [];
    public $enabledSteps = [];
    public $stepsWithUrls = [];
    public $support = false;
    public $symlink = null;
    public $license_input_name = 'license';

    public function __construct(Requirements $requirements)
    {
        $this->phpVersionInfo = $requirements->checkPHPversion(config('installer.php.min'));
        $this->phpExtensions = $requirements->checkPHPExts(config('installer.php.extensions'));
        $this->support = $requirements->validateSupport($this->phpVersionInfo, $this->phpExtensions);
        $this->symlink = $requirements->checkSymLink();
        $this->enabledSteps = config('installer.steps');
        $this->stepsWithUrls = [
            'license_validation' => 'installer.license-validation',
            'check_required_extensions' => 'installer.check-required-extensions',
            'basic_information_setup' => 'installer.basic-information',
            'database_setup' => 'installer.database',
            'smtp_setup' => 'installer.smtp',
        ];
        $this->license_input_name = config('installer.license.license_input_name');
    }

    public function begin()
    {
        $steps = $this->enabledSteps;
        $first_step = isset($steps[0]) ? $steps[0] : '';

        if (!$first_step) {
            abort(404, 'No step enabled for installer.');
        }

        session()->put('current_step', $first_step);

        switch ($first_step) {
            case 'license_validation':
                return $this->licenseValidation();
            case 'check_required_extensions':
                return $this->requiredExtensions();
            case 'basic_information_setup':
                return $this->basicInformation();
            case 'database_setup':
                return $this->database();
            case 'smtp_setup':
                return $this->smtp();
            default:
                abort(404, 'Invalid step provided for installer.');
        }
    }

    public function licenseValidation()
    {
        $next_step = $this->checkPermissionToGoNextStep('license_validation');
        if (gettype($next_step) != 'boolean') {
            return $next_step;
        };

        $license_input_name = $this->license_input_name;
        return view('installer::license-validation', compact('license_input_name'));
    }

    public function licenseValidationProcess(Request $request)
    {
        $request->validate([
            $this->license_input_name => 'required',
        ]);

        try {
            $data = $request->all();
            $response = Http::post(config('installer.license.api'), $data);

            if ($response->status() == 200 && $response['success']) {
                return redirect($this->getNextStep());
            } else {
                return redirect()->back()->withErrors([$this->license_input_name => 'The provided license is invalid. Please check the license number and try again.']);
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([$this->license_input_name => $th->getMessage()]);
        }
    }

    public function requiredExtensions()
    {
        $next_step = $this->checkPermissionToGoNextStep('check_required_extensions');
        if (gettype($next_step) != 'boolean') {
            return $next_step;
        };

        return view('installer::begin', [
            'phpVersionInfo' =>  $this->phpVersionInfo,
            'phpExtensions' => $this->phpExtensions,
            'supported' => $this->support,
            'symlink' => $this->symlink,
            'next_step_url' => $this->getNextStep()
        ]);
    }

    public function basicInformation()
    {
        $next_step = $this->checkPermissionToGoNextStep('basic_information_setup');
        if (gettype($next_step) != 'boolean') {
            return $next_step;
        };

        return view('installer::basic-information');
    }

    public function saveBasicInformation(Request $request)
    {
        try {
            Environment::save($request->except('_token'));

            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            return response()->json([
                'success' => true,
                'redirect_url' => $this->getNextStep(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'redirect_url' => '',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function database()
    {
        $next_step = $this->checkPermissionToGoNextStep('database_setup');
        if (gettype($next_step) != 'boolean') {
            return $next_step;
        };

        return view('installer::database');
    }

    public function saveDatabase(Request $request)
    {
        try {
            Environment::save($request->except('_token'));

            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            $this->uploadDatabase();
            $this->migration();

            return response()->json([
                'success' => true,
                'redirect_url' => $this->getNextStep(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'redirect_url' => '',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function migration()
    {
        try {
            if (config('installer.migration')) {
                Artisan::call('migrate --force');
            }
        } catch (\Throwable $th) {
            info('Installer migrate command run failed. The reason is ' . $th->getMessage());
        }
    }

    public function uploadDatabase()
    {
        try {
            if (config('installer.sql')) {
                DB::unprepared(file_get_contents(base_path('database/sql/' . config('installer.sql'))));
            }
        } catch (\Throwable $th) {
            info('Installer database import failed. The reason is ' . $th->getMessage());
        }
    }

    public function smtp()
    {
        $next_step = $this->checkPermissionToGoNextStep('smtp_setup');
        if (gettype($next_step) != 'boolean') {
            return $next_step;
        };

        $smtp_info = config('installer.smtp');
        return view('installer::smtp', ['smtp_info' => $smtp_info]);
    }

    public function saveSmtp(Request $request)
    {
        try {
            Environment::save($request->except('_token'));

            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            return response()->json([
                'success' => true,
                'redirect_url' => $this->getNextStep(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'redirect_url' => '',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function checkPermissionToGoNextStep(string $step): mixed
    {
        $current_step = session()->get('current_step');

        if ($current_step !== $step) {
            return redirect()->back();
        }

        return true;
    }

    public function getNextStep(): string
    {
        // get the current step
        $current_step = session()->get('current_step');
        $steps = $this->enabledSteps;

        // find the index of the current step
        $current_index = array_search($current_step, $steps);

        // check if the current step is not the last step in the array
        if ($current_index !== false && $current_index < count($steps) - 1) {
            // get the next step
            $next_step = $steps[$current_index + 1];
            session()->put('current_step', $next_step);
            return route($this->stepsWithUrls[$next_step]);
        } else {
            // otherwise end the installer process
            Environment::append('INSTALLER_INSTALLED', 'true');
            return url(config('installer.redirect'));
        }
    }
}
