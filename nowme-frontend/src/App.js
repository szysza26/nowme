import React from "react";
import { BrowserRouter, Switch, Route } from "react-router-dom";

import SignIn from './pages/Auth/SignIn';
import SignUp from './pages/Auth/SignUp';
import Home from './pages/Home';

function App() {
    return (
        <BrowserRouter>
            <Switch>
                <Route exact path="/" component={Home}/>
                <Route exact path="/signin" component={SignIn}/>
                <Route exact path="/signup" component={SignUp}/>
          </Switch>
      </BrowserRouter>
  );
}

export default App;
