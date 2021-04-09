import React from 'react';
import { makeStyles } from '@material-ui/core/styles';
import { Table, TableBody, TableCell, TableHead, TableRow } from '@material-ui/core';

import SpecRow from './SpecRow';

const useStyles = makeStyles({
    table: {
        minWidth: 500,
    },
});

const SpecList = (props) => {
    const classes = useStyles();

    return (
        <Table className={classes.table} aria-label="simple table">
            <TableHead>
                <TableRow>
                    <TableCell align="center">Id</TableCell>
                    <TableCell align="center">Imię</TableCell>
                    <TableCell align="center">Nazwisko</TableCell>
                    <TableCell align="center">Specjalizacja</TableCell>
                    <TableCell align="center">Akcja</TableCell>
                </TableRow>
            </TableHead>
            <TableBody>
            {props.data.map((row, index) => (
                <SpecRow key={index} data={row}/>
            ))}
            </TableBody>
        </Table>
    )
}

export default SpecList;