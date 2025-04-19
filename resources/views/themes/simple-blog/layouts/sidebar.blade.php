<!-- Search widget-->
<div class="card mb-4">
    <div class="card-header">Cari Artikel</div>
    <div class="card-body">
        <form action="{{ route('search') }}" method="GET">
            <div class="input-group">
                <input class="form-control" type="text" name="q" placeholder="Search..." value="{{ request('q') }}">
                <button class="btn btn-primary" type="submit" title="Search">Cari
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Categories widget-->
<div class="card mb-4">
    <div class="card-header">Kategori Artikel</div>
    <div class="card-body">
        <div class="row">
            @foreach ($categoriesAll as $item)
            <div class="col-sm-6">
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('categories.show', $item->slug) }}">{{ $item->name }}</a></li>
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Side widget-->
<div class="card mb-4">
    <div class="card-header">Trending Post</div>
    @foreach ($trendingPosts as $post)
    <div class="post-item">
        <img src="{{ $post->image }}" alt="{{ $post->title }}" class="flex-shrink-0">
        <div>
            <h4><a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a></h4>
            <time datetime="{{ $post->created_at->format('Y-m-d') }}">{{ $post->created_at->format('M d, Y') }}</time>
        </div>
    </div><!-- End post item-->
    @endforeach
</div>