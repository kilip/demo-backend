import React from 'react';
import ReactDOM from 'react-dom';

import { reducer as form } from 'redux-form';
import { routerReducer as routing } from 'react-router-redux';
import { createStore, combineReducers, applyMiddleware,compose } from 'redux';
import { Provider } from 'react-redux';
import thunkMiddleware from 'redux-thunk';

import Omed from './omed';

import security from './components/security/reducers';
import employee from './components/employees/reducers';


const reducers = combineReducers({routing,form,security,employee});
const enhancer = compose(
    applyMiddleware(thunkMiddleware)
    //window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
);
const store = createStore(reducers, enhancer);

ReactDOM.render(
    <Provider store={store}>
        <Omed />
    </Provider>,
    document.getElementById('root')
);
