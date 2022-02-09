import { createRouter, createWebHistory } from 'vue-router';
import Hello from '../pages/Hello';
import LoginRegister from '../pages/LoginRegister';

const routes = [
  {
    path: '/',
    component: Hello,
  },
  {
    path: '/login',
    component: LoginRegister,
  },
  //   {
  //     path: '/:catchAll(.*)',
  //     component: NotFound,
  //   },
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
});

export default router;
