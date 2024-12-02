<script lang="ts">
    import { base } from '$app/paths';
    import { goto } from '$app/navigation';
    import { ShoppingBagSolid } from 'flowbite-svelte-icons';
    
    let currentPath = ''; // Initialize a variable to track the current path

    // Function to navigate and update currentPath
    const navigate = (path: string): void => {
        currentPath = path; // Update the current path
        goto(`${base}${path}`);
    }
</script>

<header class="h-15 bg-[#219c40d5] flex align-center justify-between">
    <!-- logo -->
    <div class="flex items-center gap-2.5 m-6">
        <h1 class="font-bold text-white text-2xl">GreenPhil</h1>
    </div>

    <!-- navigation -->
    <nav class="flex items-center gap-20 text-xl font-semibold text-white">
        <a 
            href="{base}/" 
            on:click|preventDefault={() => navigate('/')}
            class={`hover:underline ${currentPath === '/' ? 'underline' : ''}`}
        >Home</a>
        <a 
            href="{base}/shop" 
            on:click|preventDefault={() => navigate('/shop')}
            class={`hover:underline ${currentPath === '/shop' ? 'underline' : ''}`}
        >Shop</a>
        <a 
            href="{base}/contact" 
            on:click|preventDefault={() => navigate('/contact')}
            class={`hover:underline ${currentPath === '/contact' ? 'underline' : ''}`}
        >Contact</a>
    </nav>

    <div class="flex items-center space-x-1 text-medium font-semibold text-white m-7">
          <a 
            href="{base}/login" 
            on:click|preventDefault={() => navigate('/login')}
            class={`hover:underline ${currentPath === '/login' ? 'underline' : ''}`}
        >Log in</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
            <path fill="currentColor" fill-rule="evenodd" d="M10 1a1 1 0 0 1 1 1v16a1 1 0 1 1-2 0V2a1 1 0 0 1 1-1" clip-rule="evenodd" />
        </svg>
        <button on:click={() => navigate('/cart')} class="flex items-center hover:underline">
            <ShoppingBagSolid class="w-5 h-5 mr-1" />
        </button>
    </div>
</header>