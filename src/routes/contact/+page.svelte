<script lang="ts"> 
     let formData = {
       name: '',
       email: '',
       message: ''
     }
   
     const handleSubmit = (event: Event) => { // Explicitly type the event parameter
       event.preventDefault()
       // Handle form submission logic here
       console.log('Form submitted:', formData)
     }
   </script>
   
   <div class="bg-gray-50 min-h-screen">
     <div class="max-w-3xl mx-auto px-4 py-12">
       <h1 class="text-5xl font-medium text-green-600 mb-2">Get in touch</h1>
       <div class="h-0.5 w-72 bg-green-600 mb-8"></div>
       
       <div class="mb-12">
         <h2 class="text-2xl font-medium text-gray-900 mb-2">Send a Message</h2>
         <p class="text-gray-600 italic mb-6">
           We're here to help! Reach out to us with any questions, comments, or feedback. Your thoughts matter.
         </p>
         
         <form on:submit={handleSubmit} class="space-y-6">
           <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             <div>
               <label for="name" class="block text-lg font-medium text-gray-900 mb-2">Name</label>
               <input
                 type="text"
                 id="name"
                 bind:value={formData.name}
                 class="w-full px-3 py-2 border-b border-gray-300 focus:border-green-600 focus:outline-none bg-transparent"
                 placeholder="Your Name"
               />
             </div>
             
             <div>
               <label for="email" class="block text-lg font-medium text-gray-900 mb-2">Email Address</label>
               <input
                 type="email"
                 id="email"
                 bind:value={formData.email}
                 class="w-full px-3 py-2 border-b border-gray-300 focus:border-green-600 focus:outline-none bg-transparent"
                 placeholder="Your Email"
               />
             </div>
           </div>
           
           <div>
             <label for="message" class="block text-lg font-medium text-gray-900 mb-2">Message</label>
             <textarea
               id="message"
               bind:value={formData.message}
               rows="4"
               class="w-full px-3 py-2 border-b border-gray-300 focus:border-green-600 focus:outline-none bg-transparent resize-none"
               placeholder="Your Message"
             ></textarea>
           </div>
           
           <div class="flex justify-end">
             <button
               type="submit"
               class="px-6 py-3 bg-green-600 font-medium rounded-md hover:bg-green-700 transition-colors flex items-center gap-2"
             >
               Submit
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                 <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
               </svg>
             </button>
           </div>
         </form>
       </div>
       
       <div>
         <h2 class="text-xl font-medium text-gray-900 mb-4">Visit Us</h2>
         <p class="text-gray-600 italic mb-2">Location Del pilar Castillejos Zambales</p>
         <p class="text-gray-600 italic mb-4">Near Mc donalds and Uno fuel</p>
         <p class="text-gray-600 italic">
           Store hours 9am to 10pm open Monday to Sunday.
         </p>
       </div>
     </div>
   </div>