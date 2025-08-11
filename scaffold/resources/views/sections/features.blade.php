<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid md:grid-cols-3 gap-8">
            @foreach(data_get($section->content, 'items', []) as $item)
                <div class="p-6 bg-white rounded-xl border">
                    <div class="text-3xl mb-3">{{ data_get($item, 'icon', '✓') }}</div>
                    <div class="font-semibold mb-1">{{ data_get($item, 'title') }}</div>
                    <div class="text-slate-600">{{ data_get($item, 'text') }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>