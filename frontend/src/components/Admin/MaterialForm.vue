<template>
  <form @submit.prevent="onSubmit" class="">
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input
        v-model="localMaterial.name"
        type="text"
        class="form-control"
        required
        placeholder="Enter material name"
      />
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea
        v-model="localMaterial.description"
        class="form-control"
        required
        placeholder="Enter description"
      ></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Price (€)</label>
      <input
        v-model.number="localMaterial.price"
        type="number"
        class="form-control"
        min="0"
        step="0.01"
        required
        placeholder="Enter price"
        inputmode="decimal"
        pattern="^\d+(\.\d{1,2})?$"
      />
    </div>
    <div class="mb-3">
      <label class="form-label">Seller</label>
      <input
        v-model="localMaterial.seller"
        type="text"
        class="form-control"
        required
        placeholder="Enter seller name"
      />
    </div>
    <div class="mb-3">
      <label class="form-label">Location</label>
      <input
        v-model="localMaterial.location"
        type="text"
        class="form-control"
        required
        placeholder="Enter location"
      />
    </div>
    <div class="mb-3">
      <label class="form-label">Quantity</label>
      <input
        v-model.number="localMaterial.quantity"
        type="number"
        class="form-control"
        min="0"
        step="1"
        required
        placeholder="Enter quantity"
        inputmode="numeric"
        pattern="^\d+$"
      />
    </div>
    <div class="mb-3">
      <label class="form-label">Status</label>
      <select v-model="localMaterial.status" class="form-select" required>
        <option value="In Stock">In Stock</option>
        <option value="Out of Stock">Out of Stock</option>
      </select>
    </div>
    <div class="d-flex justify-content-end gap-2">
      <button type="button" class="btn btn-secondary" @click="$emit('cancel')">
        Cancel
      </button>
      <button type="submit" class="btn btn-primary">
        {{ mode === 'edit' ? 'Update' : 'Add' }} Material
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useMaterialStore } from '@/stores/materialStore'

const props = defineProps({
  mode: { type: String, default: 'add' },
  material: { type: Object, default: null }
})

const emit = defineEmits(['saved', 'cancel'])
const materialStore = useMaterialStore()

const localMaterial = ref({
  name: '',
  description: '',
  price: 0,
  quantity: 0,
  seller: '',
  status: 'In Stock',
  location: '',
  image: ''
})

watch(
  () => props.material,
  (newVal) => {
    if (newVal) {
      localMaterial.value = { ...localMaterial.value, ...newVal }
    } else {
      localMaterial.value = {
        name: '',
        description: '',
        price: 0,
        quantity: 0,
        seller: '',
        status: 'In Stock',
        location: '',
        image: ''
      }
    }
  },
  { immediate: true }
)

async function onSubmit() {
  if (props.mode === 'add') {
    await materialStore.addMaterial(localMaterial.value)
  } else if (props.mode === 'edit' && props.material?.id) {
    await materialStore.editMaterial(props.material.id, localMaterial.value)
  }
  emit('saved')
}
</script>