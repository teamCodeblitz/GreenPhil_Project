<script lang="ts">
  import { writable } from 'svelte/store';
  import { goto } from '$app/navigation';  // Import the goto function

  let viewMode: 'grid' | 'list' = 'grid';
  let itemsPerPage = 16;
  let sortBy = 'default';

  interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    image: string;
  }

  interface CartItem extends Product {
    quantity: number;
  }

  const products: Product[] = [
    {
      id: 1,
      name: 'GP Ranger Hat',
      description: 'Inspired by dimpled hats',
      price: 380.00,
      image: 'assets/hats/item-6.jpg'
    },
    {
      id: 2,
      name: 'GP Dri-fit short',
      description: 'A Dri-fit shorts',
      price: 250.00,
      image: 'assets/Shorts/item-1.jpg'
    },
    {
      id: 3,
      name: 'GP BANDANA PAISLEY SHIRT',
      description: 'Dream paradise logo shirt',
      price: 650.00,
      image: 'assets/shirts/item-4.jpg'
    },
    {
      id: 4,
      name: 'GP Beanie',
      description: 'A small, round, brimless hat',
      price: 300.00,
      image: 'assets/hats/item-2.jpg'
    },
    {
      id: 5,
      name: 'GP Camp Chair',
      description: 'camp chair',
      price: 750.00,
      image: 'assets/chairs/item-1.jpg'
    },
    {
      id: 6,
      name: 'GP Plain Stripe Tee',
      description: 'Stripe Shirt',
      price: 400.00,
      image: 'assets/shirts/item-5.jpg'
    },
    {
      id: 7,
      name: 'GP Sling Bag',
      description: 'Compact one-strap bag',
      price: 450.00,
      image: 'assets/bags/item-1.jpg'
    },
    {
      id: 8,
      name: 'GP Wave Shirt',
      description: 'A t-shirt with a wavy design',
      price: 650.00,
      image: 'assets/shirts/item-2.jpg'
    }
  ];

  const cart = writable<CartItem[]>([]);

  function addToCart(product: Product) {
    cart.update(items => {
      const existingItem = items.find(item => item.id === product.id);
      if (existingItem) {
        return items.map(item => 
          item.id === product.id 
            ? { ...item, quantity: item.quantity + 1 }
            : item
        );
      } else {
        return [...items, { ...product, quantity: 1 }];
      }
    });
    goto('/cart'); // Navigate to the cart page after adding the product
  }
</script>

<!-- Filter Bar -->
<div class="bg-[#FDF6F3] border-b">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <div class="flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <button class="flex items-center space-x-2">
          <!--<Filter size={20} />-->
          <span>Filter</span>
        </button>
        <div class="flex space-x-2">
          <button
            class="p-1 {viewMode === 'grid' ? 'text-gray-900' : 'text-gray-500'}"
            on:click={() => viewMode = 'grid'}
          >
           <!-- <Grid size={20} />-->
          </button>
          <button
            class="p-1 {viewMode === 'list' ? 'text-gray-900' : 'text-gray-500'}"
            on:click={() => viewMode = 'list'}
          >
            <!--<List size={20} />-->
          </button>
        </div>
        <span class="text-sm text-gray-500">Showing 1–{itemsPerPage} of {products.length} results</span>
      </div>
      <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-2">
          <span class="text-sm text-gray-500">Show</span>
          <select
            bind:value={itemsPerPage}
            class="rounded-md border-gray-300 py-1 text-sm"
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
          >
            <option value="default">Default</option>
            <option value="price-asc">Price: Low to High</option>
            <option value="price-desc">Price: High to Low</option>
            <option value="name">Name</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Product Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
    {#each products as product}
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
            on:click={() => addToCart(product)}
            class="w-full bg-[#2B5522] text-white py-2 px-4 rounded hover:bg-[#234419] transition"
          >
            Add to Cart
          </button>
        </div>
      </div>
    {/each}
  </div>
</div>

<style>
  /* Add custom styles for hover effects and transitions */
  .group {
    transition: all 0.3s ease;
  }
  
  .group:hover {
    transform: translateY(-4px);
  }
</style>