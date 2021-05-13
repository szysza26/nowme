import React, {useState, useEffect} from 'react';
import axios from "axios";
import { makeStyles } from '@material-ui/core/styles';
import { Paper, Typography, Table, TableBody, TableHead, TableRow, TableCell, Button } from '@material-ui/core';

const useStyles = makeStyles({
    paper: {
        padding: '8px',
    }
});

const ReservationList = (props) => {

    const classes = useStyles();

    const [reservations, setReservations] = useState([]);

    const handleClickDelete = (id) => {
        axios.delete(`http://localhost:8000/api/reservations/${id}`)
            .then((res) => {
                setReservations(reservations.filter(reservation => reservation.id !== id));
            })
            .catch((error) => {
                console.log(error)
            })
    }

    useEffect(() => {
        axios.get(`http://localhost:8000/api/reservations`)
            .then((res) => {
                setReservations(res.data);
            })
            .catch((error) => {
                console.log(error)
            });

        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    return (
        <>
            <Paper className={classes.paper}>
                <Typography variant="h6" gutterBottom>Rezerwacje: </Typography>
                <Table className={classes.table} aria-label="simple table">
                    <TableHead>
                        <TableRow>
                            <TableCell align="center">Id</TableCell>
                            <TableCell align="center">Usługa</TableCell>
                            <TableCell align="center">Data</TableCell>
                            <TableCell align="center">Akcja</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {reservations.map((row, index) => (
                            <TableRow key={row.id}>
                                <TableCell align="center" component="th" scope="row">{row.id}</TableCell>
                                <TableCell align="center">{row.service}</TableCell>
                                <TableCell align="center">{row.date}</TableCell>
                                <TableCell align="center">
                                    <Button onClick={() => handleClickDelete(row.id)} size="small" color="secondary">Anuluj</Button>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </Paper>
        </>
    );
}

export default ReservationList;