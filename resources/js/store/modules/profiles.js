const actions = {
  FETCH: "action_fetchProfile",
  SET: "action_setProfile",
  STORE: "action_storeProfile",
  UPDATE: "action_updateProfile",
  DESTROY: "action_destroyProfile"
};
const mutations = {
  PAGINATE: "mutation_paginate",
  FETCH: "mutation_fetchProfile",
  SET: "mutation_setProfile",
  STORE: "mutation_storeProfile",
  UPDATE: "mutation_updateProfile",
  DESTROY: "mutation_destroyProfile",
  FAILURE: "mutation_failureProfile"
};

export const ProfileActions = actions;

export default {
  state: {
    profileList: []
  },
  getters: {
    getProfileList: state => state
  },

  mutations: {
    [mutations.PAGINATE]: (state, payload) => (state.pages = payload.data),

    [mutations.SET]: (state, payload) =>
      state.profileList.push(...payload.profiles),

    [mutations.FETCH]: (state, payload) =>
      state.profileList.push(...payload.data),

    [mutations.STORE]: (state, payload) => {
      // const index = state.profileList.findIndex(
      //   profile => profile.id === payload.profile.profile_id
      // );
      // console.log(payload);
      // Vue.set(state.profileList, index, {
      //   ...state.profileList[index],
      //   replies: [...state.profileList[index].replies, ...payload.data]
      // });
      // state.profileList.unshift(payload.profile);
    },

    [mutations.UPDATE]: (state, payload) => {
      const index = state.profileList.findIndex(
        profile => profile.id === payload.profile.id
      );

      if (index !== -1) {
        state.profileList.splice(index, 1, payload.profile);
      }
    },

    [mutations.DESTROY]: (state, payload) => {
      const index = state.profileList.findIndex(
        profile => profile.id === payload.id
      );

      if (index !== -1) {
        state.profileList.splice(index, 1);
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

    async [actions.SET]({ commit }, data) {
      commit(mutations.SET, data);
    },

    async [actions.STORE]({ commit }, data) {
      try {
        const res = await window.axios.profile(`/p`, data);
        commit(mutations.STORE, { profile: res.data });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    },
    async [actions.UPDATE]({ commit }, data) {
      try {
        const res = await window.axios.put(`/p/${data.id}`, data);
        commit(mutations.UPDATE, { profile: res.data });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    },
    async [actions.DESTROY]({ commit }, data) {
      try {
        const res = await window.axios.delete(`/p/${data.id}`, data);
        commit(mutations.DESTROY, { profile: res.data });
      } catch (error) {
        commit(mutations.FAILURE, { error });
      }
    }
  }
};
