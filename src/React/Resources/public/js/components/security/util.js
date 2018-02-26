import jwt_decode from 'jwt-decode';

export function decodeToken(token){
    if (token !== null){
        return jwt_decode(token);
    }
    return null;
}

export function checkToken() {
    let data = null,
        isLoading = false
    ;

    let token = localStorage.getItem('token');
    if (token !== null) {
        const decoded = decodeToken(token);
        if (decoded.exp < Date.now() / 1000) {
            data = null;
            localStorage.clear();
        } else {
            data = decoded;
        }
    }
    return {data: data, isLoading: isLoading, token: token};
}