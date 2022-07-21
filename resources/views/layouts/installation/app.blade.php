@php
/**
 * @project         Portfolio
 * @author          Jacob Eke <jaek.dev@gmail.com>
 * @author_uri      https://jaek.dev
 * @copyright       protected
 * @version         1.0.1
 * 
 * ------------------------------------------------
 * The Installation Layout
 * ------------------------------------------------
 */    
@endphp

@include('layouts.installation.includes.header')

<div style="margin-top: 25px; margin-bottom: 25px; text-align: center">
    <img src="http://cdn.localhost.com/cms/content/static/images/brand/logo-dark.png" alt="{{config('app.name', 'E-commerce')}}">
</div>

@yield('content')

@include('layouts.installation.includes.footer')