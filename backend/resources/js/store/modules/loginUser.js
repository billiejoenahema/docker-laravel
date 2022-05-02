import axios from 'axios';

const state = {
  loginUser: {
    id: null,
    name: '',
    email: '',
    created_at: null,
  },
  errors: [],
};

const getters = {
  loginUser(state) {
    return state.loginUser ?? {};
  },
  isLogin(state) {
    return state.loginUser && state.loginUser.id > 0;
  },
  errors(state) {
    return state.errors ?? [];
  },
  hasErrors(state) {
    return state.errors?.length > 0;
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
