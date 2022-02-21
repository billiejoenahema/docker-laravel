import { createRouter, createWebHistory } from 'vue-router';
import LoginRegister from '../pages/LoginRegister';
import NotFound from '../pages/NotFound.vue';
import TopPage from '../pages/TopPage';

const routes = [
  {
    path: '/',
    component: TopPage,
  },
  {
    path: '/login',
    component: LoginRegister,
  },
  {
    path: '/:catchAll(.*)',
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
});

export default router;
