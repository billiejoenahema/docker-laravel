import { createStore } from 'vuex';

import loginUser from './modules/loginUser';

export const store = createStore({
  modules: {
    loginUser,
  },
});
