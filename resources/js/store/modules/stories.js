const actions = {
  FETCH: "a_fetchStory",
  WATCH: "a_likeStory",
  SET: "a_setStory",
  DESTROY: "a_destroyImage"
};
const mutations = {
  PAGINATE: "m_paginateStory",
  FETCH: "m_fetchStory",
  SET: "m_setStory",
  WATCH: "m_watchStory",
  DESTROY: "m_destroyStory",
  FAILURE: "m_failureStory"
};

export const StoryActions = actions;

export default {
  state: {
    storyList: [],
    pages: null
  },
  getters: {
    getStories: state => state.storyList
  },

  mutations: {
    [mutations.PAGINATE]: (state, payload) => (state.pages = payload.data),

    [mutations.SET]: (state, payload) =>
      state.storyList.push(...payload.stories),

    [mutations.FETCH]: (state, payload) =>
      state.storyList.push(...payload.data),

    [mutations.WATCH]: (state, payload) => {
      const profileIndex = state.storyList.findIndex(
        profile => profile.id === payload.profile
      );
      const storyIndex = state.storyList[profileIndex].user_stories.findIndex(
        story => story.id === payload.story
      );

      state.storyList[profileIndex].user_stories[storyIndex].watched_by.push(1);
    },

    [mutations.DESTROY]: (state, payload) => {
      const index = state.postList.findIndex(post => post.id === payload.id);

      if (index !== -1) {
        state.postList.splice(index, 1);
      }
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
    async [actions.FETCH]({ commit }, data) {
      let res;
      try {
        if (data.url) {
          res = await window.axios.get(data.url);
        } else {
          res = await window.axios.get(`/s/${data.id}`);
        }
        commit(mutations.FETCH, { id: data.id, data: res.data.data });
        commit(mutations.PAGINATE, { id: data.id, data: res.data });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    },

    async [actions.WATCH]({ commit }, data) {
      let res;
      try {
        res = await window.axios.post(`/watch/${data.story}`);
        commit(mutations.WATCH, data);
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    },

    async [actions.SET]({ commit }, data) {
      commit(mutations.SET, data);
    },

    async [actions.STORE]({ commit }, data) {
      try {
        const res = await window.axios.post(`/p`, data);
        commit(mutations.STORE, { post: res.data });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    },

    async [actions.DESTROY]({ commit }, data) {
      try {
        const res = await window.axios.delete(`/p/${data.id}`, data);
        commit(mutations.DESTROY, { post: res.data });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    }
  }
};
