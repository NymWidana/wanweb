<x-app-layout>
    <header class="relative py-32 px-6 text-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('hero-bg.jpg') }}"
                alt="Background"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gray-900/70 dark:bg-gray-950/80 transition-colors"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight">
                Premium Web Solutions for <span class="text-indigo-400">Your Business.</span>
            </h1>
            <p class="text-lg text-gray-300 mb-10 leading-relaxed max-w-2xl mx-auto">
                From custom portfolio designs to full-scale e-commerce systems. Choose a template or request a custom build today.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#services" class="bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl shadow-indigo-900/20 hover:scale-105 hover:bg-indigo-500 transition-all">View Services</a>
                <a href="{{ route('register') }}" class="bg-white/10 backdrop-blur-md text-white border border-white/20 px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/20 transition">Join Now</a>
            </div>
        </div>
    </header>

    <section id="services" class="py-20 bg-white dark:bg-gray-800/50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Our Services</h2>
                    <p class="text-gray-500">Transparent pricing for every project.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $landingTemplates = \App\Models\Template::latest()->take(6)->get();
                @endphp

                @foreach($landingTemplates as $template)
                <div class="group p-8 rounded-3xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900 hover:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-xl">
                    <div class="flex justify-between items-start mb-6">
                        <span class="uppercase text-[10px] font-black tracking-widest text-indigo-500 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded">
                            {{ $template->type }}
                        </span>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($template->price, 0) }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $template->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-6 line-clamp-3">
                        {{ $template->description }}
                    </p>
                    <a href="{{ route('register') }}" class="w-full block text-center py-3 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white font-bold group-hover:bg-indigo-600 group-hover:text-white transition">
                        Order Now
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
