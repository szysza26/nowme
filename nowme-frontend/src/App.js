import React, {useState} from "react";
import { BrowserRouter, Switch, Route } from "react-router-dom";

import SignIn from './pages/Auth/SignIn';
import SignUp from './pages/Auth/SignUp';
import Home from './pages/Home';
import Specialists from './pages/specialists/Specialists';
import Main from './component/Main';

function App() {

    const [token, setToken] = useState('');

    return (
        <BrowserRouter>
            <Main>
                <Switch>
                    <Route exact path="/">
                        <Home token={token}/>
                    </Route>
                    <Route exact path="/signin">
                        <SignIn setToken={setToken}/>
                    </Route>
                    <Route exact path="/signup">
                        <SignUp />
                    </Route>
                    <Route exact path="/specialists">
                        <Specialists/>
                    </Route>
                </Switch>
            </Main>
      </BrowserRouter>
  );
}

export default App;
