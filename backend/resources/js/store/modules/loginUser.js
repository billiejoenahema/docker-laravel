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
    return state.loginUser;
  },
  isLogin(state) {
    return state.loginUser.id ? true : false;
  },
  hasErrors(state) {
    return state.errors.length ? true : false;
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
            console.log(res.status);
            commit('resetErrors');
          })
          .catch((err) => {
            console.log(err.message);
            commit('setErrors', err.message);
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
        console.log(err);
        commit('setErrors', err);
      });
  },
  async loginUser({ commit }) {
    axios
      .get('/api/login_user')
      .then((res) => {
        commit('resetErrors');
        commit('setLoginUser', res.data.data);
      })
      .catch((err) => {
        console.log(err.message);
        commit('setErrors', err.message);
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
  setErrors(state, data) {
    state.errors = [];
    state.errors.push(data);
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
