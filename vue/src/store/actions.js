import axiosClient from "../axios";

// api for register new user and then set data and token
const register = ({commit}, user) => {
  return axiosClient.post('/register', user)
    .then((response) => {
      commit('setUser', response.data.user);
      commit('setToken', response.data.token);
      return response.data;
    });
};

// api for login user and then set data and token
const login = ({commit}, user) => {
  return axiosClient.post('/login', user)
    .then((response) => {
      commit('setUser', response.data.user);
      commit('setToken', response.data.token)
      return response.data;
    });
};

// api for logout current user
const logout = ({commit}) => {
  return axiosClient.post('/logout')
    .then((response) => {
      commit('logout');
      return response.data;
    });
};

// api for get specific data (countable) for user dashboard (Dashboard.vue)
const getDashboardNumbers = ({commit}) => {
  commit('toggleLoading', true);
  return axiosClient.get('/getDashboardNumbers')
    .then((response) => {
      commit('toggleLoading', false);
      commit('setDashboardNumbers', response.data.data);
      return response.data;
    });
};

// api for get specific card data for user dashboard (Dashboard.vue -> CountCardComponent.vue)
const getDashboardSurveys = ({commit}) => {
  commit('toggleLoading', true);
  return axiosClient.get('/getDashboardSurveys')
    .then((response) => {
      commit('toggleLoading', false);
      commit('setDashboardSurveys', response.data.data)
      return response.data;
    });
};

// api for get all surveys from DB (Surveys.vue) 
const getAllSurveys = ({commit}) => {
  commit('toggleLoading', true);
  return axiosClient.get('/survey')
    .then((response) => {
      commit('toggleLoading', false);
      commit('setAllSurveys', response.data.data);
      return response.data
    });
};

// api for saving new survey
const saveSurvey = ({commit}, survey) => {
  return axiosClient.post('/survey', survey)
    .then((response) => {
      commit('setNewSurvey', response.data.data);
      return response.data;
    });
};

// api for get one survey by slug
const getSurveyBySlug = ({commit}, slug) => {
  return axiosClient.get(`/survey/${slug}`)
    .then((response) => {
      commit('setNewSurvey', response.data.data);
      return response.data;
    });
};

// api for submit answers on survey
const submitSurvey = ({commit}, answers) => {
  return axiosClient.post('/submitSurveyAnswers', answers)
    .then((response) => {
      return response.data;
    });
};


export default {
  register,
  login,
  logout,
  getDashboardNumbers,
  getDashboardSurveys,
  getAllSurveys,
  saveSurvey,
  getSurveyBySlug,
  submitSurvey
};