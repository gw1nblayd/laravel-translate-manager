import { createApp } from 'vue';
import { createStore } from 'vuex'
import App from './components/App.vue';

const store = createStore({
  state() {
    return {
      selectedBlock: '',

      translates: null,
      searchableItems: null,

      isSearch: false,
      loading: false,
    }
  },
  mutations: {
    setSelectedBlock(state, block) {
      state.selectedBlock = block;
    },

    setTranslates(state, translates) {
      state.translates = translates;
    },

    setSearchableItems(state, searchableItems) {
      state.searchableItems = searchableItems;
    },

    setIsSearch(state, isSearch) {
      state.isSearch = isSearch;
    },

    loadingOn(state) {
      state.loading = true;
    },

    loadingOff(state) {
      state.loading = false;
    }
  }
})

window.VueApp = createApp(App);
window.VueApp.use(store);
window.VueApp.mount('#app');
