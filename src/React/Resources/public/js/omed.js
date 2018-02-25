import React, { Component } from 'react';
import {HashRouter as Router, Route, Switch} from 'react-router-dom';
import DashboardContainer from './ui/DashboardContainer';
import { connect } from 'react-redux';

import Login from './views/Login';

import {
    userIsAuthenticatedRedir,
    userIsNotAuthenticatedRedir
} from "./components/security/auth";

class Omed extends Component {
    render(){
        return (
            <Router>
                <Switch>
                    <Route exact path="/login" name="LoginPage" component={userIsNotAuthenticatedRedir(Login)}/>
                    <Route path="/" name="Dashboard" component={userIsAuthenticatedRedir(DashboardContainer)}/>
                </Switch>
            </Router>
        );
    }
}

function mapStateToProps(state){
    return {
        user: state.user
    };
}
export default connect(mapStateToProps)(Omed);
