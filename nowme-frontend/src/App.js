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
import Availabilities from "./pages/availabilities/Availabilities";
import Searcher from "./pages/searcher/Searcher";

const VALID_TOKEN_MS = 60000;

function App() {

    const [token, setToken] = useState(localStorage.getItem('token'));
    const [parseToken, setParseToken] = useState(null);

    useEffect(() => {
        token ? localStorage.setItem('token', token) : localStorage.removeItem('token');
        token ? setParseToken(jwt_decode(token)) : setParseToken(null);
        axios.defaults.headers.common['Authorization'] = "Bearer " + token;

        const interval = setInterval(() => {
            token && (jwt_decode(token).exp * 1000) < (Date.now() - (2* VALID_TOKEN_MS)) && setToken(null);
        }, VALID_TOKEN_MS);

        return () => clearInterval(interval);
    }, [token])

    return (
        <BrowserRouter>
            <Main token={parseToken}>
                <Switch>
                    <Route exact path="/">
                        <Home />
                    </Route>
                    <Route path="/search">
                        <Searcher />
                    </Route>
                    <>
                        {!parseToken &&
                        <>
                            <Route exact path="/signin">
                                <SignIn setToken={setToken}/>
                            </Route>
                            <Route exact path="/signup">
                                <SignUp/>
                            </Route>
                            <Route exact path="/reset">
                                <ResetPasswordForm/>
                            </Route>
                        </>
                        }
                        {parseToken &&
                        <>
                            <Route exact path="/profile">
                                <Profile token={parseToken} />
                            </Route>
                            <Route exact path="/logout">
                                <Logout setToken={setToken} />
                            </Route>
                        </>

                        }
                        {parseToken?.roles.includes("ROLE_ADMIN") && (
                        <>
                            <Route path="/specialists">
                                <Specialists />
                            </Route>
                            <Route path="/offices">
                                <Offices />
                            </Route>
                        </>
                        )}
                        {parseToken?.roles.includes("ROLE_SPECIALIST") &&
                        <>
                            <Route path="/services">
                                <Services />
                            </Route>
                            <Route path="/availabilities">
                                <Availabilities />
                            </Route>
                        </>
                        }
                    </>
                </Switch>
            </Main>
      </BrowserRouter>
  );
}

export default App;
