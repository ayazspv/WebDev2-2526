<template>
  <form @submit.prevent="onSubmit">
    <div class="mb-3">
      <label class="form-label">First Name</label>
      <input v-model="localUser.firstname" type="text" class="form-control" required placeholder="Enter user's first name" />
    </div>
    <div class="mb-3">
      <label class="form-label">Last Name</label>
      <input v-model="localUser.lastname" type="text" class="form-control" required placeholder="Enter user's last name" />
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input v-model="localUser.email" type="email" class="form-control" required placeholder="Enter user's email" />
    </div>
    <div class="mb-3">
      <label class="form-label">Phone number</label>
      <input v-model="localUser.phoneNumber" type="tel" class="form-control" required placeholder="Enter user's phone number" />
    </div>
    <div class="mb-3">
      <label class="form-label">Password</label>
      <input v-model="localUser.password" type="password" class="form-control" :required="mode === 'add'" placeholder="Enter password" autocomplete="new-password" />
      <small v-if="mode === 'edit'" class="text-muted">Leave blank to keep current password</small>
    </div>
    <div class="mb-3">
      <label class="form-label">Status</label>
      <select v-model="localUser.status" class="form-select" required>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Role</label>
      <select v-model="localUser.role" class="form-select" required>
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
    </div>
    <div class="d-flex justify-content-end gap-2">
      <button type="button" class="btn btn-secondary" @click="$emit('cancel')">
        Cancel
      </button>
      <button type="submit" class="btn btn-primary">
        {{ mode === 'edit' ? 'Update' : 'Add' }} User
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useUserStore } from '@/stores/userStore'

const props = defineProps({
  mode: { type: String, default: 'add' },
  user: { type: Object, default: null }
})

const emit = defineEmits(['saved', 'cancel'])
const userStore = useUserStore()

const localUser = ref({
  firstname: '',
  lastname: '',
  role: 'user',
  email: '',
  password: '',
  phoneNumber: '',
  status: 'active',
})

// Only initialize when the form is opened or user changes (not on every prop update)
watch(
  () => props.user,
  (newVal, oldVal) => {
    if (props.mode === 'edit' && newVal && newVal !== oldVal) {
      localUser.value = {
        firstname: newVal.firstname ?? newVal.firstName ?? '',
        lastname: newVal.lastname ?? newVal.lastName ?? '',
        email: newVal.email ?? '',
        role: newVal.role ?? 'user',
        password: '',
        phoneNumber: newVal.phoneNumber ?? newVal.phone ?? '',
        status: newVal.status ?? 'active'
      }
    } else if (props.mode === 'add') {
      localUser.value = {
        firstname: '',
        lastname: '',
        role: 'user',
        email: '',
        password: '',
        phoneNumber: '',
        status: 'active'
      }
    }
  },
  { immediate: true }
)

async function handleFormSubmit(user) {
  console.log('Form submitted user:', user)
}

function onSubmit() {
  if (!localUser.value.firstname) {
    alert('First name is required');
    return;
  }
  if (!localUser.value.lastname) {
    alert('Last name is required');
    return;
  }
  emit('saved', {
    firstname: localUser.value.firstname,
    lastname: localUser.value.lastname,
    email: localUser.value.email,
    role: localUser.value.role,
    password: localUser.value.password,
    phoneNumber: localUser.value.phoneNumber,
    status: localUser.value.status
  });
}
</script>