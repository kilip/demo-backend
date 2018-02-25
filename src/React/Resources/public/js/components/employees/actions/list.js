import fetch from '../../../utils/fetch';

export function error(error) {
  return {type: 'EMPLOYEE_LIST_ERROR', error};
}

export function loading(loading) {
  return {type: 'EMPLOYEE_LIST_LOADING', loading};
}

export function success(data) {
  return {type: 'EMPLOYEE_LIST_SUCCESS', data};
}

export function list(page = '/employees') {
  return (dispatch) => {
    dispatch(loading(true));
    dispatch(error(''));

    fetch(page)
      .then(response => response.json())
      .then(data => {
        dispatch(loading(false));
        dispatch(success(data));
      })
      .catch(e => {
        dispatch(loading(false));
        dispatch(error(e.message))
      });
  };
}

export function reset() {
  return {type: 'EMPLOYEE_LIST_RESET'};
}
