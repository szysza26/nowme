import React, { useState, useEffect } from 'react';
import {useHistory, useParams} from 'react-router-dom';
import axios from 'axios';
import { makeStyles } from '@material-ui/core/styles';
import {Paper, Typography, Grid, TextField, Button, Select, MenuItem} from '@material-ui/core';
import Alert from '@material-ui/lab/Alert';

const useStyles = makeStyles({
    paper: {
        padding: '8px',
    },
    button: {
        padding: '16px',
    }
});

const ServicesForm = (props) => {
    const classes = useStyles();
    const history = useHistory();
    const params = useParams();

    const [services, setServices] = useState([]);

    const [service, setService] = useState('');
    const [price, setPrice] = useState('');
    const [duration, setDuration] = useState('');

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
            axios.get(`https://api.szysza.ovh/api/services/${params.id}`)
                .then((res) => {
                    setService(res.data.service.id);
                    setPrice(res.data.price);
                    setDuration(res.data.duration);
                })
                .catch((error) => {
                    console.log(error)
                    history.push('/services/list');
                });
        }

        axios.get("https://api.szysza.ovh/api/dictionaries/services")
            .then((res) => {
                setServices(res.data)
            })
            .catch((error) => {
                console.log(error)
            });
        
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    const handleChange = (event) => {
        switch(event.target.name){
            case 'service':
                setService(event.target.value);
                break;
            case 'price':
                setPrice(event.target.value);
                break;
            case 'duration':
                setDuration(event.target.value);
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
            name: service,
            price,
            duration,
        }

        if(props.action === "add"){
            axios.post("https://api.szysza.ovh/api/services", data, axiosConfig)
                .then((res) => {
                  setService('');
                  setPrice('');
                  setDuration('');
                  setSuccess(true);
                })
                .catch((error) => {
                  console.log(error)
                  setError(true);
                })
        } else if(props.action === "edit"){
            axios.put(`https://api.szysza.ovh/api/services/${params.id}`, data, axiosConfig)
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
            {props.action === "show" && <Typography variant="h6" gutterBottom>Usługa</Typography>}
            {props.action === "add" && <Typography variant="h6" gutterBottom>Dodawanie usługi: </Typography>}
            {props.action === "edit" && <Typography variant="h6" gutterBottom>Edytowanie usługi: </Typography>}
            {success && <Alert severity="success">Sukces</Alert>}
            {error && <Alert severity="error">Niepowodzenie</Alert>}
            <Grid container spacing={3}>
                <Grid item xs={12}>
                    <Select
                        name="service"
                        value={service}
                        onChange={handleChange}
                        fullWidth
                    >
                        {props.action === 'show' ?
                        services.filter(element => element.id === service).map(element => <MenuItem key={element.id} value={element.id}>{element.name}</MenuItem>)
                        :
                        services.map(element => <MenuItem key={element.id} value={element.id}>{element.name}</MenuItem>)
                        }
                    </Select>
                </Grid>
                <Grid item xs={12} md={6}>
                    <TextField
                        required
                        name="price"
                        label="Cena"
                        fullWidth
                        InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                        value={price}
                        onChange={handleChange}
                    />
                </Grid>
                <Grid item xs={12} md={6}>
                    <TextField
                        required
                        name="duration"
                        label="Czas usługi"
                        fullWidth
                        InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                        value={duration}
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

export default ServicesForm;