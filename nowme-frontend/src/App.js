import React, {useState, useEffect} from "react";
import { BrowserRouter, Switch, Route } from "react-router-dom";

import SignIn from './pages/Auth/SignIn';
import SignUp from './pages/Auth/SignUp';
import Home from './pages/Home';
import Specialists from './pages/specialists/Specialists';
import Main from './component/Main';
import Profile from './pages/Auth/Profile';
import jwt_decode from 'jwt-decode';

function App() {

    const [token, setToken] = useState('');

    useEffect(() => {
        if (localStorage.getItem('token') !== null && localStorage.getItem('token') !== '') {
            const tmp = jwt_decode(localStorage.getItem('token'));
            if(tmp.exp > Date.now()/1000) {
                setToken(localStorage.getItem('token'));
            }else{
                localStorage.setItem('token', '');
            }
        }
    }, [])

    useEffect(() => {
        token === '' && localStorage.setItem('token', '');
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
                    </>
                    } 
                    {token &&
                    <>
                    <Route exact path="/profile">
                        <Profile setToken={setToken} />
                    </Route>
                    <Route exact path="/specialists">
                        <Specialists />
                    </Route>
                    </>
                    }
                </Switch>
            </Main>
      </BrowserRouter>
  );
}

export default App;
