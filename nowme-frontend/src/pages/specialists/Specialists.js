import React from 'react'
import { Switch, Route } from "react-router-dom";

import SpecialistsList from './SpecialistsList';
import SpecialistsForm from './SpecialistsForm';

const Specialists = (props) => {
    return (
        <Switch>
            <Route exact path="/specialists/list">
                <SpecialistsList />
            </Route>
            <Route exact path="/specialists/add">
                <SpecialistsForm action={"add"}/>
            </Route>
            <Route exact path="/specialists/show/:id">
                <SpecialistsForm action={"show"}/>
            </Route>
            <Route exact path="/specialists/edit/:id">
                <SpecialistsForm action={"edit"}/>
            </Route>
        </Switch>
    );
}

export default Specialists;