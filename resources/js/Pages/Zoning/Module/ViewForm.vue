<template>

    <button
        @click.prevent="isViewModalOpen = true"
        class="px-3 py-1 bg-blue-500 text-white rounded"
    >
        <i class="fa fa-eye"></i> View
    </button>

    <Modal :show="isViewModalOpen" :maxWidth="'6xl'" title="View Zoning Permit" @close="isViewModalOpen = false">
        <div class="p-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-bold">Date of Application:</label>
                    <p class="border px-2 py-1 rounded">{{ data.date_of_application }}</p>
                </div>
                <div>
                    <label class="font-bold">O.R. Date:</label>
                    <p class="border px-2 py-1 rounded">{{ data.or_date || 'N/A' }}</p>
                </div>
                <div>
                    <label class="font-bold">Official Receipt No.:</label>
                    <p class="border px-2 py-1 rounded">{{ data.official_receipt_no || 'N/A' }}</p>
                </div>
                <div>
                    <label class="font-bold">Status:</label>
                    <p class="border px-2 py-1 rounded">{{ statusText }}</p>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-3 gap-4">
                <div>
                    <label class="font-bold">First Name:</label>
                    <p class="border px-2 py-1 rounded">{{ data.first_name }}</p>
                </div>
                <div>
                    <label class="font-bold">Middle Name:</label>
                    <p class="border px-2 py-1 rounded">{{ data.middle_name || 'N/A' }}</p>
                </div>
                <div>
                    <label class="font-bold">Last Name:</label>
                    <p class="border px-2 py-1 rounded">{{ data.last_name }}</p>
                </div>
            </div>

            <div class="mt-4">
                <label class="font-bold">Address:</label>
                <p class="border px-2 py-1 rounded">{{ data.address }}, {{ data.zip || 'N/A' }}</p>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="font-bold">Owner Name:</label>
                    <p class="border px-2 py-1 rounded">{{ data.owner_name }}</p>
                </div>
                <div>
                    <label class="font-bold">Contact #:</label>
                    <p class="border px-2 py-1 rounded">{{ data.contact_number }}</p>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="font-bold">Email:</label>
                    <p class="border px-2 py-1 rounded">{{ data.email || 'N/A' }}</p>
                </div>
                <div>
                    <label class="font-bold">Location of Lot:</label>
                    <p class="border px-2 py-1 rounded">{{ data.location_of_lot }}</p>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="font-bold">Right Over Land:</label>
                    <p class="border px-2 py-1 rounded">{{ data.right_over_land }}</p>
                </div>
                <div>
                    <label class="font-bold">Lot Area:</label>
                    <p class="border px-2 py-1 rounded">{{ data.lot_area }}</p>
                </div>
            </div>

            <div class="mt-4">
                <label class="font-bold">Uploaded File:</label>
                <div v-if="data.uploaded_file">
                    <a :href="fileUrl" target="_blank" class="text-blue-500 underline">View File</a>
                </div>
                <p v-else class="border px-2 py-1 rounded">No file uploaded</p>
            </div>

            <div class="mt-6 text-right">
                <button @click="isViewModalOpen = false" class="px-4 py-2 bg-gray-500 text-white rounded shadow">
                    Close
                </button>
            </div>
        </div>
    </Modal>

</template>

<script setup>
import { ref, computed } from "vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    data: Object,
});

const isViewModalOpen = ref(false);

const statusText = computed(() => {
    switch (props.data.status_id) {
        case 1:
            return "Pending";
        case 2:
            return "Approved";
        case 3:
            return "Rejected";
        default:
            return "Unknown";
    }
});

const fileUrl = computed(() => {
    return `/storage/${props.data.uploaded_file}`;
});
</script>

<style scoped>
p {
    background-color: #f8f9fa;
}
</style>
