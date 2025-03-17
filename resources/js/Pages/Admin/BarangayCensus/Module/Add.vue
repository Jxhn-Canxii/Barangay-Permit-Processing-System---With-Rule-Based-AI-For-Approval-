<template>
    <div>
        <button
            @click.prevent="isAddModalOpen = true"
            :class="{ 'opacity-25': isAddModalOpen }"
            :disabled="isAddModalOpen"
            class="px-2 py-2 bg-blue-500 font-bold mb-4 text-md float-end text-white rounded shadow"
        >
            <i class="fa fa-plus"></i> Add Census
        </button>

        <Modal :show="isAddModalOpen" :maxWidth="'2xl'" title="Add Census Record" @close="isAddModalOpen = false">
            <div class="grid grid-cols-1 gap-6 p-6">
                <form class="mt-4" @submit.prevent="addCensus">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Year</label>
                        <input type="number" v-model="form.year" placeholder="Enter census year" class="mt-1 p-2 border rounded-md w-full" required />
                        <InputError :message="form.errors.year" />
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Households</label>
                            <input type="number" v-model="form.households" placeholder="Enter number of households" class="mt-1 p-2 border rounded-md w-full" required />
                            <InputError :message="form.errors.households" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Male Population</label>
                            <input type="number" v-model="form.male" placeholder="Enter male population" class="mt-1 p-2 border rounded-md w-full" required />
                            <InputError :message="form.errors.male" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Female Population</label>
                            <input type="number" v-model="form.female" placeholder="Enter female population" class="mt-1 p-2 border rounded-md w-full" required />
                            <InputError :message="form.errors.female" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Total Population</label>
                        <small hidden>{{ form.population = parseFloat(form.male) + parseFloat(form.female) + parseFloat(form.households) }}</small>
                        <input type="number" v-model="form.population" disabled placeholder="Enter population" class="bg-gray-200 mt-1 p-2 border rounded-md w-full" required />
                        <InputError :message="form.errors.population" />
                    </div>

                    <div class="flex items-center mt-4">
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
    year: "",
    population: "",
    households: "",
    male: "",
    female: "",
});

const addCensus = async () => {
    try {
        await axios.post(route("barangay.census.add"), form);
        Swal.fire("Success!", "Census record added successfully.", "success");
        form.reset();
        isAddModalOpen.value = false;
        emits("transaction_id",Math.random());
    } catch (error) {
        Swal.fire("Error!", error.response?.data?.message || "Something went wrong.", "error");
    }
};
</script>
