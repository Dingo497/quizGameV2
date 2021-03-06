import { createRouter, createWebHistory } from "vue-router";
import store from "../store/store.js";

// VIEWS
import Register from "../views/Register.vue";
import Login from "../views/Login.vue";
import Dashboard from "../views/Dashboard.vue";
import Surveys from '../views/Surveys.vue';
import CreateEditSurvey from '../views/CreateEditSurvey.vue';
import SurveyView from '../views/SurveyView.vue';

// COMPONENTS
import AuthLayout from "../components/AuthLayout.vue";
import DefaultLayout from "../components/DefaultLayout.vue";


const routes = [
  {
    path: '/',
    redirect: '/dashboard',
    component: DefaultLayout,
    meta: { requiresAuth: true },
    children: [
      { path: '/dashboard', name: 'Dashboard', component: Dashboard },
      { path: '/surveys', name: 'Surveys', component: Surveys },
      { path: '/surveys/create', name: 'CreateSurvey', component: CreateEditSurvey },
      { path: '/surveys/:slug', name: 'SurveyView', component: SurveyView },
      // zatial edit nefunkcny je to en zatial
      { path: '/surveys/edit/:slug', name: 'SurveyEdit', component: SurveyView },
    ]
  },
  {
    path: '/auth',
    name: 'Auth',
    component: AuthLayout,
    meta: { isGuest: true },
    children: [
      { path: '/login', name: 'Login', component: Login },
      { path: '/register', name: 'Register', component: Register },
    ]
  },
];


const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  if(to.meta.requiresAuth && !store.state.user.token) {
    next({ name: 'Login' });
  } else if(store.state.user.token && to.meta.isGuest) {
    next({ name: 'Dashboard' });
  } else {
    next();
  }
});

export default router;