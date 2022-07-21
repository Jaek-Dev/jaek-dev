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

$db_server = \old('db_server');
$db_name = \Str::slug(\old('db_name', \config('app.name', 'E Commerce') . ' db'), '_');
$db_username = \Str::slug(\old('db_username', 'root'), '_');
$db_hostname = \Str::slug(\old('db_hostname', 'localhost'), '_');
$db_password = \old('db_password');
$db_database = \Str::slug(\old('db_database', \config('app.name', 'e-commerce')), '_');
$table_prefix = \Str::slug(\old('table_prefix', Str::random(\mt_rand(3, 8))), '_');
$db_port = \Str::slug(\old('db_port', \config('database.connections.mysql.port')));
$db_engine = \Str::slug(\old('db_engine', \config('database.connections.mysql.engine')));
@endphp

@extends('layouts.installation.app')

@section('content')
    @if (!\env('IS_CONFIGURED'))
        <h1>Attention!</h1>
        <p>
            We couldn't find the setup configuration for your website. We need this before we can get started.
            You can create a configuration file through a web interface, but this doesn't work for all server setups. 
            The safest way is to manually create the file.
        </p>
        <p><a href="{{route('setup.configure.show')}}" class="btn btn-secondary btn-sm">Start Configuration Setup</a></p>
    @else
        @if(\env('IS_INSTALLED')) 
            <h1>Already Installed</h1>
            <p>
                You appear to have already installed {{$site_title}}
                If you want to reinstall, please clear your old database tables first.
            </p>
            <p class="step"><a href="{{route('home')}}" class="btn btn-sm btn-secondary">Return to Homepage</a></p>
        @else
            @if (Request::is('setup/*'))
                @if(session('installed'))
                    You have successfully Installed it
                @else
                <h1>Information needed</h1>
                    <p>Please provide the following information. Don&#8217;t worry, you can always change these settings later.</p>
                    <p class="message"><strong>NOTICE: there are many other options, you can configure them from the Admin Panel after installation</strong></p>
                    <form id="setup" method="post" action="{{route('setup.install.save')}}">
                        <h2 class="mb-3">Admin Informations</h2>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="first_name">First Name</label>
                                    <input name="first_name" type="text" id="first_name" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="last_name">Last Name</label>
                                    <input name="last_name" type="text" id="last_name" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="user_name">Username</label>
                                    <input name="user_name" type="text" id="user_name" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input name="email" type="text" id="email" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="admin_password">Password</label>
                                    <input name="admin_password" type="password" id="admin_password" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="admin_password2">Repeat Password</label>
                                    <input name="admin_password2" type="password" id="admin_password2" value="" class="form-control" />
                                </div>
                            </div>
                        </div>
                
                        <h2 class="mb-3">System Informations</h2>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="shop_title">Site Title</label>
                                    <input name="shop_title" type="text" id="shop_title" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="shop_url">Site URL</label>
                                    <input name="shop_url" type="text" id="shop_url" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="admin_email">System E-mail</label>
                                    <input name="admin_email" type="text" id="admin_email" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label class="d-block mb-3">Enable SMTP</label>
                                            <label style="cursor:pointer" for="smtp_email_yes" class="mr-2">
                                                <input name="smtp_email" type="radio" id="smtp_email_yes" value="1" <?= 0 ? 'checked' : ''; ?> /> Yes
                                            </label>
                                            <label style="cursor:pointer" for="smtp_email_no">
                                                <input name="smtp_email" type="radio" id="smtp_email_no" value="0" <?= !0 ? 'checked' : ''; ?> /> No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="d-block mb-3">SMTP Secure</label>
                                            <label style="cursor:pointer" for="smtp_secure_ssl" class="mr-2">
                                                <input name="smtp_secure" type="radio" id="smtp_secure_ssl" value="ssl" <?= 0 == 'ssl' || 0 == '' ? 'checked' : ''; ?> /> SSL
                                            </label>
                                            <label style="cursor:pointer" for="smtp_secure_tls">
                                                <input name="smtp_secure" type="radio" id="smtp_secure_tls" value="tls" <?= 0 == 'tls' ? 'checked' : ''; ?> /> TLS
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="smtp_port">SMTP Port</label>
                                    <input name="smtp_port" type="text" id="smtp_port" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="smtp_host">SMTP Host</label>
                                    <input name="smtp_host" type="text" id="smtp_host" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="smtp_user">SMTP Username</label>
                                    <input name="smtp_user" type="text" id="smtp_user" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="smtp_password">SMTP Password</label>
                                    <input name="smtp_password" type="password" id="smtp_password" value="" class="form-control" />
                                </div>
                            </div>
                        </div>
                
                        <h2 class="mb-3">Company Data</h2>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="company_name">Company Name</label>
                                    <input name="company_name" type="text" id="company_name" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="company_taxcode">Company Tax Code</label>
                                    <input name="company_taxcode" type="text" id="company_taxcode" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="company_email">Company Email</label>
                                    <input name="company_email" type="text" id="company_email" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="company_address">Company Address</label>
                                    <input name="company_address" type="text" id="company_address" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="company_city">Company City</label>
                                    <input name="company_city" type="text" id="company_city" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="company_zipcode">Company Zip Code</label>
                                    <input name="company_zipcode" type="text" id="company_zipcode" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="company_phone">Company Phone</label>
                                    <input name="company_phone" type="text" id="company_phone" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                    <label for="company_country">Company Country</label>
                                    <input name="company_country" type="text" id="company_country" class="form-control" value="" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group mb-3">
                                </div>
                            </div>
                        </div>
                
                        <div class="form-group">
                            @csrf
                            <button type="submit" name="submit" value="install" class="btn btn-secondary">Install <?= 'ok' ?></button>
                        </div>
                        <p class="step"></p>
                    </form>
                @endif
            @else
                <h1>Two more steps...</h1>
                <p>
                    It looks like you have already configured {{$site_title}}, but haven't installed it. 
                    We couldn't find some of the required information. We're going to guide you through the installation process. 
                    Installation will take only 1 to 2 minutes. If you're ready for the installation, let's proceed...
                </p>
                <p><a href="{{route('setup.install.show')}}" class="btn btn-secondary btn-sm">Proceed to installation</a></p>
            @endif
        @endif
    @endif
@endsection
