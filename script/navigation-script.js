new Vue({
  el: "#app-navigation",
  data: {
    isMenuActive: false
  },
  methods: {
    toggleMenu() {
      this.isMenuActive = !this.isMenuActive;
    }
  }
});