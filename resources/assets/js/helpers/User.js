import Token from './Token';
import AppStorage from './AppStorage';

class User {
    login(credentials) {
        axios.post('/api/auth/login', credentials)
            .then(res => this.responseAfterLogin(res))
            .catch(err => console.log(err.response.data));
    }

    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user;
        if (Token.isValid(access_token)) {
            AppStorage.store(user, access_token);
            window.location.assign('/forum');
        }
    }

    hasToken() {
        const storedToken = AppStorage.getToken();
        if (storedToken) {
            return Token.isValid(storedToken);
        }
        return false;
    }

    loggedIn() {
        return this.hasToken();
    }

    logout() {
        AppStorage.clear();
        window.location.assign('/forum');
    }

    name() {
        return this.loggedIn() ? AppStorage.getUser() : null;
    }

    id() {
        if (this.loggedIn()) {
            const payload = Token.payload(AppStorage.getToken());
            return payload.sub;
        }
        return null;
    }

    own(userId) {
        return this.id() == userId;
    }

    admin() {
        return this.id() == 12;
    }
}

export default User = new User();