import axios from 'axios';

const state = {
  loginUser: {
    id: null,
    name: '',
    email: '',
    createdAt: null,
  },
  errors: [],
  hasErrors: false,
};

const getters = {
  isLogin(state) {
    return state.loginUser;
  },
  hasErrors(state) {
    return state.errors.length ?? false;
  },
};

const actions = {
  async login({ commit }, data) {
    axios
      .get('http://localhost:8080/sanctum/csrf-cookie', {
        withCredentials: true,
      })
      .then((res) => {
        console.log(res.status);
        axios
          .post('/api/login', data)
          .then((res) => {
            console.log(res.data);
            commit('setLoginUser', res.data);
            commit('resetErrors');
          })
          .catch((err) => {
            commit('setErrors', err);
          });
      });
  },
  async register({ commit }, data) {
    await axios
      .post('/api/register', data)
      .then((res) => {
        console.log(res.status);
        commit('resetErrors');
      })
      .catch((err) => {
        commit('setErrors', err);
      });
  },
  async loginUser({ commit }) {
    await axios
      .get('/api/login_user')
      .then((res) => {
        commit('setLoginUser', res.data.login_user);
      })
      .catch((err) => {
        commit('setErrors', err);
        commit('setLoginUser', {});
      });
  },
  async logout({ commit }) {
    await axios.post('/api/logout');
    commit('setLoginUser', {});
  },
};

const mutations = {
  setLoginUser(state, data) {
    state.loginUser = data;
  },
  resetErrors(state) {
    state.errors = [];
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
