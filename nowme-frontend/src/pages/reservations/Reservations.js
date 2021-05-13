import React from 'react';
import { Switch, Route } from "react-router-dom";

import ReservationList from './ReservationList';
import ReservationForm from './ReservationForm';

const Reservations = (props) => {
    return (
        <Switch>
            <Route exact path="/reservations/list">
                <ReservationList />
            </Route>
            <Route exact path="/reservations/:service/:specialist/:office/:from/:to">
                <ReservationForm />
            </Route>
        </Switch>
    );
}

export default Reservations;