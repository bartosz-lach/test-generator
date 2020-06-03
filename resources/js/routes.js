import Home from "./components/Home";
import Tests from "./components/test/Tests";
import Test from "./components/test/TestPage";
import Register from "./components/auth/Register";
import Login from "./components/auth/Login";
import Versions from "./components/version/Versions"
import VersionPage from "./components/version/VersionPage"

export const routes = [
    { path: '/register', name: 'register', component: Register },
    { path: '/login', name:'login', component: Login },
    { path: '/', redirect: '/tests', component: Home },
    { path: '/tests', name:'tests', component: Tests },
    { path: '/tests/:id', name: 'test', component: Test },
    { path: '/tests/:id/test-versions', name: 'testVersions', component: Versions },
    { path: '/test-version/:id', name: 'testVersion', component: VersionPage },

];
