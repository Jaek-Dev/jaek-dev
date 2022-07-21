<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SetupConfigurationValidator;
use App\Http\Requests\SetupInstallationValidator;
use Illuminate\Support\Facades\DB;

class InstallationController extends Controller
{
    /**
     * Display the site configuration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function configure() {
        return \response()->view('pages.installation.configure', [
            'title' => 'Setup Configuration',
            'site_title' => \config('app.name', 'E-commerce'),
            'is_configured' => \env('IS_CONFIGURED', false),
        ]);
    }

    /**
     * Saves the configuration file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveConfiguration(SetupConfigurationValidator $request) {
        $validated = $request->validated();

        //Test the database connection if mysql was selected
        if($validated['db_server'] === 'mysql') {
            try {
                //Modify the configuration file
                \config([
                    'database.connections.test' => [
                        'driver' => $validated['db_server'],
                        'host' => $validated['db_hostname'],
                        'database' => $validated['db_name'],
                        'username' => $validated['db_username'],
                        'password' => $validated['db_password'],
                        'charset' => $validated['charset'],
                        'collation' => $validated['collation'],
                    ]
                ]);

                DB::connection('test')->getPdo();
                DB::connection('test')->getDatabaseName();
            } catch(\Throwable|\Exception $e) {
                $errors = [];
                switch($e->getCode()) {
                    case 1049: 
                        //Unknown database name
                        $message = "Unknown database \"{$validated['db_name']}\".";
                        $errors['reason'] = $message .' Have you created the database yet?';
                        $errors['db_name'] = $message;
                    break;
                    case 1045:
                        //Access denied for user and password
                        $message = "Access denied for user \"{$validated['db_username']}\" at \"{$validated['db_hostname']}\".";
                        $errors['reason'] = $message.' Please double-check your database username and password';
                        $errors['db_username'] = 'Please check this field';
                        $errors['db_password'] = 'Please check this field';
                    break;
                    case 2002:
                        //Access denied for user and password
                        $message = "Invalid database host \"{$validated['db_hostname']}\".";
                        $errors['reason'] = $message.' Please enter a valid host address';
                        $errors['db_hostname'] = $message;
                    break;
                    default:
                        //default messages
                        $message = $e->getMessage();
                        // $message = "Access denied for user \"{$validated['db_username']}\" at \"{$validated['db_hostname']}\".";
                        $errors['reason'] = $message;
                        // $errors['db_username'] = 'Please check this field';
                        // $errors['db_password'] = 'Please check this field';
                    break;
                }
                return back()->withInput($request->input())->withErrors($errors);
            }
        }

        //Request was validated... Now write to .env file
        $data = [
            'DB_ENGINE' => $validated['db_engine'],
            'DB_CONNECTION' => $validated['db_server'],
            'DB_HOST' => $validated['db_hostname'],
            'DB_PORT' => $validated['db_port'],
            'DB_USERNAME' => $validated['db_username'],
            'DB_PASSWORD' => $validated['db_password'] === null ? '' : $validated['db_password'],
            'DB_DATABASE' => $validated['db_name'],
            'DB_TABLE_PREFIX' => $validated['table_prefix'],
            'DB_CHARSET' => $validated['charset'],
            'DB_COLLATION' => $validated['collation'],
        ];
        $this->replaceEnvData($data, null, true);
        $this->addNewEnvData('IS_CONFIGURED', 'true', true);
        return \redirect()->route('setup.configure.show')->with('configured', true);
    }

    protected function getEnvContents() {
        return \file_get_contents(\base_path('.env'));
    }

    protected function replaceEnvData($key, $value = null, $saveAfterReplacing = false) {
        $old_data = $this->getEnvContents();
        if(\is_array($key)) {
            foreach($this->sanitizeEnvDataForWriting($key) as $k => &$v) {
                $pattern = '/'.\preg_quote($k).'([\s].*)?=([\s].*)?((\'|")?'.\preg_quote(\env($k)).'(\'|")?)?((\r)?\n)?/';
                $replacement = "${k}=${v}\r\n";
                $old_data = \preg_replace($pattern, $replacement, $old_data);
            }
        } elseif(\is_string($key) || \is_int($key)) {
            $pattern = '/'.\preg_quote($key).'([\s].*)?=([\s].*)?('.\preg_quote(\env($key)).')?/';
            $replacement = "${key}={$this->sanitizeEnvDataForWriting($value)}";
            $old_data = \preg_replace($pattern, $replacement, $old_data);
        } else return false;
        return $saveAfterReplacing ? $this->overwriteEnvData($old_data) : $old_data;
    }

    protected function sanitizeValue($value) {
        if(\is_string($value) || \is_int($value)) {
            if(\is_numeric($value)) $value = \strpos($value, '.') !== false ? (float) $value : (int) $value;
            elseif(\is_resource($value)) $value = '';
            elseif(\is_array($value) || \is_object($value)) {
                $pattern = '/(\'|")'.\preg_quote(\json_encode($value)).'(\'|")/';
                if(!\preg_match($pattern, $value, $matches))
                $value = "\"".\json_encode($value)."\"";
            } elseif(\is_string($value)) {
                $value = \str_replace(['\\', '/', '\'', '"'], '', $value);
                $pattern = '/(\'|")'.\preg_quote($value).'(\'|")/';
                if(!\preg_match($pattern, $value, $matches)) 
                if(\preg_match('/[\s]+/', $value))
                $value ="\"".\addslashes($value)."\"";
            }
        }
        return $value;
    }

    protected function sanitizeEnvDataForWriting($data) {
        if(\is_array($data)) {
            foreach($data as $k => &$v) $v = $this->sanitizeValue($v);
            return $data;
        } else return $this->sanitizeValue($data);
    }

    protected function addNewEnvData($key, $value = null, $saveAfterReplacing = false) {
        if(\env($key)) return $this->replaceEnvData($key, $value, $saveAfterReplacing);
        $old_data = $this->getEnvContents();
        if(\is_array($key)) {
            $i = 0;
            $data = $this->sanitizeEnvDataForWriting($key);
            foreach($data as $k => &$v) {
                $old_data .= "${k}={$this->sanitizeEnvDataForWriting($v)}\r\n" . ($i === count($data) - 1 ? "\r\n" : '');
                $i++;
            }
        } elseif(\is_string($key) || \is_int($key)) {
            $old_data .= "${key}={$this->sanitizeEnvDataForWriting($value)}\r\n\r\n";
        } else return false;
        return $saveAfterReplacing ? $this->overwriteEnvData($old_data) : $old_data;
    }

    protected function overwriteEnvData($new_data) {
        return \file_put_contents(\base_path('.env'), $new_data);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function install() {
        return \response()->view('pages.installation.install', [
            'title' => 'Setup Configuration',
            'site_title' => \config('app.name', 'E-commerce'),
            'is_configured' => \env('IS_CONFIGURED', false),
        ]);
    }

    
    /**
     * Saves the configuration file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveInstallation(SetupInstallationValidator $request) {
        $validated = $request->validated();

        dd($request->all());

        //Test the database connection if mysql was selected
        // if($validated['db_server'] === 'mysql') {
        //     try {
        //         //Modify the configuration file
        //         \config([
        //             'database.connections.test' => [
        //                 'driver' => $validated['db_server'],
        //                 'host' => $validated['db_hostname'],
        //                 'database' => $validated['db_name'],
        //                 'username' => $validated['db_username'],
        //                 'password' => $validated['db_password'],
        //                 'charset' => $validated['charset'],
        //                 'collation' => $validated['collation'],
        //             ]
        //         ]);

        //         DB::connection('test')->getPdo();
        //         DB::connection('test')->getDatabaseName();
        //     } catch(\Throwable|\Exception $e) {
        //         $errors = [];
        //         switch($e->getCode()) {
        //             case 1049: 
        //                 //Unknown database name
        //                 $message = "Unknown database \"{$validated['db_name']}\".";
        //                 $errors['reason'] = $message .' Have you created the database yet?';
        //                 $errors['db_name'] = $message;
        //             break;
        //             case 1045:
        //                 //Access denied for user and password
        //                 $message = "Access denied for user \"{$validated['db_username']}\" at \"{$validated['db_hostname']}\".";
        //                 $errors['reason'] = $message.' Please double-check your database username and password';
        //                 $errors['db_username'] = 'Please check this field';
        //                 $errors['db_password'] = 'Please check this field';
        //             break;
        //             case 2002:
        //                 //Access denied for user and password
        //                 $message = "Invalid database host \"{$validated['db_hostname']}\".";
        //                 $errors['reason'] = $message.' Please enter a valid host address';
        //                 $errors['db_hostname'] = $message;
        //             break;
        //             default:
        //                 //default messages
        //                 $message = $e->getMessage();
        //                 // $message = "Access denied for user \"{$validated['db_username']}\" at \"{$validated['db_hostname']}\".";
        //                 $errors['reason'] = $message;
        //                 // $errors['db_username'] = 'Please check this field';
        //                 // $errors['db_password'] = 'Please check this field';
        //             break;
        //         }
        //         return back()->withInput($request->input())->withErrors($errors);
        //     }
        // }

        // //Request was validated... Now write to .env file
        // $data = [
        //     'DB_ENGINE' => $validated['db_engine'],
        //     'DB_CONNECTION' => $validated['db_server'],
        //     'DB_HOST' => $validated['db_hostname'],
        //     'DB_PORT' => $validated['db_port'],
        //     'DB_USERNAME' => $validated['db_username'],
        //     'DB_PASSWORD' => $validated['db_password'] === null ? '' : $validated['db_password'],
        //     'DB_DATABASE' => $validated['db_name'],
        //     'DB_TABLE_PREFIX' => $validated['table_prefix'],
        //     'DB_CHARSET' => $validated['charset'],
        //     'DB_COLLATION' => $validated['collation'],
        // ];
        // $this->replaceEnvData($data, null, true);
        // $this->addNewEnvData('IS_CONFIGURED', 'true', true);
        return \redirect()->route('setup.configure.show')->with('configured', true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
