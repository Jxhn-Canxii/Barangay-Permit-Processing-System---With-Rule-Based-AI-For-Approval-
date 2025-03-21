<template>
    <div>
        <button
            @click.prevent="trainModel()"
            class="px-3 py-2 bg-purple-800 font-bold text-nowrap rounded text-md float-center text-white shadow"
        >
            <i class="fa fa-robot"></i> Train Model
        </button>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import axios from "axios";



const trainModel = async () => {
    // Show a confirmation dialog
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to trainModel this team.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, trainModel it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true,
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await axios.get(route("zoning.train"));
                if (response) {
                    Swal.fire({
                        title: "Success!",
                        text: "Team removed successfully.",
                        icon: "success",
                    });
                    // Refresh leagues
                    emits('transaction_id',Math.random());
                } else {
                    throw new Error("Failed to trainModel team");
                }
            } catch (error) {
                console.error("Error deleting team:", error);
            }
        }
    });
};
</script>
