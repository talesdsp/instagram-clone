import { AuthMutations } from "./authentication";

const actions = {
  FETCH: "action_fetchComment",
  LIKE: "action_LikeComment",
  SET: "action_setComment",
  STORE: "action_storeComment",
  UPDATE: "action_updateComment",
  DESTROY: "action_destroyComment",
  HANDLE_ERROR: "action_handleErrorComment"
};
const mutations = {
  PAGINATE: "mutation_paginateComment",
  FETCH: "mutation_fetchComment",
  LIKE: "mutation_likeComment",
  SET: "mutation_setComment",
  STORE: "mutation_storeComment",
  UPDATE: "mutation_updateComment",
  DESTROY: "mutation_destroyComment",
  FAILURE: "mutation_failureComment",
  HANDLE_ERROR: "mutation_handleErrorComment"
};

export const CommentActions = actions;

export default {
  state: {
    commentList: []
  },
  getters: {
    getComments: state => state.commentList
  },

  mutations: {
    [mutations.PAGINATE]: (state, payload) => {
      const index = state.commentList.findIndex(
        comment => comment.id == payload.id
      );

      Vue.set(state.commentList, index, {
        ...state.commentList[index],
        pages: payload.data
      });
    },

    [mutations.SET]: (state, payload) => {
      state.commentList = payload.comments;
    },

    [mutations.FETCH]: (state, payload) => {
      const index = state.commentList.findIndex(
        comment => comment.id == payload.id
      );

      if (!state.commentList[index].replies) {
        state.commentList[index].replies = [];
      }

      state.commentList[index].replies.push(...payload.data);
    },

    [mutations.LIKE]: (state, payload) => {
      if (payload.comment_id > 0) {
        state.commentList;

        const parentIndex = state.commentList.findIndex(
          comment => comment.id == payload.comment_id
        );

        const replyIndex = state.commentList[parentIndex].replies.findIndex(
          comment => comment.id == payload.id
        );

        state.commentList[parentIndex].replies[replyIndex].likes_count =
          payload.likes_count;

        state.commentList[parentIndex].replies[replyIndex].liked =
          payload.liked;
      } else {
        const index = state.commentList.findIndex(
          comment => comment.id == payload.id
        );

        state.commentList[index].likes_count = payload.likes_count;
        state.commentList[index].liked = payload.liked;
      }
    },

    [mutations.STORE]: (state, payload) => {
      if (payload.comment.comment_id > 0) {
        const index = state.commentList.findIndex(
          comment => comment.id == payload.comment.comment_id
        );

        if (!state.commentList[index].replies) {
          state.commentList[index].replies = [];
        }

        state.commentList[index].replies.push(payload.comment);
      } else {
        state.commentList.unshift(payload.comment);
      }
    },

    [mutations.UPDATE]: (state, payload) => {
      const index = state.commentList.findIndex(
        comment => comment.id === payload.comment.id
      );

      if (index !== -1) {
        state.commentList.splice(index, 1, payload.comment);
      }
    },

    [mutations.DESTROY]: (state, payload) => {
      const index = state.commentList.findIndex(
        comment => comment.id == payload.id
      );

      if (index != -1) {
        state.commentList.splice(index, 1);
      }
    },

    [mutations.FAILURE]: (state, { error }) => {
      state.error = error.message;
      console.log(error);
    }
  },

  actions: {
    async [actions.FETCH]({ commit }, data) {
      let res;
      try {
        if (data.url) {
          res = await window.axios.get(data.url);
        } else {
          res = await window.axios.get(`/c/${data.id}`);
        }
        commit(mutations.FETCH, { id: data.id, data: res.data.comments.data });
        commit(mutations.PAGINATE, { id: data.id, data: res.data.comments });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    },

    async [actions.LIKE]({ commit }, data) {
      try {
        await window.axios.post(`/like/c/${data.id}`);
        if (data.liked == 1) {
          data.likes_count -= 1;
        } else {
          data.likes_count += 1;
        }

        data.liked = !data.liked;

        commit(mutations.LIKE, data);
      } catch (error) {
        commit(AuthMutations.THROW, { error });
        commit(mutations.FAILURE, { error });
      }
    },

    async [actions.SET]({ commit }, data) {
      commit(mutations.SET, data);
    },

    async [actions.STORE]({ commit }, data) {
      try {
        const res = await window.axios.post(`/c`, data);
        commit(mutations.STORE, { comment: res.data.comment });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    },
    async [actions.UPDATE]({ commit }, data) {
      try {
        const res = await window.axios.put(`/c/${data.id}`, data);
        commit(mutations.UPDATE, { comment: res.data.comment });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    },
    async [actions.DESTROY]({ commit }, data) {
      try {
        const res = await window.axios.delete(`/c/${data.id}`, data);
        commit(mutations.DESTROY, { comment: res.data.comment });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    }
  }
};
