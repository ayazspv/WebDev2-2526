<script setup>
import { ref, computed, onMounted } from 'vue'
import { useUserStore } from '@/stores/userStore'
import UserForm from './UserForm.vue'

const userStore = useUserStore()
const showForm = ref(false)
const formMode = ref('add') // 'add' or 'edit'
const selectedUser = ref(null)

onMounted(async () => {
  if (!userStore.users.length) {
    await userStore.fetchAllUsers()
    console.log('Fetched users:', userStore.users)
  }
})

const users = computed(() => userStore.users)

function openAddForm() {
  formMode.value = 'add'
  selectedUser.value = null
  showForm.value = true
}

function openEditForm(user) {
  console.log('Edit user:', user)
  formMode.value = 'edit'
  selectedUser.value = { ...user }
  showForm.value = true
}

async function handleFormSubmit(user) {
  if (formMode.value === 'add') {
    await userStore.addUser({ ...user })
  } else if (formMode.value === 'edit') {
    const userData = {
      firstname: user.firstname,
      lastname: user.lastname,
      email: user.email,
      role: user.role,
      phoneNumber: user.phoneNumber,
      status: user.status
    }
    if (user.password) {
      userData.password = user.password
    }
    await userStore.editUser(selectedUser.value.id, userData)
  }
  await userStore.fetchAllUsers()
  showForm.value = false
}

async function handleDelete(user) {
  await userStore.deleteUser(user.id)
  showForm.value = false
}
</script>

<template>
  <!-- Users Section -->
  <section>
    <div class="section-header mb-3 d-flex align-items-center justify-content-between">
      <div class="section-header mb-3 d-flex align-items-center">
        <i class="fas fa-users section-icon text-primary"></i>
        <h4 class="fw-semibold mb-0 ms-2">Users</h4>
      </div>
      <button class="btn btn-primary" @click="openAddForm">
        <i class="fas fa-plus"></i> Add User
      </button>
    </div>
    <div class="card shadow-lg border-0 rounded-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>User ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Active</th>
              <th>Phone</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>
                {{ user.id }}
                <span style="display:none">{{ console.log('Table user:', user) }}</span>
              </td>
              <td class="fw-semibold">{{ user.name || (user.firstname + ' ' + user.lastname) }}</td>
              <td>{{ user.email }}</td>
              <td>
                <span
                  :class="{
                    'badge bg-success': user.status === 'active',
                    'badge bg-secondary': user.status === 'inactive',
                    'badge bg-warning': user.status === 'pending'
                  }"
                >
                  {{ user.status ? user.status.charAt(0).toUpperCase() + user.status.slice(1) : 'Unknown' }}
                </span>
              </td>
              <td>{{ user.phone || user.phoneNumber }}</td>
              <td>
                <span class="badge bg-gradient-secondary px-3 py-2">{{ user.role }}</span>
              </td>
              <td>
                <button class="btn btn-sm btn-outline-secondary me-2" @click="openEditForm(user)">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" @click="handleDelete(user)">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- User Form Modal -->
    <div v-if="showForm" class="modal-backdrop">
      <div class="modal-content container w-50">
        <UserForm
          :mode="formMode"
          :user="selectedUser"
          @saved="handleFormSubmit"
          @cancel="showForm = false"
        />
      </div>
    </div>
  </section>
</template>

<style scoped>
.section-icon {
  font-size: 1.6rem;
  background: #e0e7ef;
  border-radius: 12px;
  padding: 0.5rem;
  box-shadow: 0 2px 8px rgba(40, 76, 42, 0.07);
}

.bg-gradient-secondary {
  background: linear-gradient(90deg, #848048 0%, #4f8cff 100%) !important;
  color: #fff !important;
}

.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1050;
}

.modal-content {
  background: #fff;
  border-radius: 1rem;
  padding: 2rem;
  min-width: 350px;
  box-shadow: 0 2px 24px rgba(0, 0, 0, 0.15);
}
</style>