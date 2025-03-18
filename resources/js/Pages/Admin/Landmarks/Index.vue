<template>
    <Head title="Barangay Landmarks" />

    <AuthenticatedLayout>
        <template #header>
            Landmarks
        </template>
        <div class="bg-white rounded shadow p-4">
            <div class="inline-block min-w-full overflow-hidden rounded-lg p-4">
                <!-- Search Bar -->
                <div class="flex justify-between text-nowrap gap-5 mb-3">
                    <input
                        type="text"
                        v-model="search.search"
                        @input.prevent="fetchData()"
                        placeholder="Search Landmarks"
                        class="px-2 py-2 font-bold mb-4 w-full text-md float-end text-black rounded shadow"
                    />
                    <Add :key="updateKey" @transaction_id="handleTransaction()" />
                </div>
                <!-- Table -->
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="border-b bg-green-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <th class="border-b-2 border-gray-200 px-5 py-3 text-left">Name</th>
                            <th class="border-b-2 border-gray-200 px-5 py-3 text-left">Building Type</th>
                            <th class="border-b-2 border-gray-200 px-5 py-3 text-left">Description</th>
                            <th class="border-b-2 border-gray-200 px-5 py-3 text-right">Latitude</th>
                            <th class="border-b-2 border-gray-200 px-5 py-3 text-right">Longitude</th>
                            <th class="border-b-2 border-gray-200 px-5 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="landmark in data.landmarks" v-if="data.total_pages" :key="landmark.id" class="text-gray-700">
                            <td class="border-b border-gray-200 px-5 py-5 text-sm">
                                {{ landmark.name }}
                            </td>
                            <td class="border-b border-gray-200 px-5 py-5 text-sm">
                                {{ landmark.building_type ?? 'N/A' }}
                            </td>
                            <td class="border-b border-gray-200 px-5 py-5 text-sm">
                                {{ landmark.description ?? 'No description' }}
                            </td>
                            <td class="border-b border-gray-200 px-5 py-5 text-sm text-right">
                                {{ landmark.latitude }}
                            </td>
                            <td class="border-b border-gray-200 px-5 py-5 text-sm text-right">
                                {{ landmark.longitude }}
                            </td>
                            <td class="border-b border-gray-200 px-5 py-5 text-sm text-center">
                                <div class="flex justify-center items-center">
                                    <Edit :key="landmark.id" @transaction_id="handleTransaction()" :data="landmark" />
                                    <Delete :key="landmark.id" @transaction_id="handleTransaction()" :id="landmark.id" />
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="6" class="border-b text-center font-bold text-lg border-gray-200 bg-white px-5 py-5">
                                <p class="text-red-500 whitespace-no-wrap">
                                    No Data Found!
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex w-full overflow-auto">
                    <Paginator
                        v-if="data.total > 0"
                        :page_number="search.page_num"
                        :total_rows="data.total ?? 0"
                        :itemsperpage="search.itemsperpage"
                        @page_num="handlePagination"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Paginator from "@/Components/Paginator.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

import Add from "./Module/Add.vue";
import Edit from "./Module/Edit.vue";
import Delete from "./Module/Delete.vue";

const data = ref([]);
const search = ref({
    page_num: 1,
    total_pages: 0,
    total: 0,
    search: "",
    itemsperpage: 10,
});

onMounted(() => {
    fetchData();
});

// Fetch the landmarks data
const fetchData = async () => {
    try {
        const response = await axios.post(route("landmarks.list"), search.value);
        data.value = response.data;
    } catch (error) {
        console.error("Error fetching landmarks:", error);
    }
};

// Handle pagination changes
const handlePagination = (page_num) => {
    search.value.page_num = page_num ?? 1;
    fetchData();
};

const updateKey = ref(0);

const handleTransaction = (id) => {
    fetchData();
    updateKey.value = id;
};
</script>
