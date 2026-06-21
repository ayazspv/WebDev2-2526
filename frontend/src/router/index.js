import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import NotFound from '../views/404.vue';
import Materials from '../views/Materials.vue'
import MaterialDetail from '../views/MaterialDetail.vue'
import Login from '../components/Auth/Login.vue';
import Register from '../components/Auth/Register.vue';
import ManagerOrders from '../components/Admin/ManagerOrders.vue';
import ManagerUsers from '../components/Admin/ManagerUsers.vue';
import ManagerMaterials from '../components/Admin/ManagerMaterials.vue';
import ManagerDashboard from '@/components/Admin/ManagerDashboard.vue';
import UserDashboard from '@/components/User/UserDashboard.vue';
import Cart from  '@/components/Cart/Cart.vue';
import Checkout from '@/components/Cart/Checkout.vue';
import OrderSuccess from '@/components/Cart/OrderSuccess.vue';

// Import your Pinia store
import { useUserStore } from '@/stores/userStore';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: { layout: 'AppLayout' }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: NotFound,
        meta: { layout: 'none' }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { layout: 'AuthLayout' }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: { layout: 'AuthLayout' }
    },
    {
        path: '/dashboard',
        meta: { layout: 'DashboardLayout', requiresAuth: true },
        children: [
            {
                path: '',
                name: 'Dashboard',
                component: ManagerDashboard,
                meta: { layout: 'DashboardLayout', isManager: true, requiresAuth: true },
            },
            {
                path: 'materials',
                name: 'DashboardMaterials',
                component: ManagerMaterials,
                meta: { layout: 'DashboardLayout', isManager: true, requiresAuth: true },
            },
            {
                path: 'orders',
                name: 'DashboardOrders',
                component: ManagerOrders,
                meta: { layout: 'DashboardLayout', isManager: true, requiresAuth: true },
            },
            {
                path: 'users',
                name: 'DashboardUsers',
                component: ManagerUsers,
                meta: { layout: 'DashboardLayout', isManager: true, requiresAuth: true },
            },
            {
                path: 'user',
                name: 'UserDashboard',
                component: UserDashboard,
                meta: { layout: 'DashboardLayout', isManager: false, requiresAuth: true },
            },
        ]
    },
    {
        path: '/materials',
        name: 'Materials',
        component: Materials,
        meta: { layout: 'AppLayout' }
    },
    {
        path: '/materials/:id',
        name: 'MaterialDetail',
        component: MaterialDetail,
        meta: { layout: 'AppLayout' }
    },
    {
        path: '/cart',
        name: 'Cart',
        component: Cart,
        meta: { layout: '' }
    },
    {
        path: '/checkout',
        name: 'Checkout',
        component: Checkout,
        meta: { layout: '' }
    },
    {
        path: '/order-success',
        name: 'OrderSuccess',
        component: OrderSuccess,
        meta: { layout: 'none' }
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
  const userStore = useUserStore();
  const isAuthenticated = !!userStore.token;

  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isAuthenticated) {
      return next({ name: 'Login' });
    }
    if (!userStore.user) {
      await userStore.fetchMe?.();
    }
    const userRole = userStore.user?.role;

    // Only allow admins to access admin dashboard routes
    if (to.path.startsWith('/dashboard') && !to.path.startsWith('/dashboard/user') && userRole !== 'admin') {
      return next({ name: 'UserDashboard' });
    }
    // Only allow users to access user dashboard
    if (to.path === '/dashboard/user' && userRole === 'admin') {
      return next({ name: 'Dashboard' });
    }
    return next();
  } else {
    return next();
  }
});

export default router;

