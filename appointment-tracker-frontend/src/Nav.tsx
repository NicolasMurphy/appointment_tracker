import { Link } from "react-router-dom";

function Nav() {
  return (
    <nav className="navbar bg-base-100">
      <div className="navbar-start"></div>
      <div className="navbar-center">
        <ul className="menu menu-horizontal px-1">
          <li>
            <Link to="/">Home</Link>
          </li>
          <li>
            <Link to="/create-appointment">Create Appointment</Link>
          </li>
        </ul>
      </div>
      <div className="navbar-end"></div>
    </nav>
  );
}

export default Nav;
