import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const routes = [
    {
        path: '/',
        component: () => import('../views/IndexView.vue'),
        meta: {
            title: 'Home',
        }
    },
    {
        path: '/login',
        component: () => import('../views/Auth/LoginView.vue'),
        meta: {
            requiresGuest: true,
            title: 'Login'
        }
    },
    {
        path: '/register',
        component: () => import('../views/Auth/RegisterView.vue'),
        meta: {
            requiresGuest: true,
            title: 'Register'
        }
    },
    {
        path: '/forgot-password',
        component: () => import('../views/Auth/ForgotPasswordView.vue'),
        meta: {
            requiresGuest: true,
            title: 'Forgot Password'
        }
    },
    {
        path: '/password-reset/:token',
        component: () => import('../views/Auth/ResetPasswordView.vue'),
        meta: {
            requiresGuest: true,
            title: 'Reset Password'
        }
    },
    {
        path: '/dashboard',
        component: () => import('../views/DashboardView.vue'),
        meta: {
            requiresAuth: true,
            title: 'Dashboard'
        }
    },
    {
        path: '/profile',
        component: () => import('../views/Profile/EditView.vue'),
        meta: {
            requiresAuth: true,
            title: 'Profile'
        }
    },
    {
        path: '/links',
        component: () => import('../views/Link/IndexView.vue'),
        meta: {
            requiresAuth: true,
            title: 'Links'
        }
    },
    {
        path: '/links/create',
        component: () => import('../views/Link/CreateView.vue'),
        meta: {
            requiresAuth: true,
            title: 'Create link'
        }
    },
    {
        path: '/links/:id',
        component: () => import('../views/Link/ShowView.vue'),
        meta: {
            requiresAuth: true,
            title: 'Show link'
        }
    },
    {
        path: '/links/:id/edit',
        component: () => import('../views/Link/EditView.vue'),
        meta: {
            requiresAuth: true,
            title: 'Edit link'
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('../views/NotFoundView.vue')
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    document.title = `${to.meta.title} | Your App Name`;

    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!authStore.isAuthenticated) {
            next({
                path: '/login',
            });
        } else {
            next();
        }
    }

    else if (to.matched.some(record => record.meta.requiresGuest)) {
        if (authStore.isAuthenticated) {
            next({ path: '/dashboard' });
        } else {
            next();
        }
    }

    else {
        next();
    }
});

export default router;
