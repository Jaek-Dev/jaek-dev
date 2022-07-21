@php
/**
 * @project         Portfolio
 * @author          Jacob Eke <jaek.dev@gmail.com>
 * @author_uri      https://jaek.dev
 * @copyright       protected
 * @version         1.0.1
 * 
 * ------------------------------------------------
 * The Blog Index Page
 * ------------------------------------------------
 */    
// dd($post->comments);
@endphp

@extends('layouts.app')

@section('content')
    <div class="card-inner blog blog-post animated" id="blog-card">
        <div class="card-wrap">
            <div class="content blog-single">
                <div class="row border-line-v">
                    <div class="col col-m-12 col-t-12 col-d-12">
                        <div class="post-box">
                            <h1>{{\ucfirst($post->title)}}</h1>						
                            <div class="blog-detail">Posted 12 June 2016</div>
                            
                            <!-- blog image -->
                            <div class="blog-image">
                                <img src="{{\asset('assets/img/blog/blog1.jpg')}}" alt="" />
                            </div>  
                            
                            <!-- blog content -->
                            <div class="blog-content">{{($post->content)}}</div>

                        </div>
                    </div>
                </div>
                
                <!-- title -->
                <div class="title">Comments</div>
                
                <!-- comments -->
                <div class="row border-line-v">
                    <div class="col col-m-12 col-t-12 col-d-12">
                        <div class="post-box">
                            
                            <!-- comments items -->
                            <div class="col-md-12">
                                <ul class="post-comments">
                                    
                                    <!-- comment item -->
                                    <li>
                                        <img src="{{\asset('assets/img/man1.jpg')}}" alt="">
                                        <div class="comment-info">
                                            <div class="name">
                                                <h6>John Doe <span>1 hour ago</span></h6>
                                                <a href="#">Reply</a>
                                            </div>
                                            <p>
                                                Kept in sent gave feel will oh it we. Has pleasure procured men 
                                                laughing shutters nay.
                                            </p>
                                        </div>
                                    </li>
                                    
                                    <!-- comment item -->
                                    <li>
                                        <img src="{{\asset('assets/img/man1.jpg')}}" alt="">
                                        <div class="comment-info">
                                            <div class="name">
                                                <h6>John Doe <span>3 hour ago</span></h6>
                                                <a href="#">Reply</a>
                                            </div>
                                            <p>
                                                Kept in sent gave feel will oh it we. Has pleasure procured men 
                                                laughing shutters nay.
                                            </p>
                                        </div>
                                    </li>
                                    
                                    <!-- comment item -->
                                    <li>
                                        <img src="{{\asset('assets/img/man1.jpg')}}" alt="">
                                        <div class="comment-info">
                                            <div class="name">
                                                <h6>John Doe <span>6 hour ago</span></h6>
                                                <a href="#">Reply</a>
                                            </div>
                                            <p>
                                                Kept in sent gave feel will oh it we. Has pleasure procured men 
                                                laughing shutters nay.
                                            </p>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
                
                <!-- title -->
                <div class="title">Leave a Comment</div>
                
                <!-- comments -->
                <div class="row border-line-v">
                    <div class="col col-m-12 col-t-12 col-d-12">
                        <div class="post-box">
                            
                            <!-- comment form -->
                            <form id="cform" method="post">
                                <div class="row">
                                    <div class="col col-d-12 col-t-12 col-m-12">
                                        <div class="group-val">
                                            <input type="text" name="name" placeholder="Full Name" />
                                        </div>
                                    </div>
                                    <div class="col col-d-12 col-t-12 col-m-12">
                                        <div class="group-val">
                                            <textarea name="message" placeholder="Your Message"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-left">
                                    <a href="#" class="button" onclick="$('#cform').submit(); return false;">
                                        <span class="text">Add Comment</span>
                                        <span class="arrow"></span>
                                    </a>
                                </div>
                            </form>
                            <div class="alert-success">
                                <p>Thanks, your message is sent successfully.</p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection