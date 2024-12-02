<script>
    import { base } from '$app/paths';
    import { goto } from '$app/navigation';

    // Simulated user authentication state
    let isLoggedIn = false; // Replace this with real authentication logic

    const handleShopNow = () => {
        if (isLoggedIn) {
            goto(`${base}/shop`);
        } else {
            goto(`${base}/sign-in`);
        }
    };
</script>

<div class="relative h-[500px] bg-cover bg-center" style="background-image: url('assets/hero-bg/bg-1.jpg')">
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="absolute top-1/2 right-20 transform -translate-y-1/2 bg-green-500/75 p-8 rounded-lg max-w-md border border-black">
        <p class="text-sm text-black uppercase">New Arrival</p>
        <h1 class="text-4xl font-bold text-green-950 mt-2">Discover and find your style!</h1>
        <div class="flex mt-6 left-10">
            <button 
                class="bg-[#34A853] border border-black text-white px-8 py-3 rounded-md hover:bg-black/30 transition"
                on:click={handleShopNow}
            >
                {isLoggedIn ? 'SHOP NOW' : 'SIGN IN'}
            </button>
        </div>
    </div>
</div>
