import axios from 'axios';

const state = {
  errors: [],
};

const getters = {
  errors(state) {
    return state.errors ?? [];
  },
  hasErrors(state) {
    return state.errors?.length > 0;
  },
};

const actions = {
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
  async login({ commit }, data) {
    await axios
      .get('http://localhost:8080/sanctum/csrf-cookie', {
        withCredentials: true,
      })
      .then(async (res) => {
        console.log(res.status);
        await axios
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
  async logout() {
    await axios.post('/api/logout');
  },
};

const mutations = {
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
