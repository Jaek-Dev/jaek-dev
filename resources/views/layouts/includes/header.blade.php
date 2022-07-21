@php
/**
 * @project         Portfolio
 * @author          Jacob Eke <jaek.dev@gmail.com>
 * @author_uri      https://jaek.dev
 * @copyright       protected
 * @version         1.0.1
 * 
 * ------------------------------------------------
 * The Header
 * ------------------------------------------------
 */    
@endphp

@include('layouts.includes.head')

<header class="header">
    <div class="top-menu">
        <ul>
            @if(\request()->is('blog*'))
                <li>
                    <a href="{{\route('home')}}">
                        <span class="icon ion-home"></span>
                        <span class="link">Home</span>
                    </a>
                </li>
                <li class="active">
                    <a href="{{\route('blog.index')}}">
                        <span class="icon ion-chatbox-working"></span>
                        <span class="link">Blog</span>
                    </a>
                </li>
            @else
                <li class="active">
                    <a href="#about-card">
                        <span class="icon ion-person"></span>
                        <span class="link">About</span>
                    </a>
                </li>
                <li>
                    <a href="#resume-card">
                        <span class="icon ion-android-list"></span>
                        <span class="link">Resume</span>
                    </a>
                </li>
                <li>
                    <a href="#works-card">
                        <span class="icon ion-paintbrush"></span>
                        <span class="link">Works</span>
                    </a>
                </li>
                <li>
                    <a href="#blog-card">
                        <span class="icon ion-chatbox-working"></span>
                        <span class="link">Blog</span>
                    </a>
                </li>
                <li>
                    <a href="#contacts-card">
                        <span class="icon ion-at"></span>
                        <span class="link">Contact</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</header>

<div class="card-started" id="home-card">
    <div class="profile">
        <div class="slide" style="background-image: url({{\asset('assets/img/bg.jpg')}});"></div>
        <div class="image">
            <img src="{{\asset('assets/img/profile.jpg')}}" alt="" style="height: 10rem; width: 10rem;"/>
        </div>

        <div class="title">Jacob Eke</div>
        <div class="subtitle">Web Developer</div>

        <div class="social">
            <a target="_blank" href="../../../external.html?link=https://dribbble.com/"><span class="fab fa-dribbble"></span></a>
            <a target="_blank" href="../../../external.html?link=https://twitter.com/"><span class="fab fa-twitter"></span></a>
            <a target="_blank" href="../../../external.html?link=https://github.com/"><span class="fab fa-github"></span></a>
            <a target="_blank" href="../../../external.html?link=https://www.spotify.com/"><span class="fab fa-spotify"></span></a>
            <a target="_blank" href="../../../external.html?link=https://stackoverflow.com/"><span class="fab fa-stack-overflow"></span></a>
        </div>
        
        <div class="lnks">
            <a href="#" class="lnk">
                <span class="text">Download CV</span>
                <span class="ion ion-archive"></span>
            </a>
            <a href="#" class="lnk discover">
                <span class="text">Contact Me</span>
                <span class="arrow"></span>
            </a>
        </div>
    </div>
</div>

