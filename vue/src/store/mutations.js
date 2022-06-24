// toogle loading component start/stop
const toggleLoading = (state, value) => {
  state.loading = value
};

// set current auth user data
const setUser = (state, user) => { 
  sessionStorage.setItem('USER_DATA', JSON.stringify(user));
  state.user.data = user;
};

// set current auth user token
const setToken = (state, token) => {
  sessionStorage.setItem('TOKEN', token);
  state.user.token = token;
};

// logout current auth user from app
const logout = (state) => {
  state.user.token = null;
  state.user.data = {};
  sessionStorage.removeItem("TOKEN");
  sessionStorage.removeItem("USER_DATA");
};

const setAllSurveys = (state, data) => {
  data.map(element => {
    element.toEdit = JSON.parse(element.toEdit);
    element.toOpen = JSON.parse(element.toOpen);
  });
  state.allSurveys = data;
};

const setDashboardSurveys = (state, data) => {
  data.map(element => {
    element.toEdit = JSON.parse(element.toEdit);
    element.toOpen = JSON.parse(element.toOpen);
  });
  state.dashboardSurveys = data;
}

const setDashboardNumbers = (state, data) => {
  state.dashboardNumbers = data;
}

// set new survey after created newSurvey
const setNewSurvey = (state, data) => {
  state.newSurvey = data;
};


export default {
  toggleLoading,
  setUser,
  setToken,
  logout,
  setAllSurveys,
  setNewSurvey,
  setDashboardSurveys,
  setDashboardNumbers,
};