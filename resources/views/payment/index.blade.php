<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Products</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 py-20">

    <header class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900">Our Amazing Products</h1>
        <p class="text-xl text-gray-600 mt-3">
            Click “Pay Now” to initiate a simulated payment through PayPal.
        </p>
    </header>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-8 max-w-2xl mx-auto text-center">
            <span class="block font-semibold">{{ session('error') }}</span>
        </div>
    @endif

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mx-auto max-w-6xl">
        @foreach($products as $id => $product)
            <div class="rounded-xl overflow-hidden shadow-2xl hover:shadow-indigo-300/50 hover:scale-[1.02] transition-all duration-300 bg-white border border-gray-200">
                
                <img class="w-full h-56 object-cover" 
                    src="{{ $product['image'] }}" 
                    alt="{{ $product['name'] }}"
                    onerror="this.onerror=null; this.src='https://placehold.co/600x400/818CF8/ffffff?text=Image+Unavailable';"
                >

                <div class="p-6 text-center">
                    <h3 class="text-2xl font-bold text-gray-800 truncate mb-1">{{ $product['name'] }}</h3>
                    <p class="text-3xl font-extrabold text-indigo-600 mt-2">${{ number_format($product['price'], 2) }}</p>

                    <div class="mt-6">
                        <a href="{{ route('payment.link', ['id' => $id]) }}" target="_blank"
                            class="inline-block w-full py-3 px-6 text-lg font-semibold text-white bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">
                            Pay Now
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </section>

</body>
</html>
