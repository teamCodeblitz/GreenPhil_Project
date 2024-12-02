<script lang="ts">
     import { onMount } from 'svelte';
     import { fade } from 'svelte/transition';
     import { CaretRightSolid, CaretLeftSolid} from 'flowbite-svelte-icons';
     
     interface Category {
       name: string;
       image: string;
     }
   
     interface Product {
       name: string;
       description: string;
       price: number;
       image: string;
     }
   
     const categories: Category[] = [
       { name: 'Short', image: 'assets/Shorts/bg-shorts.jpg' },
       { name: 'Shirts', image: 'assets/shirts/bg-shirts.jpg' },
       { name: 'Hats', image: 'assets/hats/bg-hats.jpg' }
     ];
   
     const products: Product[] = [
       {
         name: 'GP Ranger Hat',
         description: 'Inspired by dimpled hats',
         price: 380.00,
         image: 'assets/hats/item-6.jpg'
       },
       {
         name: 'GP Dri-fit short',
         description: 'A Dri-fit shorts',
         price: 250.00,
         image: 'assets/Shorts/item-1.jpg'
       },
       {
         name: 'GP BANDANA PAISLEY SHIRT',
         description: 'Dream paradise logo shirt',
         price: 650.00,
         image: 'assets/shirts/item-4.jpg'
       },
       {
         name: 'GP Beanie',
         description: 'A small, round, brimless hat',
         price: 300.00,
         image: 'assets/hats/item-2.jpg'
       },
       {
         name: 'GP Camp Chair',
         description: 'camp chair',
         price: 750.00,
         image: 'assets/chairs/item-1.jpg'
       },
       {
         name: 'GP Plain Stripe Tee',
         description: 'Stripe Shirt',
         price: 400.00,
         image: 'assets/shirts/item-5.jpg'
       },
       {
         name: 'GP Sling Bag',
         description: 'Compact one-strap bag',
         price: 450.00,
         image: 'assets/bags/item-1.jpg'
       },
       {
         name: 'GP Wave Shirt',
         description: 'A t-shirt with a wavy design',
         price: 650.00,
         image: 'assets/shirts/item-2.jpg'
       }
     ];
   
     let currentIndex = 0;
     let interval: ReturnType<typeof setInterval>;
   
     function nextSlide() {
       currentIndex = (currentIndex + 1) % products.length;
     }
   
     function prevSlide() {
       currentIndex = (currentIndex - 1 + products.length) % products.length;
     }
   
     onMount(() => {
       interval = setInterval(nextSlide, 5000);
       return () => clearInterval(interval);
     });
</script>
   


 <!-- Browse Section -->
 <section class="container mx-auto py-16">
     <h2 class="text-3xl font-bold text-center mb-12">BROWSE</h2>
     <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
       {#each categories as category}
         <div class="group relative cursor-pointer">
           <img src={category.image} alt={category.name} class="w-full h-80 object-cover rounded-lg">
           <h3 class="mt-4 text-xl font-semibold text-center">{category.name}</h3>
         </div>
       {/each}
     </div>
   </section>
 
   <!-- Products Section with Carousel -->
   <section class="max-w-[1400px] mx-auto py-16 px-4">
     <h2 class="text-4xl font-bold text-center mb-16">OUR PRODUCTS</h2>
     <div class="relative">
       <div class="overflow-hidden">
         <div class="flex transition-transform duration-500 ease-in-out" style="transform: translateX(-{currentIndex * 100}%)">
           {#each products as product, i}
             <div class="w-full flex-shrink-0 px-4">
               <div in:fade="{{ duration: 300 }}" out:fade="{{ duration: 300 }}" class="bg-gray-100 rounded-lg overflow-hidden">
                 <img src={product.image} alt={product.name} class="w-full h-64 object-cover">
               </div>
               <div class="mt-4">
                 <h3 class="text-lg font-semibold">{product.name}</h3>
                 <p class="text-gray-600 text-sm">{product.description}</p>
                 <p class="mt-2 font-bold">PHP {product.price.toFixed(2)}</p>
               </div>
             </div>
           {/each}
         </div>
       </div>
 <button 
   class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-[#2B4C1C] rounded-full p-2 shadow-lg hover:bg-white transition-colors"
   on:click={prevSlide}
   aria-label="Previous product"
   style="top: calc(50% - 22px);" 
 >
   <CaretLeftSolid />
 </button>
 <button 
   class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-[#2B4C1C] rounded-full p-2 shadow-lg hover:bg-white transition-colors"
   on:click={nextSlide}
   aria-label="Next product"
   style="top: calc(50% - 22px);"
 >
   <CaretRightSolid />
 </button>
     </div>
     <div class="flex justify-center mt-4">
       {#each products as _, i}
         <button 
           class="w-3 h-3 rounded-full mx-1 transition-colors duration-200 ease-in-out"
           class:bg-[#2B5522]={i === currentIndex}
           class:bg-gray-300={i !== currentIndex}
           on:click={() => currentIndex = i}
           aria-label="Go to product {i + 1}"
         ></button>
       {/each}
     </div>
   </section>
 
 <style>
   :global(body) {
     margin: 0;
     font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
   }
 </style>