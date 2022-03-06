import axios from 'axios';

const state = {
  data: [],
};

const getters = {
  data(state) {
    return state.data;
  },
};

const actions = {
  async get({ commit }) {
    await axios
      .get('/api/tags')
      .then((res) => {
        commit('resetErrors', []);
        commit('setData', res.data);
      })
      .catch((err) => {
        commit('setErrors', err.message);
      });
  },
};

const mutations = {
  setData(state, data) {
    state.data = data.data;
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
