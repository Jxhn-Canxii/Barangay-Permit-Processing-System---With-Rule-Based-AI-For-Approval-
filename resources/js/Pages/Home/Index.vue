<template>
  <GuestLayout>
    <div class="bg-gray-100 min-h-screen min-w-screen">
      <!-- Embed the iframe here -->
      <iframe 
        src="https://smartbarangayconnect.com/" 
        width="100%" 
        height="1000px"
        frameborder="0" 
        style="border: none;">
      </iframe>
    </div>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
// No specific script needed for this homepage layout
</script>

<style scoped>
/* You can add additional styles here if needed */
</style>
