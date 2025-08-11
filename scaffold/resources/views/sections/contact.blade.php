<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 grid md:grid-cols-2 gap-10">
        <div>
            <h2 class="text-3xl font-bold mb-3">{{ data_get($section->content, 'title', 'Contact Us') }}</h2>
            <p class="text-slate-600 mb-6">{{ data_get($section->content, 'subtitle', 'We would love to hear from you.') }}</p>
            <ul class="space-y-2">
                @if(data_get($section->content, 'email'))
                    <li>Email: <a class="text-sky-600" href="mailto:{{ data_get($section->content, 'email') }}">{{ data_get($section->content, 'email') }}</a></li>
                @endif
                @if(data_get($section->content, 'phone'))
                    <li>Phone: <a class="text-sky-600" href="tel:{{ data_get($section->content, 'phone') }}">{{ data_get($section->content, 'phone') }}</a></li>
                @endif
                @if(data_get($section->content, 'address'))
                    <li>Address: {{ data_get($section->content, 'address') }}</li>
                @endif
            </ul>
        </div>
        <div class="p-6 border rounded-xl">
            <form action="{{ route('contact.store') }}" method="post">
                @csrf
                <div class="grid gap-4">
                    <input name="name" type="text" placeholder="Name" class="border rounded-md p-3 w-full" required />
                    <input name="email" type="email" placeholder="Email" class="border rounded-md p-3 w-full" required />
                    <textarea name="body" placeholder="Message" class="border rounded-md p-3 w-full" rows="4" required></textarea>
                    <button class="px-4 py-3 rounded-md bg-sky-600 text-white">Send</button>
                    @if(session('status'))
                        <div class="text-sm text-green-600">{{ session('status') }}</div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>