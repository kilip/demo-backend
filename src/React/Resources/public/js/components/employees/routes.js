import React from 'react';
import {Route} from 'react-router-dom';
import {List,Create, Update, Show} from './views';

export default [
  <Route path='/employees/create' component={Create} exact={true} key='create'/>,
  <Route path='/employees/:id/edit' component={Update} exact={true} key='update'/>,
  <Route path='/employees/:id' component={Show} exact={true} key='show'/>,
  <Route path='/employees/:page?' component={List} strict={true} key='list'/>,
];
