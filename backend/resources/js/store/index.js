import { createStore } from 'vuex';

import auth from './modules/auth';
import loginUser from './modules/loginUser';

export const store = createStore({
  modules: {
    auth,
    loginUser,
  },
});
