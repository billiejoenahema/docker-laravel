import axios from 'axios';

const state = {
  loginUser: {
    id: null,
    name: '',
    email: '',
    createdAt: null,
  },
  errors: [],
};

const getters = {
  loginUser(state) {
    return state.loginUser ?? {};
  },
  isLogin(state) {
    return state.loginUser.id ? true : false;
  },
  hasErrors(state) {
    return state.errors.length ? true : false;
  },
  errors(state) {
    return state.errors ?? [];
  },
};

const actions = {
  async get({ commit }) {
    await axios
      .get('/api/login_user')
      .then((res) => {
        commit('resetErrors');
        commit('setLoginUser', res.data.data);
      })
      .catch((err) => {
        console.log(err);
        commit('setErrors', err.message);
        commit('setLoginUser', {});
      });
  },
};

const mutations = {
  setLoginUser(state, data) {
    state.loginUser = data;
  },
  setErrors(state, data) {
    state.errors = [];
    state.errors.push(data);
  },
  resetErrors(state) {
    state.errors = [];
    state.hasErrors = false;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
