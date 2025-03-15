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
      <div class="flex items-center justify-center">
        <i class="fa fa-2x fa-institution"></i>
        <span class="mx-2 text-2xl font-semibold text-white">LGU MANAGER</span>
      </div>
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
      <nav-link :href="route('users.index')" :active="route().current('users.index')">
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
