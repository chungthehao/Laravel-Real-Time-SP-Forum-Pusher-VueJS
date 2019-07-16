import User from './User';

class Exception {
    handle(error) {
        // Xem thêm ở app/Exceptions/Handler@render
        this.isExpired(error.response.data.error);
    }

    isExpired(errMsg) {
        // Xem thêm ở app/Exceptions/Handler@render
        if (errMsg === 'Token is expired.') {
            User.logout();
        }
    }
}

export default Exception = new Exception();