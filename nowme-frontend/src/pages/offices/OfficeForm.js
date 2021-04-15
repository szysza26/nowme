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

const OfficesForm = (props) => {
    const classes = useStyles();
    const history = useHistory();
    const params = useParams();

    const [name, setName] = useState('');
    const [street, setStreet] = useState('');
    const [houseNumber, setHouseNumber] = useState('');
    const [city, setCity] = useState('');
    const [zip, setZip] = useState('');

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
            axios.get(`http://localhost:8000/api/offices/${params.id}`)
                .then((res) => {
                    setName(res.data.name);
                    setStreet(res.data.street);
                    setHouseNumber(res.data.houseNumber);
                    setCity(res.data.city);
                    setZip(res.data.zip);
                })
                .catch((error) => {
                    console.log(error)
                    history.push('/offices/list');
                });
        }
        
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    const handleChange = (event) => {
        switch(event.target.name){
            case 'name':
                setName(event.target.value);
                break;
            case 'street':
                setStreet(event.target.value);
                break;
            case 'houseNumber':
                setHouseNumber(event.target.value);
                break;
            case 'city':
                setCity(event.target.value);
                break;
            case 'zip':
                setZip(event.target.value);
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
            name,
            street,
            houseNumber,
            city,
            zip
        }

        if(props.action === "add") {
            axios.post("http://localhost:8000/api/offices", data, axiosConfig)
                .then((res) => {
                    setName('');
                    setStreet('');
                    setHouseNumber('');
                    setCity('');
                    setZip('');
                    setSuccess(true);
                })
                .catch((error) => {
                    console.log(error)
                    setError(true);
                })
        }else if(props.action === "edit"){
            axios.put(`http://localhost:8000/api/offices/${params.id}`, data, axiosConfig)
                .then((res) => {
                    setSuccess(true);
                })
                .catch((error) => {
                    console.log(error)
                    setError(true);
                })
        }
    }

    return (
    <>
        <Paper className={classes.paper}>
            {props.action === "show" && <Typography variant="h6" gutterBottom>Gabinet </Typography>}
            {props.action === "add" && <Typography variant="h6" gutterBottom>Dodawanie gabinetu: </Typography>}
            {props.action === "edit" && <Typography variant="h6" gutterBottom>Edytowanie gabinetu: </Typography>}
            {success && <Alert severity="success">Sukces</Alert>}
            {error && <Alert severity="error">Niepowodzenie</Alert>}
            <Grid container spacing={3}>
                <Grid item xs={12}>
                    <TextField
                        required
                        name="name"
                        label="Nazwa"
                        fullWidth
                        InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                        value={name}
                        onChange={handleChange}
                    />
                </Grid>
                <Grid item xs={12} md={6}>
                    <TextField
                        required
                        name="street"
                        label="Ulica"
                        fullWidth
                        InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                        value={street}
                        onChange={handleChange}
                    />
                </Grid>
                <Grid item xs={12} md={6}>
                    <TextField
                        required
                        name="houseNumber"
                        label="Numer budynku"
                        fullWidth
                        InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                        value={houseNumber}
                        onChange={handleChange}
                    />
                </Grid>
                <Grid item xs={12} md={6}>
                    <TextField
                        required
                        name="city"
                        label="Miasto"
                        fullWidth
                        InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                        value={city}
                        onChange={handleChange}
                    />
                </Grid>
                <Grid item xs={12} md={6}>
                    <TextField
                        required
                        name="zip"
                        label="Kod pocztowy"
                        fullWidth
                        InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                        value={zip}
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

export default OfficesForm;