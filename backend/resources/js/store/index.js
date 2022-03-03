import { createStore } from 'vuex';

import auth from './modules/auth';
import loginUser from './modules/loginUser';
import memos from './modules/memos';

export const store = createStore({
  modules: {
    auth,
    loginUser,
    memos,
  },
});
