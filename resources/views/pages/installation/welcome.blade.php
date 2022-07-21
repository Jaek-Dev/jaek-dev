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

// var_dump(file(base_path('.env')));
@endphp

@extends('layouts.installation.app')
@section('content')
<p>
    Welcome to {{$site_title}}. Before getting started, we need some information on the database. 
    You will need to know the following items before proceeding.
</p>
<ol class="pl-2">
    <li>Database name</li>
    <li>Database username</li>
    <li>Database password</li>
    <li>Database host</li>
    <li>Table prefix (if you want to run more than one {{$site_title}} in a single database)</li>
</ol>
<p>
    <strong>
        If for any reason this automatic file creation doesn&#8217;t work, 
        don&#8217;t worry. All this does is fill in the database information 
        to a <code>.env</code> file. You may also simply open <code>.env-example</code> 
        from the <code>root</code> folder in a text editor, fill in your information, 
        and save it as <code>.env</code>
    </strong>
</p>
<p>
    In all likelihood, these items were supplied to you by your Web Host. 
    If you do not have this information, then you will need to contact them 
    before you can continue. If you&#8217;re all ready&hellip;
</p>
<p class="step"><a href="{{route('setup.configure.show')}}" class="btn btn-sm btn-secondary">Let&#8217;s go!</a></p>
@endsection