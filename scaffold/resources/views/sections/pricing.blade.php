<section class="py-20">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-10">Pricing</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach(data_get($section->content, 'plans', []) as $plan)
                <div class="p-6 border rounded-xl">
                    <div class="font-semibold text-lg mb-2">{{ data_get($plan, 'name') }}</div>
                    <div class="text-4xl font-bold mb-4">
                        ${{ data_get($plan, 'price') }}<span class="text-base font-medium text-slate-500">/{{ data_get($plan, 'period', 'mo') }}</span>
                    </div>
                    <ul class="space-y-2 mb-6">
                        @foreach(data_get($plan, 'features', []) as $feat)
                            <li class="flex items-start gap-2"><span>✓</span><span>{{ $feat }}</span></li>
                        @endforeach
                    </ul>
                    <a href="/contact" class="block text-center px-4 py-2 rounded-md bg-sky-600 text-white hover:bg-sky-700">Choose</a>
                </div>
            @endforeach
        </div>
        @if(data_get($section->content, 'note'))
            <p class="text-center text-slate-500 text-sm mt-6">{{ data_get($section->content, 'note') }}</p>
        @endif
    </div>
</section>