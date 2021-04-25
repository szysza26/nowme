import React, {useEffect, useState} from 'react';
import axios from 'axios';
import {makeStyles} from "@material-ui/core/styles";
import {Button, Grid, MenuItem, Paper, Select, TextField, Typography} from "@material-ui/core";
import Alert from "@material-ui/lab/Alert";

import MapResult from './MapResult';
// import TableResult from './TableResult';


const useStyles = makeStyles({
    paper: {
        padding: '8px',
        marginBottom: '10px',
    }
});

const Searcher = (props) => {
    const classes = useStyles();

    const [service, setService] = useState(1);
    const [city, setCity] = useState('');
    const [dateFrom, setDateFrom] = useState("2021-01-01");
    const [dateTo, setDateTo] = useState("2021-01-01");

    const [services, setServices] = useState([]);

    const [result, setResult] = useState(null);

    const [success, setSuccess] = useState(false);
    const [error, setError] = useState(false);

    useEffect(() => {
        axios.get("http://localhost:8000/api/dictionaries/services")
            .then((res) => {
                setServices(res.data)
            })
            .catch((error) => {
                console.log(error)
            });

        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

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

    const handleChange = (event) => {
        switch(event.target.name){
            case 'service':
                setService(event.target.value);
                break;
            case 'city':
                setCity(event.target.value);
                break;
            case 'dateFrom':
                setDateFrom(event.target.value);
                break;
            case 'dateTo':
                setDateTo(event.target.value);
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
            service,
            city,
            dateFrom,
            dateTo
        }

        axios.post("http://localhost:8000/api/search", data, axiosConfig)
            .then((res) => {
                setResult(res.data);
                setSuccess(true);
            })
            .catch((error) => {
                console.log(error)
                setError(true);
            })
    }

    return (
        <>
            <Paper className={classes.paper}>
                <Typography variant="h6" gutterBottom>Wyszukiwarka: </Typography>
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
                            {services.map(element => <MenuItem key={element.id} value={element.id}>{element.name}</MenuItem>)}
                        </Select>
                    </Grid>
                    <Grid item xs={12}>
                        <TextField
                            required
                            name="city"
                            label="Miasto"
                            fullWidth
                            value={city}
                            onChange={handleChange}
                        />
                    </Grid>
                    <Grid item xs={12} md={6}>
                        <TextField
                            required
                            name="dateFrom"
                            label="Od"
                            fullWidth
                            type="date"
                            value={dateFrom}
                            onChange={handleChange}
                        />
                    </Grid>
                    <Grid item xs={12} md={6}>
                        <TextField
                            required
                            name="dateTo"
                            label="Do"
                            fullWidth
                            type="date"
                            value={dateTo}
                            onChange={handleChange}
                        />
                    </Grid>
                    <Grid item xs={4} sm={3} md={2} className={classes.button}>
                        <Button variant="contained" color="primary" onClick={handleClick} fullWidth>
                            Wyszukaj
                        </Button>
                    </Grid>
                </Grid>
            </Paper>
            <MapResult result={result} />
            {/*{result && <TableResult result={result} />*/}
        </>
    );
}

export default Searcher;