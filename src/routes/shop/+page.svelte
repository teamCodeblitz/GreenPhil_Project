<script lang="ts">
    import { writable } from 'svelte/store';
    import { addToCart } from '$lib/cartStore';
    import Notification from '$lib/components/Notification.svelte';

    let viewMode: 'grid' | 'list' = 'grid';
    let itemsPerPage = 16;
    let sortBy = 'default';
    let filterCategory = 'all';

    interface Product {
        id: number;
        name: string;
        description: string;
        price: number;
        image: string;
        category: string;
    }

    const products: Product[] = [
        { id: 1, name: 'GP Ranger Hat', description: 'Inspired by dimpled hats', price: 380.00, image: 'assets/hats/item-6.jpg', category: 'hats' },
        { id: 2, name: 'GP Dri-fit short', description: 'A Dri-fit shorts', price: 250.00, image: 'assets/Shorts/item-1.jpg', category: 'shorts' },
        { id: 3, name: 'GP BANDANA PAISLEY SHIRT', description: 'Dream paradise logo shirt', price: 650.00, image: 'assets/shirts/item-4.jpg', category: 'shirts' },
        { id: 4, name: 'GP Beanie', description: 'A small, round, brimless hat', price: 300.00, image: 'assets/hats/item-2.jpg', category: 'hats' },
        { id: 5, name: 'GP Camp Chair', description: 'camp chair', price: 750.00, image: 'assets/chairs/item-1.jpg', category: 'chairs' },
        { id: 6, name: 'GP Plain Stripe Tee', description: 'Stripe Shirt', price: 400.00, image: 'assets/shirts/item-5.jpg', category: 'shirts' },
        { id: 7, name: 'GP Sling Bag', description: 'Compact one-strap bag', price: 450.00, image: 'assets/bags/item-1.jpg', category: 'bags' },
        { id: 8, name: 'GP Wave Shirt', description: 'A t-shirt with a wavy design', price: 650.00, image: 'assets/shirts/item-2.jpg', category: 'shirts' }
    ];

    let notificationVisible = false;
    let notificationMessage = "";

    const showNotification = (message: string) => {
        notificationMessage = message;
        notificationVisible = true;

        setTimeout(() => {
            notificationVisible = false;
        }, 3000);
    };

    const filteredProducts = () => {
    // Filter products based on category
    const filtered = products.filter(product => {
        return filterCategory === 'all' || product.category === filterCategory;
    });

    // Sort products based on the selected sorting option
    if (sortBy === 'price-asc') {
        return filtered.sort((a, b) => a.price - b.price);
    } else if (sortBy === 'price-desc') {
        return filtered.sort((a, b) => b.price - a.price);
    } else if (sortBy === 'name') {
        return filtered.sort((a, b) => a.name.localeCompare(b.name));
    }

    // Default return (no specific sorting)
    return filtered;
};
</script>

<Notification message={notificationMessage} visible={notificationVisible} />

<div class="bg-[#FDF6F3] border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button class="flex items-center space-x-2" aria-label="Filter options">
                    <span>Filter</span>
                </button>
                <div class="flex space-x-2">
                    <button
                        class="p-1 {viewMode === 'grid' ? 'text-gray-900' : 'text-gray-500'}"
                        on:click={() => viewMode = 'grid'}
                        aria-label="Switch to grid view"
                    >
                        <!-- Add an icon here if needed -->
                    </button>
                    <button
                        class="p-1 {viewMode === 'list' ? 'text-gray-900' : 'text-gray-500'}"
                        on:click={() => viewMode = 'list'}
                        aria-label="Switch to list view"
                    >
                        <!-- Add an icon here if needed -->
                    </button>
                </div>
                <span class="text-sm text-gray-500">Showing 1–{itemsPerPage} of {filteredProducts().length} results</span>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Show</span>
                    <select
                        bind:value={itemsPerPage}
                        class="rounded-md border-gray-300 py-1 text-sm"
                        aria-label="Select number of items to show"
                    >
                        <option value={16}>16</option>
                        <option value={32}>32</option>
                        <option value={48}>48</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Sort by</span>
                    <select
                        bind:value={sortBy}
                        class="rounded-md border-gray-300 py-1 text-sm"
                        aria-label="Select sorting order"
                    >
                        <option value="default">Default</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                        <option value="name">Name</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Category</span>
                    <select
                        bind:value={filterCategory}
                        class="rounded-md border-gray-300 py-1 text-sm"
                        aria-label="Select product category"
                    >
                        <option value="all">All</option>
                        <option value="hats">Hats</option>
                        <option value="shirts">Shirts</option>
                        <option value="shorts">Shorts</option>
                        <option value="bags">Bags</option>
                        <option value="chairs">Chairs</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        {#each filteredProducts() as product}
            <div class="group">
                <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden">
                    <img
                        src={product.image}
                        alt={product.name}
                        class="w-full h-full object-center object-cover group-hover:opacity-75"
                    />
                </div>
                <div class="mt-4 space-y-2">
                    <h3 class="text-lg font-medium text-gray-900">
                        {product.name}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {product.description}
                    </p>
                    <p class="text-lg font-medium text-gray-900">
                        PHP {product.price.toFixed(2)}
                    </p>
                    <button
                        on:click={() => {
                            addToCart({ ...product, quantity: 1 });
                            showNotification(`${product.name} has been added to your cart!`);
                        }}
                        class="w-full bg-[#2B5522] text-white py-2 px-4 rounded hover:bg-[#234419] transition"
                        aria-label={`Add ${product.name} to cart`}
                    >
                        Add to Cart
                    </button>
                </div>
            </div>
        {/each}
    </div>
</div>