<section class="py-16 bg-slate-50">
    <div class="max-w-5xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-6">
            @foreach(data_get($section->content, 'items', []) as $item)
                <figure class="p-6 bg-white border rounded-xl">
                    <blockquote class="text-lg mb-3">“{{ data_get($item, 'quote') }}”</blockquote>
                    <figcaption class="text-sm text-slate-600">— {{ data_get($item, 'author') }}</figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>