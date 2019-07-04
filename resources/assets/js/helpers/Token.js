class Token {
    isValid(token) {
        const payload = this.payload(token);
        //console.log(payload.iss)
        if (payload) {
            return payload.iss === 'http://localhost:8000/api/auth/login' || 'http://localhost:8000/api/auth/signup';
        }
        return false;
    }

    payload(token) {
        const payload = token.split('.')[1];
        return this.decode(payload);
    }

    decode(payload) {
        return JSON.parse(atob(payload)) // atob giải base64
    }
}

export default Token = new Token();