<template>
    <div>
        <button
            @click.prevent="isAddModalOpen = true"
            :class="{ 'opacity-25': isAddModalOpen }"
            :disabled="isAddModalOpen"
            class="px-2 py-2 bg-blue-500 font-bold mb-4 text-md float-end text-white rounded shadow"
        >
            <i class="fa fa-plus"></i> Add Zoning Permit
        </button>

        <Modal :show="isAddModalOpen" :maxWidth="'2xl'" title="Add Zoning Permit" @close="isAddModalOpen = false">
            <div class="grid grid-cols-1 gap-6 p-6">
                <form class="mt-4" @submit.prevent="addPermit">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of Application</label>
                            <input type="date" v-model="form.date_of_application" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.date_of_application" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">OR Date</label>
                            <input type="date" v-model="form.or_date" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.or_date" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Official Receipt No.</label>
                        <input type="text" v-model="form.official_receipt_no" placeholder="Enter receipt number" class="mt-1 p-2 border rounded-md w-full" />
                        <InputError :message="form.errors.official_receipt_no" />
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" v-model="form.first_name" placeholder="Enter first name" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.first_name" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" v-model="form.middle_name" placeholder="Enter middle name" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.middle_name" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" v-model="form.last_name" placeholder="Enter last name" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.last_name" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" v-model="form.address" placeholder="Enter address" class="mt-1 p-2 border rounded-md w-full" />
                        <InputError :message="form.errors.address" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">ZIP Code</label>
                            <input type="text" v-model="form.zip" placeholder="Enter ZIP code" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.zip" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Owner Name</label>
                            <input type="text" v-model="form.owner_name" placeholder="Enter owner name" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.owner_name" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="text" v-model="form.contact_number" placeholder="Enter contact number" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.contact_number" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" v-model="form.email" placeholder="Enter email" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.email" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Location of Lot</label>
                        <input type="text" v-model="form.location_of_lot" placeholder="Enter location" class="mt-1 p-2 border rounded-md w-full" />
                        <InputError :message="form.errors.location_of_lot" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Right Over Land</label>
                        <select v-model="form.right_over_land" class="mt-1 p-2 border rounded-md w-full">
                            <option value="">Select Type</option>
                            <option value="Own">Own</option>
                            <option value="Rent">Rent</option>
                        </select>
                        <InputError :message="form.errors.right_over_land" />
                        <!-- <p v-if="errors.right_over_land" class="text-red-500 text-xs mt-1">{{ errors.right_over_land[0] }}</p> -->
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Lot Area (sqm)</label>
                        <input type="number" v-model="form.lot_area" placeholder="Enter lot area" class="mt-1 p-2 border rounded-md w-full" />
                        <InputError :message="form.errors.lot_area" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Upload File</label>
                        <input type="file" @change="handleFileUpload" class="mt-1 p-2 border rounded-md w-full" />
                        <InputError :message="form.errors.file" />
                    </div>

                    <div class="flex items-center">
                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import InputError from "@/Components/InputError.vue";
import Swal from "sweetalert2";
import { ref } from "vue";
import axios from "axios";

const emits = defineEmits(["transaction_id"]);
const isAddModalOpen = ref(false);

const form = useForm({
    date_of_application: "",
    or_date: "",
    official_receipt_no: "",
    first_name: "",
    middle_name: "",
    last_name: "",
    address: "",
    zip: "",
    owner_name: "",
    contact_number: "",
    email: "",
    location_of_lot: "",
    right_over_land: "",
    lot_area: "",
    file: null,
});

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    form.file = file ? file : null;
};

const addPermit = async () => {
    try {
        const formData = new FormData();
        const formValues = form.data(); // Extract only necessary data

        Object.keys(formValues).forEach((key) => {
            if (formValues[key]) {
                formData.append(key, formValues[key]);
            }
        });


        const response = await axios.post(route("zoning.add"), formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        Swal.fire("Success!", "Zoning permit added successfully.", "success");
        form.reset();
        form.file = null;
        isAddModalOpen.value = false;
        emits("transaction_id", Math.random());
    } catch (error) {
        Swal.fire("Error!", error.response?.data?.message || "Something went wrong.", "error");
    }
};
</script>
