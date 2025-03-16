<template>
    <div>
        <button
            @click.prevent="isAddModalOpen = true"
            :class="{ 'opacity-25': isAddModalOpen }"
            :disabled="isAddModalOpen"
            class="px-2 py-2 bg-blue-500 font-bold mb-4 text-md float-end text-white rounded shadow"
        >
            <i class="fa fa-user"></i> Add User
        </button>

        <Modal :show="isAddModalOpen" :maxWidth="'2xl'" title="Add User" @close="isAddModalOpen = false">
            <div class="grid grid-cols-1 gap-6 p-6">
                <form class="mt-4" @submit.prevent="addUser">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" v-model="form.name" placeholder="Enter full name" class="mt-1 p-2 border rounded-md w-full" />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" v-model="form.email" placeholder="Enter email" class="mt-1 p-2 border rounded-md w-full" />
                        <InputError :message="form.errors.email" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" v-model="form.password" placeholder="Enter password" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.password" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" v-model="form.password_confirmation" placeholder="Confirm password" class="mt-1 p-2 border rounded-md w-full" />
                            <InputError :message="form.errors.password_confirmation" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select v-model="form.role" class="mt-1 p-2 border rounded-md w-full">
                            <option value="" disabled>Select Role</option>
                            <option :disabled="$page.props.auth.user.role != 1" value="1">SuperAdmin</option>
                            <option value="2">Admin</option>
                            <option value="3">User</option>
                        </select>
                        <InputError :message="form.errors.role" />
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

const emits = defineEmits(["user_added"]);
const isAddModalOpen = ref(false);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "",
});

const addUser = async () => {
    try {
        await axios.post(route("users.add"), form);
        Swal.fire("Success!", "User added successfully.", "success");
        form.reset();
        isAddModalOpen.value = false;
        emits("user_added");
    } catch (error) {
        Swal.fire("Error!", error.response?.data?.message || "Something went wrong.", "error");
    }
};
</script>
