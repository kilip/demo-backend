import React, { Component } from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';
import fetch from '../utils/fetch';

class Employees extends Component {

    loadEmployees()
    {
        fetch('employees')
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
        ;
    }

    render() {
        this.loadEmployees();
        return (
            <div className="animated fadeIn">
                Employee List
            </div>
        )
    }
}

Employees.propTypes = {
    user: PropTypes.object.isRequired,
    employees: PropTypes.array
};

function mapStateToProps(state){
    return {
        user: state.user
    };
}
export default connect(mapStateToProps)(Employees);
