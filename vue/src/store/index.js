import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
  state: {
    user: {
      // data: sessionStorage.clear(),
      // token: sessionStorage.clear(),
      data: JSON.parse(sessionStorage.getItem('USER_DATA')),
      token: sessionStorage.getItem('TOKEN'),
    },
    loading: false,
    allSurveys: null,
    questionTypes: ["text", "select", "radio", "checkbox", "textarea"],
    newSurvey: null,

  },


  mutations: {
    toggleLoading: (state, value) => {
      state.loading = value
    },

    setUser: (state, user) => { 
      sessionStorage.setItem('USER_DATA', JSON.stringify(user));
      state.user.data = user;
    },

    setToken: (state, token) => {
      sessionStorage.setItem('TOKEN', token);
      state.user.token = token;
    },

    logout: (state) => {
      state.user.token = null;
      state.user.data = {};
      sessionStorage.removeItem("TOKEN");
      sessionStorage.removeItem("USER_DATA");
    },

    setAllSurveys: (state, data) => {
      state.allSurveys = data;
    },

    setNewSurvey: (state, data) => {
      state.newSurvey = data;
    },
  },


  actions: {
    register({commit}, user) {
      return axiosClient.post('/register', user)
        .then((response) => {
          commit('setUser', response.data.user);
          commit('setToken', response.data.token);
          return response.data;
        });
    },

    login({commit}, user) {
      return axiosClient.post('/login', user)
        .then((response) => {
          commit('setUser', response.data.user);
          commit('setToken', response.data.token)
          return response.data;
        });
    },

    logout({commit}) {
      return axiosClient.post('/logout')
        .then((response) => {
          commit('logout');
          return response.data;
        });
    },

    getDashboardNumbers({commit}) {
      commit('toggleLoading', true);
      return axiosClient.get('/getDashboardNumbers')
        .then((response) => {
          commit('toggleLoading', false);
          return response.data;
        });
    },

    getDashboardSurveys({commit}) {
      commit('toggleLoading', true);
      return axiosClient.get('/getDashboardSurveys')
        .then((response) => {
          commit('toggleLoading', false);
          return response.data;
        });
    },

    getAllSurveys({commit}) {
      commit('toggleLoading', true);
      return axiosClient.get('/survey')
        .then((response) => {
          commit('toggleLoading', false);
          commit('setAllSurveys', response.data.data);
          return response.data
        });
    },

    saveSurvey({commit}, survey) {
      return axiosClient.post('/survey', survey)
        .then((response) => {
          commit('setNewSurvey', response.data.data);
          return response.data;
        });
    },

    getSurveyBySlug({commit}, slug) {
      return axiosClient.get(`/survey/${slug}`)
        .then((response) => {
          commit('setNewSurvey', response.data.data);
          return response.data;
        });
    },

    submitSurvey({commit}, answers) {
      return axiosClient.post('/submitSurveyAnswers', answers)
        .then((response) => {
          return response.data;
        });
    },

  },


  getters: {},
});

export default store;