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
                            <div class="blog-detail">Posted {{date('d F, Y', \strtotime($post->created_at))}}</div>
                            
                            <!-- blog image -->
                            <div class="blog-image">
                                <img src="{{\asset('assets/img/blog/blog1.jpg')}}" alt="" />
                            </div>  
                            
                            <!-- blog content -->
                            <div class="blog-content">{{($post->content)}}</div>

                        </div>
                    </div>
                </div>
                <div class="title" id="comments">{{$post_comments->total() > 0 ? \number_format($post_comments->total()) : ''}} 
                    Comment{{$post_comments->total() === 0 || $post_comments->total() > 1 ? 's' : ''}}
                </div>
                
                <!-- comments -->
                <div class="row border-line-v">
                    @if ($post_comments->count() < 1)
                        <div class="col col-m-12 col-t-12 col-d-12">
                            <div class="post-box">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        There are no comments for this post.
                                        Be the first to add a comment! 
                                        Use the comment form below.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col col-m-12 col-t-12 col-d-12">
                            <div class="post-box">
                                
                                <!-- comments items -->
                                <div class="col-md-12">
                                    <ul class="post-comments mb-0">
                                        @foreach ($post_comments as $comment)
                                            <li>
                                                <img src="{{\asset('assets/img/man1.jpg')}}" alt="">
                                                <div class="comment-info">
                                                    <div class="name">
                                                        <h6>
                                                            {{Str::title($comment->author)}}
                                                            <span>{{$comment->created_at->diffForHumans()}}</span>
                                                        </h6>
                                                        <a aria-expanded="false" aria-controls="comment{{$comment->id}}-reply-form" 
                                                            data-bs-toggle="collapse" href="#comment{{$comment->id}}-reply-form"
                                                        >Reply</a>
                                                    </div>
                                                    <p>{{ucfirst($comment->comment)}}</p>
                                                    <div id="comment{{$comment->id}}-reply-form" class="collapse">
                                                        <form method="post" class="pt-4">
                                                            <div class="h6 mb-2">Replying to <strong>{{Str::title($comment->author)}}</strong></div>
                                                            <div class="row m-0">
                                                                <div class="col-6 ps-0">
                                                                    <div class="group-val mb-3">
                                                                        <input type="text" name="name" placeholder="Full Name (Required)" required />
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 pe-0">
                                                                    <div class="group-val mb-3">
                                                                        <input type="url" name="website" placeholder="Website" required />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="group-val mb-3">
                                                                    <input type="email" name="email" placeholder="Email (Required, but never shared)" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="group-val mb-3">
                                                                    @csrf
                                                                    <textarea name="message" placeholder="Your Reply (Required)" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="align-left d-flex justify-content-between align-items-center">
                                                                <button class="button">
                                                                    <span class="text">Add Reply</span>
                                                                    <span class="arrow"></span>
                                                                </button>
                                                                <button class="px-2 py-1 small border-0" id="cancel" 
                                                                    type="button" data-bs-toggle="collapse" 
                                                                    data-bs-target="#comment{{$comment->id}}-reply-form"
                                                                >Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    
                                                    @if ($comment->replies->count() > 0)
                                                        <p>This comment has {{ucfirst($comment->replies->count())}} replies</p>
                                                        <ul class="list-unstyled mb-0 mt-3" id="comment{{$comment->id}}-replies">
                                                            <li >
                                                                <div>
                                                                    The form here...
                                                                    Reply box will be shown here
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                        <li class="mb-0 p-0"></li>
                                    </ul>
                                    {{$post_comments->onEachSide(2)->fragment('comments')->links()}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- title -->
                <div class="title" id="comment-form">Leave a Comment</div>
                
                <!-- comments -->
                <div class="row border-line-v">
                    <div class="col col-m-12 col-t-12 col-d-12">
                        <div class="post-box">
                            <form method="post" action="{{\route('post.comments.create', ['post_type' => $post->type, 'parent' => $post->category->slug, 'slug' => $post->slug])}}">
                                <div class="col-6 ps-0">
                                    <div class="group-val mb-3">
                                        <input type="text" name="name" placeholder="Full Name (Required)" required value="{{\old('name', '')}}" class="@error('name') is-invalid @enderror"/>
                                        @error('name')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 pe-0">
                                    <div class="group-val mb-3">
                                        <input type="url" name="website" placeholder="Website" value="{{\old('website', '')}}" class="@error('website') is-invalid @enderror" />
                                        @error('website')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-val mb-3">
                                        <input type="email" name="email" placeholder="Email (Required, but never shared)" required value="{{\old('email', '')}}" class="@error('email') is-invalid @enderror" />
                                        @error('email')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-val mb-3">
                                        @csrf
                                        <textarea name="comment" placeholder="Your Reply (Required)" required  class="@error('comment') is-invalid @enderror">{{\old('comment', '')}}</textarea>
                                        @error('comment')
                                            <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="align-left">
                                    <button class="button">
                                        <span class="text">Add Reply</span>
                                        <span class="arrow"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection