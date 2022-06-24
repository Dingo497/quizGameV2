import { createStore } from "vuex";

import actions from './actions.js';
import mutations from './mutations.js';

const store = createStore({
  state: {
    // current auth user
    user: {
      data: JSON.parse(sessionStorage.getItem('USER_DATA')),
      token: sessionStorage.getItem('TOKEN'),
    },
    // start/stop loading
    loading: false,
    allSurveys: null,
    dashboardSurveys: null,
    dashboardNumbers: null,
    // default types of questions for create survey
    questionTypes: ["text", "select", "radio", "checkbox", "textarea"],
    // new survey what I created
    newSurvey: null,
  },
  actions,
  mutations,
});


export default store;