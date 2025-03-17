<template>
    <div>
        <div class="inline-block min-w-full bg-white overflow-hidden rounded p-2">
               
            <!-- Search Bar -->
            <input
                type="text"
                v-model="search.search"
                @input.prevent="fetchData()"
                placeholder="Search Zoning Permits"
                class="mt-1 mb-4 p-2 border rounded w-full text-black"
            />

            <!-- Table -->
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th class="border-b-2 border-gray-200 px-5 py-3 text-left">Applicant</th>
                        <th class="border-b-2 border-gray-200 px-5 py-3 text-left">Owner</th>
                        <th class="border-b-2 border-gray-200 px-5 py-3 text-left">Location</th>
                        <th class="border-b-2 border-gray-200 px-5 py-3 text-left">Status</th>
                        <th class="border-b-2 border-gray-200 px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="permit in data.data" v-if="data.total_pages" :key="permit.id" class="text-gray-700">
                        <td class="border-b border-gray-200 px-5 py-5 text-sm">
                            {{ permit.first_name }} {{ permit.middle_name }} {{ permit.last_name }}
                        </td>
                        <td class="border-b border-gray-200 px-5 py-5 text-sm">
                            {{ permit.owner_name }}
                        </td>
                        <td class="border-b border-gray-200 px-5 py-5 text-sm">
                            {{ permit.location_of_lot }}
                        </td>
                        <td class="border-b border-gray-200 px-5 py-5 text-sm">
                            <span 
                                :class="{
                                    'text-green-600': permit.status_id === 2,
                                    'text-red-600': permit.status_id === 3,
                                    'text-yellow-600': permit.status_id === 1
                                }">
                                {{ statusFormatter(permit.status_id) }}
                            </span>
                        </td>
                        <td class="border-b border-gray-200 px-5 py-5 text-sm flex space-x-2">
                            <!-- <button v-if="permit.status_id === 1" @click="approvePermit(permit.id)" class="px-3 py-1 bg-green-500 text-white rounded">
                                Approve
                            </button>
                            <button v-if="permit.status_id === 1" @click="rejectPermit(permit.id)" class="px-3 py-1 bg-red-500 text-white rounded">
                                Reject
                            </button> -->
                            <ViewForm :key="permit.id" :data="permit" />
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="5" class="border-b text-center font-bold text-lg border-gray-200 bg-white px-5 py-5">
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
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Paginator from "@/Components/Paginator.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

import ViewForm from './ViewForm.vue';
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

// Fetch the zoning permits data
const fetchData = async () => {
    try {
        const response = await axios.post(route("zoning.rejected.list"), search.value);
        data.value = response.data;
    } catch (error) {
        console.error("Error fetching zoning permits:", error);
    }
};

// Handle pagination changes
const handlePagination = (page_num) => {
    search.value.page_num = page_num ?? 1;
    fetchData();
};

// Refresh data after any transaction
const handleTransaction = () => {
    fetchData();
};

const statusFormatter = (status_id) => {
    switch (status_id) {
        case 1:
            return 'Pending';
            break;
        case 2:
            return 'Approved';
            break;
        case 3:
            return 'Rejected';
            break;
        default:
            break;
    }
}

// Approve Zoning Permit
const approvePermit = async (id) => {
    try {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You are about to approve this zoning permit.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, approve it!",
        });

        if (result.isConfirmed) {
            await axios.put(route("zoning.approve", id));
            Swal.fire("Approved!", "The zoning permit has been approved.", "success");
            fetchData();
        }
    } catch (error) {
        console.error("Error approving zoning permit:", error);
        Swal.fire("Error!", "Failed to approve the zoning permit.", "error");
    }
};

// Reject Zoning Permit
const rejectPermit = async (id) => {
    try {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: "You are about to reject this zoning permit.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, reject it!",
        });

        if (result.isConfirmed) {
            await axios.put(route("zoning.reject", id));
            Swal.fire("Rejected!", "The zoning permit has been rejected.", "success");
            fetchData();
        }
    } catch (error) {
        console.error("Error rejecting zoning permit:", error);
        Swal.fire("Error!", "Failed to reject the zoning permit.", "error");
    }
};

</script>
