const App = new Vue({
  el: "#app-navigation",
  data: {
    isMenuActive: false,
    isSearchActive: false
  },
  methods: {
    toggleMenu() {
      this.isMenuActive = !this.isMenuActive;
    },
    toggleSearch() {
      this.isSearchActive = !this.isSearchActive;
    }
  }
});