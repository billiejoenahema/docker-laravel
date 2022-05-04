import axios from 'axios';
import { TAG_MESSAGES as MESSAGE } from '../../consts/toastMessage';

const state = {
  data: [],
  errors: [],
  selectedTags: [],
  selectedTagIds: [],
};

const getters = {
  data(state) {
    return state.data ?? [];
  },
  selectedTags(state) {
    return state.selectedTags ?? [];
  },
  selectedTagIds(state) {
    return state.selectedTagIds ?? [];
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
      .get('/api/tags')
      .then((res) => {
        commit('setErrors', []);
        commit('setData', res.data);
      })
      .catch((err) => {
        commit('setErrors', err.message);
      });
  },
  async post({ commit }, newTag) {
    await axios
      .post('/api/tags', newTag)
      .then((res) => {
        commit('resetStates');
        commit('toast/setData', MESSAGE.post.success, { root: true });
        commit('setSelectedTags', res.data);
      })
      .catch((err) => {
        commit('setErrors', err.message);
      });
  },
  async update({ commit }, tag) {
    await axios
      .patch(`/api/tags/${tag.id}`, tag)
      .then((res) => {
        commit('setErrors', []);
        commit('toast/setData', MESSAGE.update.success, { root: true });
        commit('setSelectedTags', res.data);
      })
      .catch((err) => {
        commit('setErrors', err.message);
      });
  },
  async remove({ commit }, { tagId, memoId }) {
    await axios
      .put(`/api/tags/${tagId}`, { memoId })
      .then((res) => {
        commit('setErrors', []);
        commit('toast/setData', MESSAGE.update.success, { root: true });
        commit('setSelectedTags', res.data);
      })
      .catch((err) => {
        commit('setErrors', err.message);
      });
  },
  async delete({ commit }, id) {
    await axios
      .delete(`/api/tags/${id}`)
      .then((res) => {
        commit('setErrors', []);
        if (!res.data.error_message) {
          commit('toast/setData', MESSAGE.delete.success, {
            root: true,
          });
        } else {
          commit('setErrors', res.data.error_message);
          commit('toast/setData', MESSAGE.delete.restrict, { root: true });
        }
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
  setSelectedTags(state, tagIds) {
    state.selectedTagIds = tagIds;
    state.selectedTags = state.data.filter((item) => {
      return tagIds.includes(item.id);
    });
  },
  removeTag(state, index) {
    state.selectedTags.splice(index, 1);
  },
  setErrors(state, data) {
    state.errors = [];
    state.errors.push(data);
  },
  resetStates(state) {
    state.data = [];
    state.selectedTags = [];
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
