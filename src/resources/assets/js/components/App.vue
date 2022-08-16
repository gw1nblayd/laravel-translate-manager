<template>
  <div>
    <Header
      :languages="languages"
      @loadTranslates="loadTranslates"
    />

    <div
      class="w-full flex flex-wrap mx-auto px-2 pt-8 lg:pt-16 mt-16"
    >
      <SideBar
        v-if="translates"
      />
      <Content
        v-if="translates"
        @loadTranslates="loadTranslates"
      />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import helper from '../helpers/helper';

import Header from './Layout/Header';
import SideBar from './Layout/SideBar';
import Content from './Layout/Content';

export default {
  name: 'App',
  components: { SideBar, Content, Header },

  data() {
    return {
      languages: [],
    }
  },

  computed: {
    translates() {
      return this.$store.state.translates;
    },
  },

  methods: {
    loadLanguages() {
      axios.get(helper.url('languages'))
        .then(response => {
          this.languages = response.data;
        })
        .catch((e) => {
        });
    },

    loadTranslates() {
      axios.get(helper.url(`translates/${helper.lang()}`))
        .then(response => {
          this.$store.commit('setTranslates', response.data);
        })
        .catch((e) => {
        });
    },
  },

  created() {
    this.loadLanguages();
  }
};
</script>