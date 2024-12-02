<script lang="ts">
    import { cartStore, updateQuantity, removeFromCart } from '$lib/cartStore'; 
    import type { CartItem } from '$lib/cartStore'; // Use type-only import for CartItem
    import { onDestroy } from 'svelte';

    let cartItems: CartItem[] = [];
    
    const unsubscribe = cartStore.subscribe(items => {
        cartItems = items;
    });

    onDestroy(() => {
        unsubscribe();
    });

    $: subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    $: total = subtotal; // Add shipping or tax calculations here if needed
</script>

<!-- Cart Content -->
<main class="max-w-7xl mx-auto py-8 px-4">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items -->
        <div class="flex-grow">
            <div class="bg-[#FDF5EC] rounded-lg overflow-hidden">
                <div class="grid grid-cols-4 gap-4 p-4 border-b border-gray-200">
                    <div class="font-medium">Product</div>
                    <div class="font-medium">Price</div>
                    <div class="font-medium">Quantity</div>
                    <div class="font-medium">Subtotal</div>
                </div>
                
                {#each cartItems as item (item.id)}
                    <div class="grid grid-cols-4 gap-4 p-4 items-center">
                        <div class="flex items-center gap-4">
                            <img 
                                src={item.image} 
                                alt={item.name}
                                class="w-20 h-20 object-cover rounded"
                            />
                            <span>{item.name}</span>
                        </div>
                        <div>PHP {item.price.toFixed(2)}</div>
                        <div class="flex items-center gap-2">
                            <input
                                type="number"
                                min="1"
                                bind:value={item.quantity}
                                on:change={() => updateQuantity(item.id, item.quantity)}
                                class="w-16 px-2 py-1 border rounded"
                            />
                            <button 
                                on:click={() => removeFromCart(item.id)}
                                class="text-red-500 hover:text-red-700"
                            >
                                Remove
                            </button>
                        </div>
                        <div>PHP {(item.price * item.quantity).toFixed(2)}</div>
                    </div>
                {/each}
            </div>
        </div>

        <!-- Cart Totals -->
        <div class="w-full lg:w-80">
            <div class="bg-[#FDF5EC] p-6 rounded-lg">
                <h2 class="text-xl font-bold mb-4">Cart Totals</h2>
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>PHP {subtotal.toFixed(2)}</span>
                    </div>
                    <div class="flex justify-between font-bold">
                        <span>Total</span>
                        <span>PHP {total.toFixed(2)}</span>
                    </div>
                </div>
                <button 
                    class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition"
                >
                    Check Out
                </button>
            </div>
        </div>
    </div>
</main>