<template>
    <header class="flex items-center justify-between border-b-2 border-emerald-300 bg-emerald-900 px-4 py-2">
        <!-- Mobile menu toggle button -->
        <button @click.prevent="$page.props.showingMobileMenu = !$page.props.showingMobileMenu" class="text-gray-500 focus:outline-none lg:hidden mr-2">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>

        <!-- Logo and title -->
        <div class="flex items-center space-x-1">
        </div>

        <!-- Navigation Links with Dropdown Grouping -->
        <nav class="hidden lg:flex text-sm text-nowrap px-0 mx-0">
            
        </nav>

        <!-- Logout button -->
        <dropdown-link class="ml-4 text-left text-white border p-2 rounded" :href="route('logout')" method="post" as="button">
            <i class="fa fa-power-off text-red-500"></i> Logout
        </dropdown-link>
    </header>
</template>

<script setup>
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { ref } from 'vue';

// Define dropdown state
const showHistoryDropdown = ref(false);


// Function to close all dropdowns
const closeAllDropdowns = () => {
    showHistoryDropdown.value = false;
   
};

// Function to toggle a specific dropdown
const toggleDropdown = (dropdown) => {
    closeAllDropdowns(); // Close all dropdowns first
    switch (dropdown) {
        case 'history':
            showHistoryDropdown.value = !showHistoryDropdown.value;
            break;
    }
};
</script>
