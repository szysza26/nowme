import React, { useState, useEffect } from 'react';
import {useHistory, useParams} from 'react-router-dom';
import axios from 'axios';
import { makeStyles } from '@material-ui/core/styles';
import { Paper, Typography, Grid, TextField, Button, Select, MenuItem } from '@material-ui/core';
import Alert from '@material-ui/lab/Alert';

const useStyles = makeStyles({
    paper: {
        padding: '8px',
    },
    button: {
        padding: '16px',
    }
});

const AvailabilitiesForm = (props) => {
    const classes = useStyles();
    const history = useHistory();
    const params = useParams();

    const [date, setDate] = useState('2021-01-01');
    const [hourFrom, setHourFrom] = useState('08:00:00');
    const [hourTo, setHourTo] = useState('12:00:00');
    const [officeId, setOfficeId] = useState('');
    const [officeName, setOfficeName] = useState('');
    const [offices, setOffices] = useState([]);

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
            axios.get(`http://localhost:8000/api/availabilities/${params.id}`)
                .then((res) => {
                    setDate(res.data.date.substring(0, 10));
                    setHourFrom(res.data.hour_from.substring(11, 19));
                    setHourTo(res.data.hour_to.substring(11, 19));
                    setOfficeId(res.data.office_id);
                    setOfficeName(res.data.office_name);
                })
                .catch((error) => {
                    console.log(error)
                    history.push('/availabilities/list');
                });
        }
        if(props.action === "add" || props.action === "edit"){
            axios.get(`http://localhost:8000/api/offices`)
                .then((res) => {
                    setOffices(res.data);
                })
                .catch((error) => {
                    console.log(error)
                    history.push('/availabilities/list');
                });
        }
        
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    const handleChange = (event) => {
        switch(event.target.name){
            case 'date':
                setDate(event.target.value);
                break;
            case 'hourFrom':
                setHourFrom(event.target.value);
                break;
            case 'hourTo':
                setHourTo(event.target.value);
                break;
            case 'office':
                setOfficeId(event.target.value);
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
            date: date,
            hour_from: hourFrom,
            hour_to: hourTo,
            office: officeId
        }

        if(props.action === "add"){
            axios.post("http://localhost:8000/api/availabilities", data, axiosConfig)
                .then((res) => {
                    setDate('2021-01-01');
                    setHourFrom('08:00:00');
                    setHourTo('16:00:00');
                    setOfficeId('');
                    setOfficeName('');
                    setSuccess(true);
                })
                .catch((error) => {
                  console.log(error)
                  setError(true);
                })
        } else if(props.action === "edit"){
            axios.put(`http://localhost:8000/api/availabilities/${params.id}`, data, axiosConfig)
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
            {props.action === "show" && <Typography variant="h6" gutterBottom>Wolny termin </Typography>}
            {props.action === "add" && <Typography variant="h6" gutterBottom>Dodawanie terminu: </Typography>}
            {props.action === "edit" && <Typography variant="h6" gutterBottom>Edytowanie terminu: </Typography>}
            {success && <Alert severity="success">Sukces</Alert>}
            {error && <Alert severity="error">Niepowodzenie</Alert>}
            <Grid container spacing={3}>
                <Grid item xs={12}>
                    <TextField
                        required
                        name="date"
                        label="Dzień"
                        type="date"
                        fullWidth
                        InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                        value={date}
                        onChange={handleChange}
                    />
                </Grid>
                <Grid item xs={12} md={6}>
                    <TextField
                        required
                        name="hourFrom"
                        label="Od"
                        type="time"
                        fullWidth
                        InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                        value={hourFrom}
                        onChange={handleChange}
                    />
                </Grid>
                <Grid item xs={12} md={6}>
                    <TextField
                        required
                        name="hourTo"
                        label="Do"
                        fullWidth
                        type="time"
                        InputProps={props.action === 'show' ? {readOnly: true,} : {}}
                        value={hourTo}
                        onChange={handleChange}
                    />
                </Grid>
                <Grid item xs={12}>
                    { props.action === 'show' ?
                    <TextField
                        required
                        name="office"
                        label="Gabinet"
                        fullWidth
                        InputProps={{readOnly: true,}}
                        value={officeName}
                    />
                    :
                    <Select
                        name="office"
                        value={officeId}
                        onChange={handleChange}
                        fullWidth
                    >
                        {offices.map(office => <MenuItem key={office.id} value={office.id}>{office.name}</MenuItem>)}
                    </Select>
                    }
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

export default AvailabilitiesForm;