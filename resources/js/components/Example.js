import React from "react";
import ReactDOM from "react-dom";

function Example() {
  return (
    <div className="container">
      <div className="row justify-content-center">
        <div className="col-md-8">
          <div className="card">
            <div className="card-header">Example t Component</div>

            <div className="card-body">I'm an component!</div>
          </div>
        </div>
      </div>
    </div>
  );
}

if (document.getElementById("example")) {
  ReactDOM.render(<Example />, document.getElementById("example"));
}

export default Example;
