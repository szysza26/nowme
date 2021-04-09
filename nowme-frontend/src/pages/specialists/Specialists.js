import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import { Paper, Typography } from '@material-ui/core';

import SpecForm from './SpecForm';
import SpecList from './SpecList';


const useStyles = makeStyles({
    paper: {
        padding: '8px',
        marginBottom: '24px',
    }
});

const rows = [
    {id: 1, firstName: "Jan1", lastName: "Kowalski1", spec: "Barber", telephone: "123456789", address: "test 1", city: "Szczecin", zip: "00-000"},
    {id: 2, firstName: "Jan2", lastName: "Kowalski2", spec: "Barber", telephone: "123456789", address: "test 2", city: "Szczecin", zip: "00-000"},
    {id: 3, firstName: "Jan3", lastName: "Kowalski3", spec: "Barber", telephone: "123456789", address: "test 3", city: "Szczecin", zip: "00-000"},
    {id: 4, firstName: "Jan4", lastName: "Kowalski4", spec: "Barber", telephone: "123456789", address: "test 4", city: "Szczecin", zip: "00-000"},
    {id: 5, firstName: "Jan5", lastName: "Kowalski5", spec: "Barber", telephone: "123456789", address: "test 5", city: "Szczecin", zip: "00-000"},
];

const Specialists = (props) => {
    const classes = useStyles();

    return (
    <>
        <Paper className={classes.paper}>
            <Typography variant="h6" gutterBottom>Create Specjalist: </Typography>
            <SpecForm action={"add"} data={{}}/>
        </Paper>
        <Paper className={classes.paper}>
            <Typography variant="h6" gutterBottom>Specjalists: </Typography>
            <SpecList data={rows}/>
        </Paper>
    </>
    );
}

export default Specialists;