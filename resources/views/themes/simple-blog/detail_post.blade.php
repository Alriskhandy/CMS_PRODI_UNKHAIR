@extends('themes.simple-blog.layouts.main')

@push('head')
<!-- SEO Meta Tags -->
<meta name="title" content="{{ $page->title }}">
<meta name="description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
<meta name="keywords" content="{{ implode(',', $page->tags ?? ['blog', 'post']) }}">
<meta name="author" content="{{ $page->author ?? 'Admin' }}">
<meta name="robots" content="index, follow">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $page->title }}">
<meta property="og:description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
<meta property="og:image" content="{{ $page->image }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="Your Website Name">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $page->title }}">
<meta name="twitter:description" content="{{ Str::limit(strip_tags($page->content), 160) }}">
<meta name="twitter:image" content="{{ $page->image }}">
@endpush

@push('styles')
<style>
    .page-title a {
        color: #333 !important;
        text-decoration: none !important;
    }

    .page-title a:hover {
        color: #000 !important;
        text-decoration: underline;
    }
</style>
@endpush

@section('main')

<!-- Page Title -->
<div class="page-title py-4">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="my-2 my-lg-0">{{ $page->title }}</h1>
        <nav class="breadcrumbs" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $page->title }}
                </li>
            </ol>
        </nav>
    </div>
</div>
<!-- End Page Title -->

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <section id="blog-details" class="blog-details section mb-5">
                <article class="article">
                    @if($page->image)
                    <img src="{{ $page->image }}" alt="{{ $page->title }}" class="img-fluid mb-4">
                    @endif

                    <div class="content">
                        {!! $page->content !!}
                    </div>

                    <!-- Share Buttons -->
                    <div class="share-buttons mt-4">
                        <span>Share:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('posts.show', $page->slug) }}"
                            target="_blank" aria-label="Share on Facebook">
                            <img src="{{ asset('assets/facebook.svg') }}" alt="Facebook" width="40">
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ route('posts.show', $page->slug) }}"
                            target="_blank" aria-label="Share on Twitter">
                            <img src="{{ asset('assets/x.svg') }}" alt="Twitter" width="40">
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ route('posts.show', $page->slug) }}"
                            target="_blank" aria-label="Share on WhatsApp">
                            <img src="{{ asset('assets/whatsapp.svg') }}" alt="WhatsApp" width="30">
                        </a>
                        <a href="https://www.instagram.com" target="_blank" aria-label="Visit Instagram">
                            <img src="{{ asset('assets/instagram.svg') }}" alt="Instagram" width="30">
                        </a>
                    </div>
                </article>

                @if ($page->comments_is_active)
                <!-- Comments Section -->
                <section id="comments" class="comments section mt-5">
                    <h3 class="mb-4">Comments ({{ $comments->count() }})</h3>

                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Comment List -->
                    <ul class="list-unstyled">
                        @foreach ($comments as $comment)
                        <li class="mb-4 border-bottom pb-3">
                            <div class="comment">
                                <strong>{{ $comment->name }}</strong>
                                <span class="text-muted d-block small">
                                    {{ $comment->created_at->format('F d, Y h:i A') }}
                                </span>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <!-- Comment Form -->
                    <h4 class="mt-5">Leave a Comment</h4>
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $page->id }}">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Your Name"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Your Email"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Comment</label>
                            <textarea name="content" id="content" class="form-control" rows="4"
                                placeholder="Write your comment here..." required></textarea>
                        </div>

                        <div class="mb-3">
                            {!! ReCaptcha::htmlScriptTagJsApi() !!}
                            {!! ReCaptcha::htmlFormSnippet() !!}
                            @error('g-recaptcha-response')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-outline-warning mt-2">Kirim</button>
                    </form>
                </section>
                @endif
            </section>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            @include('themes.simple-blog.layouts.sidebar')
        </div>
    </div>
</div>
@endsection