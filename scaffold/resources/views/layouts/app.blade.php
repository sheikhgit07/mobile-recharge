<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->meta_title ?? $page->title ?? 'Nexitel' }}</title>
    @if(!empty($page->meta_description))
        <meta name="description" content="{{ $page->meta_description }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-white text-slate-800">
    <header class="border-b">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="font-semibold text-xl">Nexitel</a>
            <nav class="hidden md:block">
                <ul class="flex items-center gap-6">
                    @foreach(($headerMenu->items ?? []) as $item)
                        <li><a href="{{ $item->url ?? ($item->page?->slug ? url($item->page->slug) : '#') }}" class="hover:text-sky-600">{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="border-t">
        <div class="max-w-7xl mx-auto px-4 py-10 grid md:grid-cols-2 gap-6">
            <div>
                <div class="font-semibold text-lg mb-2">Nexitel</div>
                <p class="text-sm text-slate-600">Fast, reliable connectivity solutions.</p>
            </div>
            <div>
                <ul class="flex flex-wrap gap-4 justify-end">
                    @foreach(($footerMenu->items ?? []) as $item)
                        <li><a href="{{ $item->url ?? ($item->page?->slug ? url($item->page->slug) : '#') }}" class="text-sm hover:text-sky-600">{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="text-center text-xs text-slate-500 pb-6">© {{ date('Y') }} Nexitel. All rights reserved.</div>
    </footer>
</body>
</html>