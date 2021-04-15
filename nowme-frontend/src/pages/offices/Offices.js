import React from 'react';
import { Switch, Route } from "react-router-dom";

import OfficesList from './OfficeList';
import OfficesForm from './OfficeForm';

const Offices = (props) => {
    return (
        <Switch>
            <Route exact path="/offices/list">
                <OfficesList />
            </Route>
            <Route exact path="/offices/add">
                <OfficesForm action={"add"}/>
            </Route>
            <Route exact path="/offices/show/:id">
                <OfficesForm action={"show"}/>
            </Route>
            <Route exact path="/offices/edit/:id">
                <OfficesForm action={"edit"}/>
            </Route>
        </Switch>
    );
}

export default Offices;