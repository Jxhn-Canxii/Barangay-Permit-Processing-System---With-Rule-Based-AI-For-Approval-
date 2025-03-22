<template>
  <div class="relative w-full">
    <!-- Selected Items Display -->
    <div class="flex flex-wrap gap-2 mb-2">
      <div
        v-for="(item, index) in selectedItems"
        :key="item.value"
        class="bg-blue-200 text-sm p-1 rounded bg-yellow-50 shadow-md flex items-center space-x-1"
      >
        <span>{{ item.label }}</span>
        <button
          type="button"
          class="text-red-500 font-bold"
          @click="removeSelectedItem(index)"
        >
          &times;
        </button>
      </div>
    </div>

    <!-- Input Field -->
    <div class="flex">
      <input
        type="text"
        :placeholder="placeholder"
        v-model="searchQuery"
        @input="onInput"
        @keydown="handleKeyDown"
        autocomplete="off"
        class="mt-1 p-2 border rounded-md w-full"
      />
      <!-- <button
        type="button"
        @click.prevent="viewItems()"
        class="absolute top-2 right-2"
      >
        <i class="fa fa-xs font-extrabold text-black fa-chevron-down"></i>
      </button> -->
    </div>

    <!-- Dropdown Menu -->
    <div
      class="dropdown-menu absolute bg-white shadow w-full mt-1"
      v-if="filteredItems.length > 0 && searchQuery.length > 0"
      @scroll="handleScroll"
      style="max-height: 200px; overflow-y: auto;"
    >
      <ul>
        <li
          v-for="(item, index) in filteredItems"
          :key="item.value"
          :class="[ 
            'p-2 border-l-2 border-slate-200 flex py-2 font-bold shadow text-gray-600 cursor-pointer hover:bg-gray-100',
            { 'bg-slate-200': selectedIndex === index }
          ]"
          @click="toggleSelectItem(item)"
          @mouseover="selectedIndex = index"
        >
          {{ item.label }}
          <span v-if="isSelected(item)" class="ml-auto text-green-500 font-bold">
            ✓
          </span>
        </li>
        <li v-if="loadingMore" class="text-center py-2">Loading more...</li>
        <li v-if="!loadingMore && !hasMoreItems" class="text-center py-2 text-gray-500">No more items</li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, defineEmits, defineProps, onMounted } from "vue";

const props = defineProps({
  // Props definition with default values
  data: Array, // An array of items that contain { value, label }
  placeholder: String, // Placeholder text for input field
});

const emit = defineEmits(["items-selected"]);

const searchQuery = ref("");
const filteredItems = ref(props.data || []); // Use data passed in props
const selectedItems = ref([]); // Store selected items
const selectedIndex = ref(-1);
const loadingMore = ref(false);
const hasMoreItems = ref(true); // Track if more items can be loaded

// When the component is mounted, initialize selected items
onMounted(() => {
  filteredItems.value = props.data || []; // Pre-filtered data
  console.log(props.data);
});

// Handle input changes, filter the items based on search query
const onInput = () => {
  filterItems();
};

// Handle keyboard navigation
const handleKeyDown = (event) => {
  switch (event.key) {
    case "ArrowDown":
      event.preventDefault();
      if (selectedIndex.value < filteredItems.value.length - 1) {
        selectedIndex.value += 1;
      }
      break;
    case "ArrowUp":
      event.preventDefault();
      if (selectedIndex.value > 0) {
        selectedIndex.value -= 1;
      }
      break;
    case "Enter":
      event.preventDefault();
      if (selectedIndex.value >= 0 && filteredItems.value[selectedIndex.value]) {
        toggleSelectItem(filteredItems.value[selectedIndex.value]);
      }
      break;
  }
};

// Toggle selected item (add or remove from selectedItems)
const toggleSelectItem = (item) => {
  const isAlreadySelected = selectedItems.value.some(
    (selected) => selected.value === item.value
  );
  if (isAlreadySelected) {
    selectedItems.value = selectedItems.value.filter(
      (selected) => selected.value !== item.value
    );
  } else {
    selectedItems.value.push(item);
  }
  emit("items-selected", selectedItems.value);
};

// Check if an item is already selected
const isSelected = (item) => {
   return selectedItems.value.some((selected) => selected.value === item.value);
};

// Remove selected item by index
const removeSelectedItem = (index) => {
  selectedItems.value.splice(index, 1);
  emit("items-selected", selectedItems.value);
};

// Filter items based on search query
const filterItems = () => {
  const query = searchQuery.value.toLowerCase();
  filteredItems.value = props.data.filter((item) => {
    return item.label.toLowerCase().includes(query);
  });
};

// Handle the "viewItems" button, toggle dropdown visibility
const viewItems = () => {
  if (filteredItems.value.length > 0) {
    filteredItems.value = [];
  } else {
    filterItems(); // Local filtering based on search query
  }
};
</script>
