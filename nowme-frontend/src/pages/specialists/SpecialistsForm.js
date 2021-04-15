import React, { useState, useEffect } from 'react';
import {useHistory, useParams} from 'react-router-dom';
import axios from 'axios';
import { makeStyles } from '@material-ui/core/styles';
import { Paper, Typography, Grid, TextField, Button } from '@material-ui/core';
import Alert from '@material-ui/lab/Alert';

const useStyles = makeStyles({
    paper: {
        padding: '8px',
    },
    button: {
        padding: '16px',
    }
});

const SpecialistsForm = (props) => {
    const classes = useStyles();
    const history = useHistory();
    const params = useParams();

    const [firstName, setFirstName] = useState('');
    const [lastName, setLastName] = useState('');
    const [spec, setSpec] = useState('');

    const [success, setSuccess] = useState(false);
    const [error, setError] = useState(false);

    useEffect(() => {
        success && setTimeout(() => {
            setSuccess(false);
        }, 5000);
    }, [success])

    useEffect(() => {
        error && setTimeout(() => {
            setError(false);
        }, 5000);
    }, [error])

    useEffect(() => {
        if(props.action === "edit" || props.action === "show"){
            axios.get(`http://localhost:8000/api/specialists/${params.id}`)
                .then((res) => {
                    setFirstName(res.data.firstName);
                    setLastName(res.data.lastName);
                    setSpec(res.data.spec);
                })
                .catch((error) => {
                    console.log(error)
                    history.push('/specialists/list');
                });
        }

        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    const handleChange = (event) => {
        switch(event.target.name){
            case 'firstName':
                setFirstName(event.target.value);
                break;
            case 'lastName':
                setLastName(event.target.value);
                break;
            case 'spec':
                setSpec(event.target.value);
                break;
            default:
                console.log('can not handle this value');
        }
    }

    const handleClick = () => {
        let axiosConfig = {
            headers: {
                "Content-Type": 'application/json',
            }
        };

        let data = {
            firstName,
            lastName,
            spec,
        }

        if(props.action === "add"){
            axios.post("http://localhost:8000/api/specialists", data, axiosConfig)
                .then((res) => {
                    setFirstName('');
                    setLastName('');
                    setSpec('');
                    setSuccess(true);
                })
                .catch((error) => {
                    console.log(error)
                    setError(true);
                })
        } else if(props.action === "edit"){
            axios.put(`http://localhost:8000/api/specialists/${params.id}`, data, axiosConfig)
                .then((res) => {
                    setSuccess(true);
                })
                .catch((error) => {
                    console.log(error)
                    setError(true);
                });
        }
    }

    return (
        <>
            <Paper className={classes.paper}>
                {props.action === "show" && <Typography variant="h6" gutterBottom>Specialista </Typography>}
                {props.action === "add" && <Typography variant="h6" gutterBottom>Dodawanie specialisty: </Typography>}
                {props.action === "edit" && <Typography variant="h6" gutterBottom>Edytowanie specialisty: </Typography>}
                {success && <Alert severity="success">Sukces</Alert>}
                {error && <Alert severity="error">Niepowodzenie</Alert>}
                <Grid container spacing={3}>
                    <Grid item xs={12}>
                        <TextField
                            required
                            name="firstName"
                            label="Imię"
                            fullWidth
                            InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                            value={firstName}
                            onChange={handleChange}
                        />
                    </Grid>
                    <Grid item xs={12} md={6}>
                        <TextField
                            required
                            name="lastName"
                            label="Nazwisko"
                            fullWidth
                            InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                            value={lastName}
                            onChange={handleChange}
                        />
                    </Grid>
                    <Grid item xs={12} md={6}>
                        <TextField
                            required
                            name="spec"
                            label="Specializacija"
                            fullWidth
                            InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                            value={spec}
                            onChange={handleChange}
                        />
                    </Grid>
                    {props.action !== "show" &&
                    <Grid item xs={4} sm={3} md={2} className={classes.button}>
                        <Button variant="contained" color="primary" onClick={handleClick} fullWidth>
                            {props.action === 'add' ? "Dodaj" : "Zapisz"}
                        </Button>
                    </Grid>
                    }
                </Grid>
            </Paper>
        </>
    );
}

export default SpecialistsForm;