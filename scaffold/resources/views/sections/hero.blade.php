<section class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 py-24 grid md:grid-cols-2 gap-10 items-center">
        <div>
            @if(data_get($section->content, 'eyebrow'))
                <div class="text-sky-600 font-semibold mb-2">{{ data_get($section->content, 'eyebrow') }}</div>
            @endif
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">{{ data_get($section->content, 'title') }}</h1>
            <p class="text-lg text-slate-600 mb-6">{{ data_get($section->content, 'subtitle') }}</p>
            <div class="flex gap-3">
                @if(data_get($section->content, 'primary_cta.url'))
                    <a href="{{ data_get($section->content, 'primary_cta.url') }}" class="px-5 py-3 rounded-md bg-sky-600 text-white hover:bg-sky-700">{{ data_get($section->content, 'primary_cta.label', 'Get Started') }}</a>
                @endif
                @if(data_get($section->content, 'secondary_cta.url'))
                    <a href="{{ data_get($section->content, 'secondary_cta.url') }}" class="px-5 py-3 rounded-md border border-slate-300 hover:bg-slate-50">{{ data_get($section->content, 'secondary_cta.label', 'Learn More') }}</a>
                @endif
            </div>
        </div>
        <div class="hidden md:block">
            @if(data_get($section->content, 'image'))
                <img src="{{ data_get($section->content, 'image') }}" alt="" class="w-full rounded-xl shadow" />
            @else
                <div class="w-full h-64 bg-gradient-to-br from-sky-50 to-sky-100 rounded-xl border"></div>
            @endif
        </div>
    </div>
</section>