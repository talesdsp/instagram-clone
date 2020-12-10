const actions = {
  TOGGLE: "action_toggleFav"
};
const mutations = {
  TOGGLE: "mutation_toggleFav",
  FAILURE: "mutation_failureTogglingFav"
};

export const FavoriteActions = actions;

export default {
  state: {
    fav: new Int8Array(0)
  },
  getters: {},
  mutations: {
    [mutations.TOGGLE]: (state, payload) => {
      state.fav = new Int8Array(1);
    },

    [mutations.FAILURE]: (_, { error }) => {
      if (error.response && error.response.status == 401) {
        window.location = "/login";
      } else {
        console.log(error);
      }
    }
  },

  actions: {
    async [actions.TOGGLE]({ commit }, data) {
      try {
        const res = await window.axios.post(`/fav/${data.id}`);

        commit(mutations.TOGGLE, { fav: res.data });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    }
  }
};
