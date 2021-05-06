import React from 'react';
import {makeStyles} from "@material-ui/core/styles";
import {
    Paper,
    Typography,
    Table,
    TableHead,
    TableRow,
    TableCell,
    TableBody,
} from "@material-ui/core";

const useStyles = makeStyles({
    paper: {
        padding: '8px',
        marginBottom: '10px',
    }
});

const TabResult = (props) => {
    const classes = useStyles();

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
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {props.result && props.result.map((row, index) => (
                            <TableRow key={index}>
                                <TableCell align="center" component="th" scope="row">{index}</TableCell>
                                <TableCell align="center">{row.office}</TableCell>
                                <TableCell align="center">{row.specialist}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </Paper>
        </>
    );
}

export default TabResult;