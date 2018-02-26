import * as constants from '../constants';
import { checkToken } from "../util";

const initialState = checkToken();
export function authentication(state = initialState, { type, payload }) {
    switch (type) {
        case constants.USER_LOGGING_IN:
            state.isLoading = true;
            return state;
        case constants.USER_LOGGED_IN:
            return { data: payload, isLoading: false };
        case constants.USER_LOGGED_OUT:
            localStorage.clear();
            return checkToken();
        default:
            return state;
    }
}

export default authentication;