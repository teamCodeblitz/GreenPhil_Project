<!-- src/lib/Notification.svelte -->
<script lang="ts">
     import { onDestroy } from "svelte";
     export let message: string = "";
     export let visible: boolean = false;
 
     let timeout: ReturnType<typeof setTimeout>;
 
     $: if (visible) {
         timeout = setTimeout(() => {
             visible = false;
         }, 3000); // Notification will disappear after 3 seconds
     }
 
     onDestroy(() => {
         clearTimeout(timeout);
     });
 </script>
 
 <style>
     .notification {
         position: fixed;
         top: 20px;
         right: 20px;
         background-color: #4caf50; /* Green background */
         color: white;
         padding: 15px;
         border-radius: 5px;
         transition: opacity 0.5s ease;
         opacity: 0.9;
     }
 </style>
 
 {#if visible}
     <div class="notification">
         {message}
     </div>
 {/if}