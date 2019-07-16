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
        if (this.isBase64(payload)) {
            return JSON.parse(atob(payload)) // atob giải base64
        }
        return false;
    }

    isBase64(str) {
        try {
            return btoa(atob(str)).slice(0, -1) === str; // Remove '=' (the last character)
        } catch (err) {
            return false;
        }
    }
}

export default Token = new Token();