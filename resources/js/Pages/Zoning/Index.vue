<template>
    <div>
        <Head title="Zoning Permits" />

        <AuthenticatedLayout>
            <template #header> Zoning Permits </template>

            <div class="bg-white rounded shadow p-4">
                <!-- Add Permit Button -->
                <Add @transaction_id="handleTransaction()" />

                <!-- Tabs Navigation -->
                <div class="flex border-b">
                    <button
                        v-for="tab in tabs"
                        :key="tab"
                        @click="activeTab = tab"
                        class="px-4 py-2 focus:outline-none"
                        :class="activeTab === tab ? 'border-b-2 border-blue-500 font-bold' : 'text-gray-600'"
                    >
                        {{ tab }}
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="mt-4">
                    <ApprovedList :key="updateKey" v-if="activeTab === 'Approved'" />
                    <PendingList :key="updateKey" v-if="activeTab === 'Pending'" />
                    <RejectedList :key="updateKey" v-if="activeTab === 'Rejected'" />
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

import Add from "./Module/Add.vue";

import ApprovedList from "./Module/ApprovedList.vue";
import PendingList from "./Module/PendingList.vue";
import RejectedList from "./Module/RejectedList.vue";

const tabs = ["Pending","Approved", "Rejected"];
const activeTab = ref("Pending"); // Default to Pending
const updateKey = ref(0);
const handleTransaction = (id) => {
    updateKey.value = id;
}
</script>