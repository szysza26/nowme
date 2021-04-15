import React, {useState, useEffect} from "react";
import { BrowserRouter, Switch, Route } from "react-router-dom";
import axios from 'axios';

import Home from './pages/Home';
import Specialists from './pages/specialists/Specialists';
import Main from './component/Main';
import Profile from './pages/Auth/Profile';
import Logout from './pages/Auth/Logout';
import SignIn from './pages/Auth/SignIn';
import SignUp from './pages/Auth/SignUp';
import ResetPasswordForm from "./pages/Auth/ResetPasswordForm";
import jwt_decode from 'jwt-decode';
import Offices from './pages/offices/Offices';
import Services from './pages/services/Services';

const VALID_TOKEN_MS = 60000;

function App() {

    const [token, setToken] = useState(localStorage.getItem('token'));

    useEffect(() => {
        token ? localStorage.setItem('token', token) : localStorage.removeItem('token');
        axios.defaults.headers.common['Authorization'] = "Bearer " + token;

        const interval = setInterval(() => {
            token && (jwt_decode(token).exp * 1000) < (Date.now() - (2* VALID_TOKEN_MS)) && setToken(null);
        }, VALID_TOKEN_MS);

        return () => clearInterval(interval);
    }, [token])

    return (
        <BrowserRouter>
            <Main token={token}>
                <Switch>
                    <Route exact path="/">
                        <Home />
                    </Route>
                    {!token &&
                    <>
                    <Route exact path="/signin">
                        <SignIn setToken={setToken}/>
                    </Route>
                    <Route exact path="/signup">
                        <SignUp />
                    </Route>
                    <Route exact path="/reset">
                        <ResetPasswordForm />
                    </Route>
                    </>
                    }
                    {token &&
                    <>
                    <Route exact path="/profile">
                        <Profile token={token} />
                    </Route>
                    <Route exact path="/logout">
                        <Logout setToken={setToken} />
                    </Route>
                    <Route path="/specialists">
                        <Specialists />
                    </Route>
                    <Route path="/offices">
                        <Offices />
                    </Route>
                    <Route path="/services">
                        <Services />
                    </Route>
                    </>
                    }
                </Switch>
            </Main>
      </BrowserRouter>
  );
}

export default App;
