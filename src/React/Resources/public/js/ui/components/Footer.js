import React, {Component} from 'react';

class Footer extends Component {
  render() {
    return (
      <footer className="app-footer">
        <span><a href="https://github.com/kilip/omed-frontend">OMED Project</a> &copy; 2018 DoyoLabs.</span>
        <span className="ml-auto">Powered by <a href="http://coreui.io">CoreUI</a></span>
      </footer>
    )
  }
}

export default Footer;
