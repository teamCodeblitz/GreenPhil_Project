<script lang="ts">
    import { writable } from 'svelte/store';

    let email = writable('');
    let emailError = writable('');
    let successMessage = writable('');

    function validateEmail(email: string): boolean {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function handleSubmit(event: Event) {
        event.preventDefault();

        emailError.set('');
        successMessage.set('');

        email.subscribe(value => {
            if (!value) {
                emailError.set('Email is required.');
                return;
            }

            if (!validateEmail(value)) {
                emailError.set('Please enter a valid email address.');
                return;
            }
        })();

        if ($emailError) {
            return; // Stop submission if there are errors
        }

        // Simulate sending password reset email (replace with actual API call)
        console.log('Sending password reset email to:', $email);
        successMessage.set('A password reset link has been sent to your email address.');
        
        // Optionally, reset the email field after submission
        email.set('');
    }
</script>

<div class="flex py-20">
    <main class="flex-1 flex flex-col items-center justify-center px-4">
        <div class="w-full max-w-md space-y-6">
            <h1 class="text-2xl text-center">Forgot Password</h1>
            
            <form on:submit={handleSubmit} class="space-y-4">
                <div>
                    <label for="email" class="block text-sm text-gray-600">Email</label>
                    <input
                        type="email"
                        id="email"
                        bind:value={$email}
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded"
                        required
                    />
                    {#if $emailError}
                        <p class="text-red-500 text-sm">{$emailError}</p>
                    {/if}
                </div>

                <button
                    type="submit"
                    class="w-full py-2 px-4 bg-gray-900 text-white text-sm uppercase tracking-wider hover:bg-gray-800"
                >
                    Send Reset Link
                </button>

                {#if $successMessage}
                    <p class="text-green-500 text-sm text-center">{$successMessage}</p>
                {/if}
                
                <a href="/login" class="block text-sm text-center text-gray-600 hover:underline">
                    Remembered your password? Login
                </a>
            </form>
        </div>
    </main>
</div>