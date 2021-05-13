import React from 'react';
import {makeStyles} from "@material-ui/core/styles";
import {
    Paper,
    Typography,
    Table,
    TableHead,
    TableRow,
    TableCell,
    TableBody, Button,
} from "@material-ui/core";
import {useHistory} from 'react-router-dom';

const useStyles = makeStyles({
    paper: {
        padding: '8px',
        marginBottom: '10px',
    }
});

const TabResult = (props) => {
    const classes = useStyles();
    const history = useHistory();

    const handleClick = (id) => {
        history.push(`/reservations/${id}`);
    }

    return (
        <>
            <Paper className={classes.paper}>
                <Typography variant="h6" gutterBottom>Wyniki: </Typography>
                <Table className={classes.table} aria-label="simple table">
                    <TableHead>
                        <TableRow>
                            <TableCell align="center">ID</TableCell>
                            <TableCell align="center">Gabinet</TableCell>
                            <TableCell align="center">Specialista</TableCell>
                            <TableCell align="center">Rezerwacja</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {props.result && props.result.map((row, index) => (
                            <TableRow key={index}>
                                <TableCell align="center" component="th" scope="row">{index}</TableCell>
                                <TableCell align="center">{row.office}</TableCell>
                                <TableCell align="center">{row.specialist}</TableCell>
                                <TableCell align="center">
                                    <Button onClick={() => handleClick(row.service)} size="small" color="primary">Rezerwuj</Button>
                                </TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </Paper>
        </>
    );
}

export default TabResult;