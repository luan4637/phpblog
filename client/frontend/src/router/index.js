import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

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
            path: '/about',
            name: 'about',
            component: () => import('../views/AboutView.vue')
        },
        {
            path: '/post/:id',
            name: 'postDetail',
            component: () => import('../views/PostView.vue')
        },
        {
            path: '/latest',
            name: 'latest',
            component: () => import('../views/LatestPostsView.vue')
        },
        {
            path: '/search/:searchQuery',
            name: 'search',
            component: () => import('../views/ListPostsView.vue')
        },
        {
            path: '/posts/:category',
            name: 'postsByCategory',
            component: () => import('../views/ListPostsView.vue')
        },
    ]
})

export default router
