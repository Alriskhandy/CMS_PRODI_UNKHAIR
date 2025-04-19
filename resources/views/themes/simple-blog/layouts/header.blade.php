<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <img src="{{ asset('storage/' . $site_logo->value) }}" alt="">
        <a class="navbar-brand" href="/">{{ $site_name->value }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>

                @foreach ($menus as $menu)
                    @foreach ($menu->items as $item)
                        @if ($item->children->isNotEmpty())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#"
                                   id="navbarDropdown{{ $item->id }}" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $item->label }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $item->id }}">
                                    @foreach ($item->children as $child)
                                        <li>
                                            <a class="dropdown-item" href="{{ $child->page
                                                ? route('pages.show', $child->page->slug)
                                                : ($child->post
                                                    ? route('posts.show', $child->post->slug)
                                                    : ($child->category
                                                        ? route('categories.show', $child->category->slug)
                                                        : $child->url)) }}">
                                                {{ $child->label }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $item->page
                                    ? route('pages.show', $item->page->slug)
                                    : ($item->post
                                        ? route('posts.show', $item->post->slug)
                                        : ($item->category
                                            ? route('categories.show', $item->category->slug)
                                            : $item->url)) }}">
                                    {{ $item->label }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endforeach

                <li class="nav-item"><a class="nav-link" href="{{ route('galleries.front') }}">Galeri</a></li>
            </ul>
        </div>
    </div>
</nav>
