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

const OfficesList = (props) => {
    const classes = useStyles();
    const [offices, setOffices] = useState(null);
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

        axios.get("https://api.szysza.ovh/api/offices")
            .then((res) => {
                setOffices(res.data)
            })
            .catch((error) => {
                console.log(error)
            });
    
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    const handleClickShow = (id) => {
        history.push(`/offices/show/${id}`);
    }
    const handleClickEdit = (id) => {
        history.push(`/offices/edit/${id}`);
    }
    const handleClickDelete = (id) => {      
        axios.delete(`https://api.szysza.ovh/api/offices/${id}`)
            .then((res) => {
              setSuccess(true);
              setOffices(offices.filter(office => office.id !== id));
            })
            .catch((error) => {
              console.log(error)
              setError(true);
            })
    }

    return (
    <>
        <Paper className={classes.paper}>
            <Typography variant="h6" gutterBottom>Lista Gabinetów: </Typography>
            {success && <Alert severity="success">Sukces</Alert>}
            {error && <Alert severity="error">Niepowodzenie</Alert>}
            <Table className={classes.table} aria-label="simple table">
                <TableHead>
                    <TableRow>
                        <TableCell align="center">Id</TableCell>
                        <TableCell align="center">Nazwa</TableCell>
                        <TableCell align="center">Miasto</TableCell>
                        <TableCell align="center">Akcja</TableCell>
                    </TableRow>
                </TableHead>
                <TableBody>
                {offices && offices.map((row, index) => (
                    <TableRow key={row.id}>
                        <TableCell align="center" component="th" scope="row">{row.id}</TableCell>
                        <TableCell align="center">{row.name}</TableCell>
                        <TableCell align="center">{row.city}</TableCell>
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

export default OfficesList;