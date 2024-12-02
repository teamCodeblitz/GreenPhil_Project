<script lang="ts">
    import { writable } from 'svelte/store';
    import { EyeSlashSolid, EyeSolid } from 'flowbite-svelte-icons';

    let name = writable('');
    let email = writable('');
    let password = writable('');
    let confirmPassword = writable('');
    let address = writable('');
    let phoneNumber = writable('');
    let nameError = writable('');
    let emailError = writable('');
    let passwordError = writable('');
    let confirmPasswordError = writable('');
    let addressError = writable('');
    let phoneNumberError = writable('');
    let showPassword = writable(false);
    let showConfirmPassword = writable(false);

    // Validate email and phone number
    function validateEmail(email: string): boolean {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePhoneNumber(phone: string): boolean {
        const phoneRegex = /^\d{11}$/;
        return phoneRegex.test(phone);
    }

    // Handle form submission
    function handleSubmit(event: Event) {
        event.preventDefault();

        // Reset errors
        nameError.set('');
        emailError.set('');
        passwordError.set('');
        confirmPasswordError.set('');
        addressError.set('');
        phoneNumberError.set('');

        // Access values from writable stores
        let $name, $email, $password, $confirmPassword, $address, $phoneNumber;
        name.subscribe(value => $name = value)();
        email.subscribe(value => $email = value)();
        password.subscribe(value => $password = value)();
        confirmPassword.subscribe(value => $confirmPassword = value)();
        address.subscribe(value => $address = value)();
        phoneNumber.subscribe(value => $phoneNumber = value)();

        // Validation
        if (!$name) {
            nameError.set('Name is required.');
            return;
        }
        if (!$email) {
            emailError.set('Email is required.');
            return;
        }
        if (!validateEmail($email)) {
            emailError.set('Please enter a valid email address.');
            return;
        }
        if (!$password) {
            passwordError.set('Password is required.');
            return;
        }
        if ($password !== $confirmPassword) {
            confirmPasswordError.set('Passwords do not match.');
            return;
        }
        if (!$address) {
            addressError.set('Address is required.');
            return;
        }
        if (!$phoneNumber || !validatePhoneNumber($phoneNumber)) {
            phoneNumberError.set('Phone number must be exactly 11 digits.');
            return;
        }

        // Prepare registration data
        const registerData = {
            name: $name,
            email: $email,
            password: $password,
            address: $address,
            phoneNumber: $phoneNumber,
        };

        // Send data to the backend
        fetch('http://localhost/GreenPhil-Project/backend/api/register.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(registerData),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Registration successful!');
                    window.location.href = '/login'; // Redirect after successful registration
                } else {
                    alert(data.message); // Show error message from the server
                }
            })
            .catch(error => console.error('Error:', error));
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
