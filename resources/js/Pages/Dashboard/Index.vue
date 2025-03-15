<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header> Dashboard </template>

        <div class="overflow-hidden shadow-sm sm:rounded-lg min-h-screen p-4 space-y-3">
           <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Chart Components -->
                <InventoryChart />
                <SalesChart  />
                <RevenueChart />
                <BuildingDistribution />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import axios from "axios"; // Ensure axios is imported
import Swal from "sweetalert2";
import Modal from "@/Components/Modal.vue";
import Paginator from "@/Components/Paginator.vue";

import InventoryChart from "./Module/InventoryChart.vue";
import SalesChart from "./Module/SalesChart.vue";
import RevenueChart from "./Module/RevenueChart.vue";
import BuildingDistribution from "./Module/BuildingDistribution.vue";

onMounted(() => {});
</script>
