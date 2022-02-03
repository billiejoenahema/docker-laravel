import { createRouter, createWebHistory } from 'vue-router';
import Hello from '../pages/Hello';

const routes = [
  {
    path: '/',
    component: Hello,
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
