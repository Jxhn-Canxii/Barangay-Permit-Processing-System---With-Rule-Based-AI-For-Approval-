<template>
  <!-- Sidebar Toggle Button -->
  <button @click="isSidebarOpen = !isSidebarOpen"
          class="fixed top-2 left-2 z-40 p-2 bg-lime-700 text-white rounded-md lg:hidden">
    <i class="fa" :class="isSidebarOpen ? 'fa-times' : 'fa-bars'"></i>
  </button>

  <!-- Sidebar Overlay (for mobile view) -->
  <div v-if="isSidebarOpen"
       @click="isSidebarOpen = false"
       class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden">
  </div>

  <!-- Sidebar Content -->
  <div :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-30 w-64 bg-emerald-900 transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex justify-center items-center mt-8">
        <!-- Profile Picture -->
      <div class="relative block">
        <img 
          :src="$page.props.auth.user.profilePicture ?? '/image/profile.png'" 
          alt="Profile Picture" 
          class="w-24 h-24 rounded-full border-4 border-gray-600"
        />
        <span class="absolute bottom-0 right-3 bg-green-500 w-5 h-5 rounded-full border-2 border-gray-800"></span>
      </div>
      <!-- LGU Manager Branding
      <div class="flex items-center justify-center mt-4 text-lg">
        <i class="fa fa-institution text-yellow-400"></i>
        <span class="mx-2 font-semibold">LGU MANAGER</span>
      </div> -->
    </div>
    <!-- User Info -->
    <div class="text-center mt-3">
      <h2 class="text-2xl font-semibold text-white">{{ $page.props.auth.user.name }}</h2>
      <p class="text-sm text-gray-300">
        {{ roleFormatter($page.props.auth.user.role) }}
      </p>
    </div>
    <!-- Navigation Links -->
    <nav class="mt-10">
      <nav-link :href="route('dashboard.index')" :active="route().current('dashboard.index')">
        <template #icon>
          <i class="fa fa-chart-line"></i>
        </template>
        Dashboard
      </nav-link>
      <nav-link :href="route('zoning.index')" :active="route().current('zoning.index')">
        <template #icon>
          <i class="fa fa-file-contract"></i>
        </template>
        Permit Processing
      </nav-link>
      <nav-link v-if="sessionRole != 3" :href="route('users.index')" :active="route().current('users.index')">
        <template #icon>
          <i class="fa fa-users"></i>
        </template>
        Users
      </nav-link>
    </nav>
    
  </div>
</template>

<script setup>
import { ref } from "vue";
import NavLink from "@/Components/NavLink.vue";

// Sidebar state (default: open)
const isSidebarOpen = ref(true);
const sessionRole = ref(0);
const roleFormatter = (role_id) => {
    sessionRole.value = role_id;
    switch (role_id) {
        case 1:
            return 'SuperAdmin'
            break;
        case 2:
            return 'Admin'
            break;
        case 3:
            return 'User'
            break;
        default:
            return 'Unassigned'
            break;
    }
}
const logOut = async () => {
    try {
        // Reload the page after successful login
        const response = axios.get(route('logout'));
        if(response){
            localStorage.clear();
            sessionStore.clearSession();
            location.reload();
        }
       
    } catch (error) {
        console.error('Error logging out:', error);
    }
};
</script>

<style scoped>
/* Ensure smooth sliding effect */
.transition-transform {
  transition: transform 0.3s ease-in-out;
}
</style>
