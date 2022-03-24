import { createStore } from 'vuex';

import auth from './modules/auth';
import loginUser from './modules/loginUser';
import memos from './modules/memos';
import tags from './modules/tags';
import toast from './modules/toast';

export const store = createStore({
  modules: {
    auth,
    loginUser,
    memos,
    tags,
    toast,
  },
});
