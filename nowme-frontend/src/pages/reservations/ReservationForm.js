import React, {useEffect, useState} from 'react';
import {useHistory, useParams} from 'react-router-dom';
import axios from 'axios';
import { makeStyles } from '@material-ui/core/styles';
import { Paper, Typography, List, ListItem, ListItemText } from '@material-ui/core';

const useStyles = makeStyles({
    paper: {
        padding: '8px',
    }
});

const ReservationForm = (props) => {

    const classes = useStyles();
    const history = useHistory();
    const params = useParams();

    const [results, setResults] = useState([]);
    const [service, setService] = useState(null);
    const [specialist, setSpecialist] = useState(null);
    const [office, setOffice] = useState(null);

    useEffect(() => {
        let axiosConfig = {
            headers: {
                "Content-Type": 'application/json',
            }
        };

        let data = {
            service: params.service,
            specialist: params.specialist,
            office: params.office,
            dateFrom: params.from,
            dateTo: params.to
        };

        axios.post("https://api.szysza.ovh/api/search/details", data, axiosConfig)
            .then((res) => {
                setResults(toArray(res.data));
            })
            .catch((error) => {
                console.log(error)
            });

        axios.get(`https://api.szysza.ovh/api/services/${params.service}`)
            .then((res) => {
                setService(res.data);
            })
            .catch((error) => {
                console.log(error)
            });

        axios.get(`https://api.szysza.ovh/api/specialists/${params.specialist}`)
            .then((res) => {
                setSpecialist(res.data);
            })
            .catch((error) => {
                console.log(error)
            });

        axios.get(`https://api.szysza.ovh/api/offices/${params.office}`)
            .then((res) => {
                setOffice(res.data);
            })
            .catch((error) => {
                console.log(error)
            });

        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    const handleClick = (date) => {
        let axiosConfig = {
            headers: {
                "Content-Type": 'application/json',
            }
        };

        let data = {
            reservation_date: date,
            service: params.service,
            specialist: params.specialist,
            office: params.office,
        }

        axios.post("https://api.szysza.ovh/api/reservations", data, axiosConfig)
            .then((res) => {
                history.push('/reservations/list');
                window.open(res.data.url, "_blank");
            })
            .catch((error) => {
                console.log(error);
            })
    }

    const toArray = objects => {
        let array = [];
        for (const property in objects) {
            objects[property].forEach(value => {
                array.push(property + " " + value);
            })
        }
        return array;
    }

    return (
        <>
            <Paper className={classes.paper}>
                {service && <p>Usługa: {service.name} - {service.price}zł {service.duration}minut</p>}
                {specialist && <p>Specialista: {specialist.first_name} {specialist.last_name}</p>}
                {office && <p>Gabinet: {office.name} - {office.street} {office.houseNumber}, {office.zip} {office.city}</p>}
                <Typography variant="h6" gutterBottom>Wolne Terminy: </Typography>
                <List component="nav" aria-label="">
                    {results.map(result => {
                        return(
                            <ListItem
                                key = {result}
                                button
                                onClick={() => handleClick(result)}
                            >
                                <ListItemText primary={"Termin: " + result} />
                            </ListItem>
                        )
                    })}
                </List>
            </Paper>
        </>
    );
}

export default ReservationForm;