@php
/**
 * @project         E-Commerce API Service
 * @author          Jacob Eke <jaek.dev@gmail.com>
 * @author_uri      https://jaek.dev
 * @copyright       protected
 * @version         1.0.1
 * 
 * ------------------------------------------------
 * The Database Configuration
 * ------------------------------------------------
 */    
// print_r( config('database.connections.mysql.engine'));
// var_dump(file(base_path('.env')));

$db_engine = \old('db_engine', \config('database.connections.mysql.engine'));
$db_name = \Str::slug(\old('db_name', \config('app.name', 'E Commerce') . ' db'), '_');
$db_database = \Str::slug(\old('db_database', \config('app.name', 'e-commerce')), '_');
$table_prefix = \Str::slug(\old('table_prefix', Str::random(\mt_rand(3, 8))), '_');
$db_port = \old('db_port', \config('database.connections.mysql.port'));
$db_hostname = \old('db_hostname', 'localhost');
$db_username = \old('db_username', 'root');
$db_password = \old('db_password');
$db_server = \old('db_server');
@endphp

@extends('layouts.installation.app')

@section('content')
    @if (session('configured'))
        <h1>Success!...</h1>
        <p>
            All right sparky! You&#8217;ve made it through this part of the installation.
            {{$site_title}} can now communicate with your database. 
            If you are ready, time now to&hellip;
        </p>
        <p class="step"><a href="install" class="btn btn-secondary btn-sm">Run the install</a></p>
    @else
        @if($is_configured)
            <h1>Already Configured...</h1>
            <p>
                {{$site_title}} configuration setup has already been configured and saved.
                If you're the owner of this website and you need to reset any of the 
                configuration items, please login and change it from admin panel.
            </p> 
            <p class="step"><a href="{{route('home')}}" class="btn btn-sm btn-secondary">Return to Homepage</a></p>
        @else
            <form method="POST" action="{{\route('setup.configure.save')}}">
                <p>
                    Below you should enter your database connection details. 
                    If you&#8217;re not sure about these, contact your host.
                    <ol class="pl-2 mb-5">
                        <li>
                            <strong> Database Name:</strong>
                            <span>The name of the database you want to run {{$site_title}} in.</span>
                        </li>
                        <li>
                            <strong> Database Username:</strong>
                            <span>Your MySQL username.</span>
                        </li>
                        <li>
                            <strong>Database Host:</strong>
                            <span>You should be able to get this info from your web host, if <code>localhost</code> does not work.</span>
                        </li>
                        <li>
                            <strong> Database Password:</strong>
                            <span>Your MySQL password.</span>
                        </li>
                        <li>
                            <strong>Table Prefix:</strong>
                            <span>If you want to run multiple {{$site_title}} installations in a single database, change this.</span>
                        </li>
                    </ol>
                </p>
                @error('reason')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="mb-3">
                            <label for="db_server" class="form-label">Database Server</label>
                            <select class="form-select @error('db_server') is-invalid @enderror" name="db_server" id="db_server">
                                <option value="mysql" {{$db_server === 'mysql' ? 'selected' : ''}}>MySQL</option>
                                <option value="sqlite" {{$db_server === 'sqlite' ? 'selected' : ''}}>SQLite</option>
                            </select>
                            @error('db_server')
                                <div class="invalid-feedback">{{Str::ucfirst($message)}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="mb-3">
                            <label for="db_engine" class="form-label">Database Engine</label>
                            <select class="form-select @error('db_engine') is-invalid @enderror" name="db_engine" id="db_engine">
                                <option value="InnoDB"{{($db_engine == 'InnoDB' ? 'selected' : '')}}>InnoDB</option>
                                <option value="MyISAM"{{($db_engine == 'MyISAM' ? 'selected' : '')}}>MyISAM</option>
                                <option value="Federated"{{($db_engine == 'Federated' ? 'selected' : '')}}>Federated</option>
                                <option value="Blackhole"{{($db_engine == 'Blackhole' ? 'selected' : '')}}>Blackhole</option>
                                <option value="Merge"{{($db_engine == 'Merge' ? 'selected' : '')}}>Merge</option>
                                <option value="NDB"{{($db_engine == 'NDB' ? 'selected' : '')}}>NDB</option>
                                <option value="Archive"{{($db_engine == 'Archive' ? 'selected' : '')}}>Archive</option>
                                <option value="CSV"{{($db_engine == 'CSV' ? 'selected' : '')}}>CSV</option>
                                <option value="Memory"{{($db_engine == 'Memory' ? 'selected' : '')}}>Memory</option>
                            </select>
                            @error('db_engine')
                                <div class="invalid-feedback">{{Str::ucfirst($message)}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group mb-3">
                            <label for="DB_Name">Database Name</label>
                            <input type="text" name="db_name" id="DB_Name" class="form-control @error('db_name') is-invalid @enderror" value="{{$db_name}}" placeholder="Database Name">
                            @error('db_name')
                                <div class="invalid-feedback">{{Str::ucfirst($message)}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group mb-3">
                            <label for="DB_Username">Database Username</label>
                            <input type="text" name="db_username" id="DB_Username" class="form-control @error('db_username') is-invalid @enderror" value="{{$db_username}}" placeholder="Database Username">
                            @error('db_username')
                                <div class="invalid-feedback">{{Str::ucfirst($message)}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group mb-3">
                            <label for="DB_Host">Database Host</label>
                            <input type="text" name="db_hostname" id="DB_Host" class="form-control @error('db_hostname') is-invalid @enderror" value="{{$db_hostname}}" placeholder="Database Host">
                            @error('db_hostname')
                                <div class="invalid-feedback">{{Str::ucfirst($message)}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group mb-3">
                            <label for="DB_Port">Database Port</label>
                            <input type="text" name="db_port" id="DB_Port" class="form-control @error('db_port') is-invalid @enderror" value="{{$db_port}}" placeholder="Database Port">
                            @error('db_port')
                                <div class="invalid-feedback">{{Str::ucfirst($message)}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="form-group mb-3">
                            <label for="DB_Password">Password</label>
                            <input type="text" name="db_password" id="DB_Password" class="form-control @error('db_password') is-invalid @enderror" value="{{$db_password}}" placeholder="MySQL Password">
                            @error('db_password')
                                <div class="invalid-feedback">{{Str::ucfirst($message)}}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group mb-3">
                            <label for="Table_Prefix">Table Prefix</label>
                            <input type="text" name="table_prefix" id="Table_Prefix" class="form-control @error('table_prefix') is-invalid @enderror" value="{{$table_prefix}}" placeholder="Table Prefix">
                            @error('table_prefix')
                                <div class="invalid-feedback">{{Str::ucfirst($message)}}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                @csrf 
                <div class="form-group mb-3 mt-2">
                    <button class="btn btn-secondary" type="submit">Submit</button>
                </div>
            </form>
        @endif
    @endif
@endsection