import React from 'react';
import { Switch, Route } from "react-router-dom";

import ServicesList from './ServicesList';
import ServicesForm from './ServicesForm';

const Services = (props) => {
    return (
        <Switch>
            <Route exact path="/services/list">
                <ServicesList />
            </Route>
            <Route exact path="/services/add">
                <ServicesForm action={"add"}/>
            </Route>
            <Route exact path="/services/show/:id">
                <ServicesForm action={"show"}/>
            </Route>
            <Route exact path="/services/edit/:id">
                <ServicesForm action={"edit"}/>
            </Route>
        </Switch>
    );
}

export default Services;