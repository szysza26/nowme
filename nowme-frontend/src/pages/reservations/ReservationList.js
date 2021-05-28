import React, {useState, useEffect} from 'react';
import axios from "axios";
import { makeStyles } from '@material-ui/core/styles';
import { Paper, Typography, Table, TableBody, TableHead, TableRow, TableCell, Button } from '@material-ui/core';
import Calendar from "./Calendar";

const useStyles = makeStyles({
    paper: {
        padding: '8px',
        marginBottom: '16px'
    }
});

const ReservationList = (props) => {

    const classes = useStyles();

    const [reservations, setReservations] = useState([]);

    const handleClickDelete = (id) => {
        axios.delete(`https://api.szysza.ovh/api/reservations/${id}`)
            .then((res) => {
                setReservations(reservations.filter(reservation => reservation.id !== id));
            })
            .catch((error) => {
                console.log(error)
            })
    }

    useEffect(() => {
        axios.get(`https://api.szysza.ovh/api/reservations`)
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
                            <TableCell align="center">Usługa</TableCell>
                            <TableCell align="center">Cena</TableCell>
                            <TableCell align="center">Data</TableCell>
                            <TableCell align="center">Od</TableCell>
                            <TableCell align="center">Do</TableCell>
                            <TableCell align="center">Specialista</TableCell>
                            <TableCell align="center">Gabinet</TableCell>
                            <TableCell align="center">Akcja</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {reservations.map((row, index) => (
                            <TableRow key={row.id}>
                                <TableCell align="center">{row.service.name}</TableCell>
                                <TableCell align="center">{row.service.price}</TableCell>
                                <TableCell align="center">{row.reservation_date}</TableCell>
                                <TableCell align="center">{row.reservation_hour_from}</TableCell>
                                <TableCell align="center">{row.reservation_hour_to}</TableCell>
                                <TableCell align="center">{row.specialist.name}</TableCell>
                                <TableCell align="center">{row.office_address}</TableCell>
                                <TableCell align="center">
                                    <Button onClick={() => handleClickDelete(row.id)} size="small" color="secondary">Anuluj</Button>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </Paper>
            <Paper className={classes.paper}>
                <Calendar reservations={reservations}/>
            </Paper>
        </>
    );
}

export default ReservationList;