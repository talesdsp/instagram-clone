const actions = {
  FETCH: "action_fetchPost",
  LIKE: "action_likePost",
  SET: "action_setPost",
  STORE: "action_storePost",
  UPDATE: "action_updatePost",
  DESTROY: "action_destroyPost"
};
const mutations = {
  PAGINATE: "mutation_paginatePost",
  FETCH: "mutation_fetchPost",
  SET: "mutation_setPost",
  STORE: "mutation_storePost",
  UPDATE: "mutation_updatePost",
  DESTROY: "mutation_destroyPost",
  FAILURE: "mutation_failurePost"
};

export const PostActions = actions;

export default {
  state: {
    postList: []
  },
  getters: {
    getPosts: state => state.postList
  },

  mutations: {
    [mutations.PAGINATE]: (state, payload) => (state.pages = payload.data),

    [mutations.SET]: (state, payload) => state.postList.push(...payload.posts),

    [mutations.FETCH]: (state, payload) => state.postList.push(...payload.data),

    [mutations.STORE]: (state, payload) => {
      // const index = state.postList.findIndex(
      //   post => post.id === payload.post.post_id
      // );
      // console.log(payload);
      // Vue.set(state.postList, index, {
      //   ...state.postList[index],
      //   replies: [...state.postList[index].replies, ...payload.data]
      // });
      // state.postList.unshift(payload.post);
    },

    [mutations.UPDATE]: (state, payload) => {
      const index = state.postList.findIndex(
        post => post.id === payload.post.id
      );

      if (index !== -1) {
        state.postList.splice(index, 1, payload.post);
      }
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
          res = await window.axios.get(`/p/${data.id}`);
        }
        commit(mutations.FETCH, { id: data.id, data: res.data.data });
        commit(mutations.PAGINATE, { id: data.id, data: res.data });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    },

    async [actions.LIKE]({ commit }, data) {
      let res;
      try {
        res = await window.axios.post(`/like/p/${data.id}`);
        commit(mutations.LIKE, data);
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
    async [actions.UPDATE]({ commit }, data) {
      try {
        const res = await window.axios.put(`/p/${data.id}`, data);
        commit(mutations.UPDATE, { post: res.data });
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
