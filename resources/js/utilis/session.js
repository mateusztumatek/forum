import Cookies from 'js-cookie';

const SessionKey = 'Session-Key';

export function getSessionKey() {
    return Cookies.get(SessionKey);
}

export function setSessionKey(token) {
    return Cookies.set(SessionKey, token, { expires: 5 });
}

export function removeSessionKey() {
    return Cookies.remove(SessionKey);
}
