import React from 'react';
import { Switch, Route } from "react-router-dom";

import AvailabilitiesList from './AvailabilitiesList';
import AvailabilitiesForm from './AvailabilitiesForm';

const Availabilities = (props) => {
    return (
        <Switch>
            <Route exact path="/availabilities/list">
                <AvailabilitiesList />
            </Route>
            <Route exact path="/availabilities/add">
                <AvailabilitiesForm action={"add"}/>
            </Route>
            <Route exact path="/availabilities/show/:id">
                <AvailabilitiesForm action={"show"}/>
            </Route>
            <Route exact path="/availabilities/edit/:id">
                <AvailabilitiesForm action={"edit"}/>
            </Route>
        </Switch>
    );
}

export default Availabilities;