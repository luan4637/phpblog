import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CategoryView from '../views/category/CategoryView.vue'
import NotificationView from '../views/notification/NotificationView.vue'

const router = createRouter({
    //history: createWebHistory(import.meta.env.BASE_URL),
    history: createWebHashHistory(),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('../views/login/LoginView.vue')
        },
        {
            path: '/post/:id',
            name: 'postEdit',
            component: () => import('../views/post/PostFormView.vue')
        },
        {
            path: '/post/create',
            name: 'postCreate',
            component: () => import('../views/post/PostFormView.vue')
        },
        { //categories management
            path: '/category',
            name: 'category',
            component: CategoryView
        },
        {
            path: '/category/:id',
            name: 'categoryEdit',
            component: () => import('../views/category/CategoryFormView.vue')
        },
        {
            path: '/category/create',
            name: 'categoryCreate',
            component: () => import('../views/category/CategoryFormView.vue')
        },
        { //users management
            path: '/user',
            name: 'user',
            component: () => import('../views/user/UserView.vue')
        },
        {
            path: '/user/:id',
            name: 'userEdit',
            component: () => import('../views/user/UserFormView.vue')
        },
        {
            path: '/user/create',
            name: 'userCreate',
            component: () => import('../views/user/UserFormView.vue')
        },
        { //notifications management
            path: '/notification',
            name: 'notification',
            component: NotificationView
        },
    ]
})

export default router
