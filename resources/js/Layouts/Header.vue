<template>
    <header class="flex items-center justify-between border-b-2 border-emerald-300 bg-emerald-900 px-4 py-4">
       
        <!-- Logo and title -->
        <div class="flex justify-start items-center space-x-1">
            <!-- Mobile menu toggle button -->
            <button @click.prevent="$page.props.showingMobileMenu = !$page.props.showingMobileMenu" class="text-gray-500 focus:outline-none lg:hidden mr-2">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <p class="">
                <h2 class="text-md md:text-xl font-semibold text-start text-white">{{ $page.props.auth.user.name }}</h2>
                <small>{{ roleFormatter($page.props.auth.user.role) }}</small>
            </p>
        </div>
        <div class="flex justify-end items-center space-x-1">
            <!-- Logout button -->
            <dropdown-link class=" text-left text-white border p-2 rounded" :href="route('logout')" method="post" as="button">
                <i class="fa fa-power-off text-red-500"></i> Logout
            </dropdown-link>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { roleFormatter } from "@/Utility/Formatter.js";


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
