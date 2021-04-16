import React, {useState, useEffect} from 'react';
import {useHistory} from 'react-router-dom';
import axios from 'axios';
import { makeStyles } from '@material-ui/core/styles';
import { Paper, Typography, Table, TableBody, TableHead, TableRow, TableCell, Button, ButtonGroup } from '@material-ui/core';
import Alert from '@material-ui/lab/Alert';

const useStyles = makeStyles({
    paper: {
        padding: '8px',
    }
});

const ServicesList = (props) => {
    const classes = useStyles();
    const [services, setServices] = useState(null);
    const history = useHistory();

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

        axios.get("http://localhost:8000/api/services")
            .then((res) => {
                setServices(res.data)
            })
            .catch((error) => {
                console.log(error)
            });
    
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    const handleClickShow = (id) => {
        history.push(`/services/show/${id}`);
    }
    const handleClickEdit = (id) => {
        history.push(`/services/edit/${id}`);
    }
    const handleClickDelete = (id) => {      
        axios.delete(`http://localhost:8000/api/services/${id}`)
            .then((res) => {
              setSuccess(true);
                setServices(services.filter(service => service.id !== id));
            })
            .catch((error) => {
              console.log(error)
              setError(true);
            })
    }

    return (
    <>
        <Paper className={classes.paper}>
            <Typography variant="h6" gutterBottom>Lista usług: </Typography>
            {success && <Alert severity="success">Sukces</Alert>}
            {error && <Alert severity="error">Niepowodzenie</Alert>}
            <Table className={classes.table} aria-label="simple table">
                <TableHead>
                    <TableRow>
                        <TableCell align="center">Id</TableCell>
                        <TableCell align="center">Nazwa</TableCell>
                        <TableCell align="center">Cena</TableCell>
                        <TableCell align="center">Czas</TableCell>
                        <TableCell align="center">Akcja</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                {services && services.map((row, index) => (
                    <TableRow key={row.id}>
                        <TableCell align="center" component="th" scope="row">{row.id}</TableCell>
                        <TableCell align="center">{row.name}</TableCell>
                        <TableCell align="center">{row.price}</TableCell>
                        <TableCell align="center">{row.duration}</TableCell>
                        <TableCell align="center">
                            <ButtonGroup variant="contained" aria-label="contained button group">
                                <Button onClick={() => handleClickShow(row.id)} size="small" color="primary">Show</Button>
                                <Button onClick={() => handleClickEdit(row.id)} size="small">Edit</Button>
                                <Button onClick={() => handleClickDelete(row.id)} size="small" color="secondary">Delete</Button>
                            </ButtonGroup>
                        </TableCell>
                    </TableRow>
                ))}
                </TableBody>
            </Table>
        </Paper>
    </>
    );
}

export default ServicesList;