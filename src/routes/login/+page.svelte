<script lang="ts">
    import { writable } from 'svelte/store';
    import { EyeSlashSolid, EyeSolid } from 'flowbite-svelte-icons'; // Import the icons

    let email = writable('');
    let password = writable('');
    let emailError = writable('');
    let passwordError = writable('');
    let showPassword = writable(false); // State to toggle password visibility

    // Email validation function
    function validateEmail(email: string): boolean {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Handle form submission
    function handleSubmit(event: Event) {
        event.preventDefault();

        // Reset errors
        emailError.set('');
        passwordError.set('');

        // Get the values of email and password directly
        const emailValue = $email;
        const passwordValue = $password;

        // Email validation
        if (!emailValue) {
            emailError.set('Email is required.');
            return;
        }

        if (!validateEmail(emailValue)) {
            emailError.set('Please enter a valid email address.');
            return;
        }

        // Password validation
        if (!passwordValue) {
            passwordError.set('Password is required.');
            return;
        }

        // Prepare login data
        const loginData = {
            email: emailValue,
            password: passwordValue,
        };

        // Perform the login fetch request
        fetch('http://localhost/GreenPhil-Project/backend/api/login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(loginData),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Login successful!');
                window.location.href = '/'; // Redirect to the home page
            } else {
                alert(data.message); // Show error message from server
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>


<div class="flex py-20">
    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center px-4">
        <div class="w-full max-w-md space-y-6">
            <h1 class="text-2xl text-center">Login</h1>

            <form on:submit={handleSubmit} class="space-y-4">
                <!-- Email Input -->
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

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm text-gray-600">Password</label>
                    <div class="relative">
                        <input
                            type={$showPassword ? 'text' : 'password'}
                            id="password"
                            bind:value={$password}
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded pr-10"
                            required
                        />
                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 flex items-center pr-3"
                            on:click={() => showPassword.update(value => !value)}
                        >
                            {#if $showPassword}
                                <EyeSolid class="w-5 h-5 text-gray-600" />
                            {:else}
                                <EyeSlashSolid class="w-5 h-5 text-gray-600" />
                            {/if}
                        </button>
                    </div>
                    {#if $passwordError}
                        <p class="text-red-500 text-sm">{$passwordError}</p>
                    {/if}
                </div>

                <!-- Forgot Password Link -->
                <a href="/forgot-password" class="block text-sm text-center text-gray-600 hover:underline">
                    Forgot your password?
                </a>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full py-2 px-4 bg-gray-900 text-white text-sm uppercase tracking-wider hover:bg-gray-800"
                >
                    Sign In
                </button>
            </form>

            <!-- New "Don't have an account?" link -->
            <p class="text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="/sign-in" class="text-green-600 hover:underline">Sign up</a>
            </p>
        </div>
    </main>
</div>
