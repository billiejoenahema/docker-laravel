import axios from 'axios';

const state = {
  data: [],
  errors: [],
};

const getters = {
  data(state) {
    return state.data ?? [];
  },
  errors(state) {
    return state.errors;
  },
};

const actions = {
  async get({ commit }) {
    await axios
      .get('/api/memos')
      .then((res) => {
        commit('resetErrors', []);
        commit('setData', res.data);
      })
      .catch((err) => {
        commit('setErrors', err.message);
      });
  },
  async post({ commit }, memo) {
    await axios
      .post('/api/memos', memo)
      .then((res) => {
        commit('resetErrors');
        console.log(res.data.data);
      })
      .catch((err) => {
        console.log(err.message);
        commit('setErrors', err.message);
      });
  },
  async update({ commit }, memo) {
    await axios
      .patch(`/api/memos/${memo.id}`, memo)
      .then((res) => {
        commit('resetErrors');
        console.log(res.data.data);
      })
      .catch((err) => {
        console.log(err.message);
        commit('setErrors', err.message);
      });
  },
  async delete({ commit }, id) {
    await axios
      .delete(`/api/memos/${id}`)
      .then((res) => {
        commit('resetErrors');
        console.log(res.data.data);
      })
      .catch((err) => {
        console.log(err.message);
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
