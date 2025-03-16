<template>
    <header class="flex items-center justify-between bg-emerald-900 px-4 py-2 z-200">
        <!-- Mobile menu toggle button -->
        <button @click="toggleMobileMenu" class="text-gray-500 focus:outline-none lg:hidden mr-2">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>

        <!-- Logo and title -->
        <div class="flex items-center space-x-1">
            <img 
                src='/image/logo.jpg'
                alt="Profile Picture" 
                class="w-16 h-16 rounded-full border-4 border-gray-600"
            />
            <span class="text-white text-4xl font-bold">Brgy. San Agustin</span>
        </div>

        <!-- Desktop Navigation Links -->
        <nav class="hidden lg:flex text-sm px-6 py-4 space-x-6 rounded text-white">
            <NavLink 
                :href="route('home')" 
                :active="route().current('home')" 
                class="nav-link hover:bg-emerald-600 px-4 py-2 rounded-lg transition-all duration-200"
            >
                Home
            </NavLink>
            <NavLink 
                :href="route('mapping')" 
                :active="route().current('mapping')" 
                class="nav-link hover:bg-emerald-600 px-4 py-2 rounded-lg transition-all duration-200"
            >
                Mapping
            </NavLink>
            <NavLink 
                :href="route('complaint')" 
                :active="route().current('complaint')" 
                class="nav-link hover:bg-emerald-600 px-4 py-2 rounded-lg transition-all duration-200"
            >
                Issues And Complains
            </NavLink>
            <NavLink 
                :href="route('login')" 
                :active="route().current('login')" 
                class="nav-link hover:bg-emerald-600 px-4 py-2 rounded-lg transition-all duration-200"
            >
                Login
            </NavLink>
        </nav>
    </header>
 <!-- Mobile Navigation Links (Visible when mobile menu is active) -->
        <nav v-if="showingMobileMenu" class="lg:hidden  bg-emerald-900 text-white shadow-lg space-y-4 p-4 z-50">
            <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                Home
            </ResponsiveNavLink>
            <ResponsiveNavLink :href="route('mapping')" :active="route().current('mapping')">
                Mapping
            </ResponsiveNavLink>
            <ResponsiveNavLink :href="route('login')" :active="route().current('login')">
                Login
            </ResponsiveNavLink>
        </nav>
   
</template>

<script setup>
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

// Define mobile menu state
const showingMobileMenu = ref(false);

// Toggle the mobile menu visibility
const toggleMobileMenu = () => {
    showingMobileMenu.value = !showingMobileMenu.value;
};
</script>

<style scoped>
/* Mobile Menu Styles */
@media (max-width: 1024px) {
    nav {
        flex-direction: column;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #1F3A43; /* Darker background for the menu */
        width: 100%;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: center;
        padding: 16px;
    }

    nav a {
        width: 100%;
        text-align: center;
        padding: 12px;
        display: block;
        font-size: 1.2rem;
    }

    nav a:hover {
        background-color: #2c6e71; /* Darken background on hover */
    }
}

/* Optional: Close mobile menu when clicking on the link */
nav a:hover {
    background-color: #2c6e71;
}
</style>
