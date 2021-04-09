import React from "react";
import { BrowserRouter, Switch, Route } from "react-router-dom";

import SignIn from './pages/Auth/SignIn';
import SignUp from './pages/Auth/SignUp';
import Home from './pages/Home';
import Specialists from './pages/specialists/Specialists';
import Main from './component/Main';

function App() {
    return (
        <BrowserRouter>
            <Main>
                <Switch>
                    <Route exact path="/" component={Home}/>
                    <Route exact path="/signin" component={SignIn}/>
                    <Route exact path="/signup" component={SignUp}/>
                    <Route exact path="/specialists" component={Specialists}/>
                </Switch>
            </Main>
      </BrowserRouter>
  );
}

export default App;
