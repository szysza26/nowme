import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Paper from '@material-ui/core/Paper';
import { ButtonGroup, Button } from '@material-ui/core';

const useStyles = makeStyles({
    table: {
        minWidth: 500,
      },
  });

const rows = [
    {name: "Jan Kowalski", specialist: "Barber", score: 9},
    {name: "Jan Kowalski", specialist: "Barber", score: 9},
    {name: "Jan Kowalski", specialist: "Barber", score: 9},
    {name: "Jan Kowalski", specialist: "Barber", score: 9},
    {name: "Jan Kowalski", specialist: "Barber", score: 9},
    {name: "Jan Kowalski", specialist: "Barber", score: 9},
];

const SpecialistsList = (props) => {
    const classes = useStyles();

    return (
        <TableContainer component={Paper}>
            <Table className={classes.table} aria-label="simple table">
                <TableHead>
                <TableRow>
                    <TableCell align="center">Imię i Nazwisko</TableCell>
                    <TableCell align="center">Specjalizacja</TableCell>
                    <TableCell align="center">Ocena</TableCell>
                    <TableCell align="center">Akcja</TableCell>
                </TableRow>
                </TableHead>
                <TableBody>
                {rows.map((row, index) => (
                    <TableRow key={index}>
                    <TableCell align="center" component="th" scope="row">{row.name}</TableCell>
                    <TableCell align="center">{row.specialist}</TableCell>
                    <TableCell align="center">{row.score}</TableCell>
                    <TableCell align="center">
                    <ButtonGroup variant="contained" aria-label="contained button group">
                        <Button size="small" color="primary">Show</Button>
                        <Button size="small">Edit</Button>
                        <Button size="small" color="secondary">Delete</Button>
                    </ButtonGroup>
                    </TableCell>
                    </TableRow>
                ))}
                </TableBody>
            </Table>
        </TableContainer>
      );
}

export default SpecialistsList;