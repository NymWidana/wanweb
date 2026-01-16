<x-app-layout>
    <div class="py-20 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-6">
            <div class="mb-12 border-b dark:border-gray-800 pb-8">
                <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-4">Terms of Service</h1>
                <p class="text-gray-500">Last Updated: {{ date('F d, Y') }}</p>
            </div>

            <div class="prose prose-indigo dark:prose-invert max-w-none space-y-8 text-gray-600 dark:text-gray-400">

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">1. Acceptance of Terms</h2>
                    <p>By accessing and using WANWEB, you agree to be bound by these Terms of Service. If you do not agree to these terms, please do not use our services.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">2. Service Delivery</h2>
                    <p>WANWEB provides digital web templates and custom development services. Delivery is considered complete when a functional "Delivery Link" is provided via the User Dashboard. Timeline for delivery varies by project type:</p>
                    <ul class="list-disc ml-6 mt-2">
                        <li><strong>Templates:</strong> 2-3 business days.</li>
                        <li><strong>Custom Builds:</strong> 7-14 business days.</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">3. Payment & Refunds</h2>
                    <p>All prices listed are in USD. Due to the digital nature of our products, refunds are only issued if a project has not yet reached the "Processing" stage. Once work has begun, all sales are final.</p>
                </section>

                <section>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">4. Intellectual Property</h2>
                    <p>Upon final delivery and full payment, the client owns the rights to the specific instance of the website delivered. WANWEB retains the rights to any underlying proprietary templates or code structures used.</p>
                </section>

                <div class="bg-indigo-50 dark:bg-indigo-900/20 p-6 rounded-2xl border border-indigo-100 dark:border-indigo-800 text-sm italic">
                    Note: These terms are for demonstration purposes as part of the WANWEB project build and do not constitute legal advice.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
