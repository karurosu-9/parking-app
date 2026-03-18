import { createRouter, createWebHistory } from 'vue-router';

const Home = () => import('../pages/Home.vue');


const router = createRouter({
    history: createWebHistory(),
    // フロント用のルーティングの設定
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        }
    ],
    linkActiveClass: 'active'
});

export default router;
