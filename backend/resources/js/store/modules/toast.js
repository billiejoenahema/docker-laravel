const state = {
  data: {},
};

const getters = {
  data(state) {
    return state.data;
  },
};

const mutations = {
  setData(state, data) {
    state.data = data;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
};
