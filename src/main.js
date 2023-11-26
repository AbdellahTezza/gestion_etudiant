import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import "normalize.css";
// call fontawesome
// import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
// import { lebrary } from "@fortawesome/fontawesome-svg-core";
// import { far } from "@fortawesome/free-regular-svg-icons";
// import { fas } from "@fortawesome/free-solid-svg-icons";

// lebrary.add(fas, far);

createApp(App).use(store).use(router).mount("#app");
