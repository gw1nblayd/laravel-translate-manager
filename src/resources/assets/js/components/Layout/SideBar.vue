<template>
  <div class="w-full lg:w-1/5 lg:px-6 text-xl text-gray-800 leading-normal">
    <div class="block lg:hidden sticky inset-0">
      <button
        id="menu-toggle"
        class="flex w-full justify-end px-3 py-3 bg-white lg:bg-transparent border rounded border-gray-600 hover:border-purple-500 appearance-none focus:outline-none"
        @click="isHidden = !isHidden"
      >
        <svg class="fill-current h-3 float-right" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
        </svg>
      </button>
    </div>
    <div
      id="menu-content"
      class="w-full overflow-y-scroll sticky inset-0 max-h-96 min-h-96 overflow-x-hidden lg:block mt-0 border border-gray-400 lg:border-transparent bg-white shadow lg:shadow-none lg:bg-transparent z-20"
      :class="{'hidden': isHidden}"
      style="top:5em;"
    >
      <ul class="list-reset">
        <li
          v-for="(block, index) in blocks"
          :key="`${block}-${index}`"
          class="py-2 md:my-0 hover:bg-purple-100 lg:hover:bg-transparent"
        >
          <button
            class="w-full bg-transparent block pl-4 align-middle text-gray-700 lg:hover:text-purple-500 border-l-4 text-sm lg:text-left"
            :class="{'lg:border-purple-500': block === selectedBlock, 'lg:border-gray-400': block !== selectedBlock}"
            @click="onSelectedBlock(block)"
          >
            {{ block }}
          </button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isHidden: true,
    }
  },

  computed: {
    translates() {
      return this.$store.state.translates;
    },

    selectedBlock() {
      return this.$store.state.selectedBlock;
    },

    isSearch() {
      return this.$store.state.isSearch;
    },

    blocks() {
      const searchableItems = this.$store.state.searchableItems;

      if (!searchableItems) {
        return [];
      }

      if (searchableItems && Object.keys(searchableItems)[0]) {
        this.onSelectedBlock(Object.keys(searchableItems)[0])
      }

      return Object.keys(this.$store.state.searchableItems);
    },
  },

  methods: {
    onSelectedBlock(block) {
      this.$store.commit('setSelectedBlock', block);
    },
  },

  created() {
    this.onSelectedBlock(Object.keys(this.translates)[0]);
  }
}
</script>