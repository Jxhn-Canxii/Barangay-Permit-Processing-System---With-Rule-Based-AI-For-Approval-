<template>
    <div>
        <button
            @click.prevent="openModal()"
            :class="{ 'opacity-25': isModalOpen }"
            :disabled="isModalOpen"
            class="px-2 py-2 bg-yellow-500 font-bold mb-4 text-md float-end text-white rounded shadow"
        >
            <i class="fa fa-edit"></i> Edit Census
        </button>

        <Modal :show="isModalOpen" :maxWidth="'2xl'" :title="'Edit Census Record'" @close="isModalOpen = false">
            <div class="grid grid-cols-1 gap-6 p-6">
                <form class="mt-4" @submit.prevent="updateCensus">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Year</label>
                        <input type="number" v-model="form.year" class="mt-1 p-2 border rounded-md w-full bg-gray-200" disabled />
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Households</label>
                            <input type="number" v-model="form.households" class="mt-1 p-2 border rounded-md w-full" required />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Male Population</label>
                            <input type="number" v-model="form.male" class="mt-1 p-2 border rounded-md w-full" required />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Female Population</label>
                            <input type="number" v-model="form.female" class="mt-1 p-2 border rounded-md w-full" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Total Population</label>
                        <input type="number" v-model="form.population" class="bg-gray-200 mt-1 p-2 border rounded-md w-full" disabled />
                    </div>

                    <div class="flex items-center mt-4">
                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded">
                            Update
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
import Swal from "sweetalert2";
import { ref, watch } from "vue";
import axios from "axios";

const props = defineProps({
    data: Object, // Pass census data as prop
});
const emits = defineEmits(["transaction_id"]);
const isModalOpen = ref(false);

const form = useForm({
    id: "", // For updating
    year: "",
    population: "",
    households: "",
    male: "",
    female: "",
});

// Watch for changes in props and update form
watch(
    () => props.data,
    (newData) => {
        if (newData) {
            form.id = newData.id;
            form.year = newData.year;
            form.population = newData.population;
            form.households = newData.households;
            form.male = newData.male;
            form.female = newData.female;
        }
    },
    { immediate: true }
);

// Open modal and set data
const openModal = () => {
    isModalOpen.value = true;
};

// Update census record
const updateCensus = async () => {
    try {
        await axios.put(route("barangay.census.update", { id: form.id }), form);
        Swal.fire("Success!", "Census record updated successfully.", "success");
        isModalOpen.value = false;
        emits("transaction_id",Math.random());
    } catch (error) {
        Swal.fire("Error!", error.response?.data?.message || "Something went wrong.", "error");
    }
};
</script>
