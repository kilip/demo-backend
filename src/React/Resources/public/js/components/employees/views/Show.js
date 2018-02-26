import React, {Component} from 'react';
import {connect} from 'react-redux';
import {Link, Redirect} from 'react-router-dom';
import PropTypes from 'prop-types';
import {retrieve, reset} from '../actions/show';
import { del, loading, error } from '../actions/delete';

class Show extends Component {
  componentDidMount() {
    this.props.retrieve(decodeURIComponent(this.props.match.params.id));
  }

  componentWillUnmount() {
    this.props.reset();
  }

  del(){
    if (window.confirm('Are you sure you want to delete this item?')) this.props.del(this.props.retrieved);
  };

  render() {
    if (this.props.deleted) return <Redirect to=".."/>;

    const item = this.props.retrieved;

    return (<div>
      <h1>Show {item && item['@id']}</h1>

      {this.props.loading && <div className="alert alert-info" role="status">Loading...</div>}
      {this.props.error && <div className="alert alert-danger" role="alert"><span className="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> {this.props.error}</div>}
      {this.props.deleteError && <div className="alert alert-danger" role="alert"><span className="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> {this.props.deleteError}</div>}

      {item && <div className="table-responsive">
        <table className="table table-striped table-hover">
          <thead>
            <tr>
              <th>Field</th>
              <th>Value</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>login</td>
              <td>{item['login']}</td>
            </tr>
            <tr>
              <td>birthDate</td>
              <td>{item['birthDate']}</td>
            </tr>
            <tr>
              <td>gender</td>
              <td>{item['gender']}</td>
            </tr>
            <tr>
              <td>email</td>
              <td>{item['email']}</td>
            </tr>
            <tr>
              <td>name</td>
              <td>{item['name']}</td>
            </tr>
          </tbody>
        </table>
      </div>
      }
      <Link to=".." className="btn btn-default">Back to list</Link>
      {item && <Link to={`/employees/${item['id']}/edit`}>
        <button className="btn btn-warning">Edit</button>
        </Link>
      }
      <button onClick={this.del} className="btn btn-danger">Delete</button>
    </div>);
  }
}

Show.propTypes = {
    error: PropTypes.string,
    loading: PropTypes.bool.isRequired,
    retrieved: PropTypes.object,
    retrieve: PropTypes.func.isRequired,
    reset: PropTypes.func.isRequired,
    deleteError: PropTypes.string,
    deleteLoading: PropTypes.bool.isRequired,
    deleted: PropTypes.object,
    del: PropTypes.func.isRequired
};

const mapStateToProps = (state) => {
  return {
    error: state.employee.show.error,
    loading: state.employee.show.loading,
    retrieved:state.employee.show.retrieved,
    deleteError: state.employee.del.error,
    deleteLoading: state.employee.del.loading,
    deleted: state.employee.del.deleted,
  };
};

const mapDispatchToProps = (dispatch) => {
  return {
    retrieve: id => dispatch(retrieve(id)),
    del: item => dispatch(del(item)),
    reset: () => {
      dispatch(reset());
      dispatch(error(null));
      dispatch(loading(false));
    },
  }
};

export default connect(mapStateToProps, mapDispatchToProps)(Show);
