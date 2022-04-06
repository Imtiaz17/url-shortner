// Page Components
import Home from "./views/pages/Home";
import Link from "./views/pages/Link";
import Short from "./views/pages/Short";

export default [
    { path: "/", component: Home, name: 'Home' },
    { path: '/:link', component: Link, name:'Link' },
    { path: '/short/:link', component: Short, name:'Short' },
];
