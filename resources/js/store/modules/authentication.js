const actions = {
  PROMPT: "action_promptAuth",
  CLOSE: "action_closeAuth",
  THROW: "action_throwAuth"
};
const mutations = {
  PROMPT: "mutation_promptAuth",
  CLOSE: "mutation_closeAuth",
  THROW: "mutation_throwAuth"
};

export const AuthActions = actions;
export const AuthMutations = mutations;

export default {
  state: {
    prompt: false,
    error: ""
  },
  getters: {
    shouldPrompt: state => state.prompt,
    listenErrors: state => state.error
  },

  mutations: {
    [mutations.PROMPT]: (state, _) => {
      state.prompt = true;
    },
    [mutations.CLOSE]: (state, _) => {
      state.prompt = false;
    },
    [mutations.THROW]: (state, payload) => {
      state.error = payload.error;
      state.prompt = true;

      console.dir(payload);
    }
  },

  actions: {
    async [actions.PROMPT]({ commit }) {
      commit(mutations.PROMPT);
    },

    async [actions.CLOSE]({ commit }) {
      commit(mutations.CLOSE);
    },

    async [actions.THROW]({ commit }, { error }) {
      commit(mutations.THROW, { error });
    }
  }
};
