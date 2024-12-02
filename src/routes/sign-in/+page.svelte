<script lang="ts">
    import { writable } from 'svelte/store';
    import { EyeSlashSolid, EyeSolid } from 'flowbite-svelte-icons';

    // Define writable stores for form fields and errors
    const name = writable('');
    const email = writable('');
    const address = writable('');
    const phoneNumber = writable('');
    const password = writable('');
    const confirmPassword = writable('');
    const showPassword = writable(false);
    const showConfirmPassword = writable(false);
    
    // Error states
    const nameError = writable('');
    const emailError = writable('');
    const addressError = writable('');
    const phoneNumberError = writable('');
    const passwordError = writable('');
    const confirmPasswordError = writable('');

    // Handle form submission
    async function handleSubmit(event: SubmitEvent) {
        event.preventDefault(); // Prevent default form submission

        // Collect form data
        const formData = {
            name: $name,
            email: $email,
            address: $address,
            phoneNumber: $phoneNumber,
            password: $password
        };

        try {
            const response = await fetch('http://localhost/GreenPhil_Project/backend/api/register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                mode: 'cors',
                body: JSON.stringify(formData)
            });

            const result = await response.json();
            if (result.status === 'success') {
                // Handle successful registration (e.g., redirect or show a message)
                alert(result.message);
            } else {
                // Handle errors (e.g., show error messages)
                if (result.message.includes('Name is required')) {
                    nameError.set(result.message);
                } else if (result.message.includes('Email is required')) {
                    emailError.set(result.message);
                } else if (result.message.includes('Password is required')) {
                    passwordError.set(result.message);
                } else if (result.message.includes('Address is required')) {
                    addressError.set(result.message);
                } else if (result.message.includes('Phone number is required')) {
                    phoneNumberError.set(result.message);
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
</script>

<div class="flex py-20">
    <main class="flex-1 flex flex-col items-center justify-center px-4">
        <div class="w-full max-w-md space-y-6">
            <h1 class="text-2xl text-center">Register</h1>

            <form on:submit={handleSubmit} class="space-y-4">
                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm text-gray-600">Name</label>
                    <input
                        type="text"
                        id="name"
                        bind:value={$name}
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded"
                        required
                    />
                    {#if $nameError}
                        <p class="text-red-500 text-sm">{$nameError}</p>
                    {/if}
                </div>

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

                <!-- Address Input -->
                <div>
                    <label for="address" class="block text-sm text-gray-600">Address</label>
                    <input
                        type="text"
                        id="address"
                        bind:value={$address}
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded"
                        required
                    />
                    {#if $addressError}
                        <p class="text-red-500 text-sm">{$addressError}</p>
                    {/if}
                </div>

                <!-- Phone Number Input -->
                <div>
                    <label for="phone-number" class="block text-sm text-gray-600">Phone Number</label>
                    <input
                        type="text"
                        id="phone-number"
                        bind:value={$phoneNumber}
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded"
                        required
                    />
                    {#if $phoneNumberError}
                        <p class="text-red-500 text-sm">{$phoneNumberError}</p>
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
                        <!-- Password visibility toggle button -->
                        <button
                            type="button"
                            on:click={(e) => showPassword.update(v => !v)}
                            on:keydown={(e) => { if (e.key === 'Enter' || e.key === ' ') showPassword.update(v => !v) }}
                            aria-label="Toggle password visibility"
                            class="absolute inset-y-0 right-0 flex items-center pr-3"
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

                <!-- Confirm Password Input -->
                <div>
                    <label for="confirm-password" class="block text-sm text-gray-600">Confirm Password</label>
                    <div class="relative">
                        <input
                            type={$showConfirmPassword ? 'text' : 'password'}
                            id="confirm-password"
                            bind:value={$confirmPassword}
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded pr-10"
                            required
                        />
                        <!-- Confirm password visibility toggle button -->
                        <button
                            type="button"
                            on:click={(e) => showConfirmPassword.update(v => !v)}
                            on:keydown={(e) => { if (e.key === 'Enter' || e.key === ' ') showConfirmPassword.update(v => !v) }}
                            aria-label="Toggle confirm password visibility"
                            class="absolute inset-y-0 right-0 flex items-center pr-3"
                        >
                            {#if $showConfirmPassword}
                                <EyeSolid class="w-5 h-5 text-gray-600" />
                            {:else}
                                <EyeSlashSolid class="w-5 h-5 text-gray-600" />
                            {/if}
                        </button>
                    </div>
                    {#if $confirmPasswordError}
                        <p class="text-red-500 text-sm">{$confirmPasswordError}</p>
                    {/if}
                </div>

                <button
                    type="submit"
                    class="w-full py-2 px-4 bg-gray-900 text-white text-sm uppercase tracking-wider hover:bg-gray-800"
                >
                    Register
                </button>
            </form>

            <p class="text-center text-sm text-gray-600">
                Already have an account? 
                <a href="/login" class="text-green-600 hover:underline">Log in</a>
            </p>
        </div>
    </main>
</div>
